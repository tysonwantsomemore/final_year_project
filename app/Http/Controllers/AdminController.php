<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use App\Models\Color;
use App\Models\Size;
use App\Models\Order;
use App\Models\Review;
use App\Models\OrderItem;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function getStats()
    {
        $totalRevenue = Order::where('order_status', '!=', 'Cancelled')->sum('total_amount');
        $productCount = Product::count();
        $reviewCount = Review::count();
        $orderCount = Order::count();

        // Fetch recent activities dynamically (recent orders and recent reviews)
        $recentOrders = Order::orderBy('created_at', 'desc')->take(5)->get()->map(function($order) {
            return [
                'type' => 'order',
                'description' => "Đơn hàng mới #{$order->id} từ khách hàng {$order->customer_name} trị giá " . number_format($order->total_amount) . "đ",
                'time' => $order->created_at->diffForHumans()
            ];
        });

        $recentReviews = Review::with('product')->orderBy('created_at', 'desc')->take(5)->get()->map(function($review) {
            $prodName = $review->product ? $review->product->name : 'Sản phẩm';
            return [
                'type' => 'review',
                'description' => "Khách hàng {$review->customer_name} đã đánh giá {$review->rating}★ cho \"{$prodName}\"",
                'time' => $review->created_at->diffForHumans()
            ];
        });

        $activities = $recentOrders->concat($recentReviews)->toArray();

        // Fetch monthly revenue for the last 6 months
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $revenue = Order::where('order_status', '!=', 'Cancelled')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total_amount');
            
            $monthlyRevenue[] = [
                'month' => "Tháng " . $date->format('m/Y'),
                'revenue' => (float)$revenue
            ];
        }

        // Fetch revenue distribution by category
        $categories = Category::all();
        $categoryRevenue = [];
        foreach ($categories as $category) {
            $rev = OrderItem::whereHas('order', function($q) {
                    $q->where('order_status', '!=', 'Cancelled');
                })
                ->whereHas('product', function($q) use ($category) {
                    $q->where('category_id', $category->id);
                })
                ->sum('total_price');
                
            $categoryRevenue[] = [
                'category' => $category->name,
                'revenue' => (float)$rev
            ];
        }

        return response()->json([
            'total_revenue' => $totalRevenue,
            'order_count' => $orderCount,
            'product_count' => $productCount,
            'review_count' => $reviewCount,
            'activities' => $activities,
            'monthly_revenue' => $monthlyRevenue,
            'category_revenue' => $categoryRevenue
        ]);
    }

    public function getProducts()
    {
        $products = Product::with(['category', 'images', 'variants.color', 'variants.size', 'reviews'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($product) {
                return $this->mapProductToFrontend($product);
            });

        return response()->json($products);
    }

    public function createProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'tag' => 'nullable|string|max:50',
            'sizes' => 'nullable|string',
            'colors' => 'nullable|string',
            'description' => 'nullable|string',
            'thumbnail_url' => 'nullable|string',
            'stock' => 'nullable|integer|min:0',
            'variant_data' => 'nullable|string'
        ]);

        $basePrice = $request->old_price ?: $request->price;
        $salePrice = $request->old_price ? $request->price : null;

        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . time(),
            'sku' => 'PROD-' . strtoupper(Str::random(6)),
            'short_description' => substr($request->description, 0, 100),
            'description' => $request->description,
            'base_price' => $basePrice,
            'sale_price' => $salePrice,
            'gender' => 'Unisex',
            'status' => 'Active',
            'is_featured' => ($request->tag === 'Hot' || $request->tag === 'Nổi bật'),
            'published_at' => now(),
        ]);

        // Sync variants and images
        $this->syncProductVariantsAndImages($product, $request);

        return response()->json([
            'message' => 'Thêm sản phẩm thành công!',
            'product' => $this->mapProductToFrontend($product)
        ]);
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Sản phẩm không tồn tại'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'tag' => 'nullable|string|max:50',
            'sizes' => 'nullable|string',
            'colors' => 'nullable|string',
            'description' => 'nullable|string',
            'thumbnail_url' => 'nullable|string',
            'stock' => 'nullable|integer|min:0',
            'variant_data' => 'nullable|string'
        ]);

        $basePrice = $request->old_price ?: $request->price;
        $salePrice = $request->old_price ? $request->price : null;

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'base_price' => $basePrice,
            'sale_price' => $salePrice,
            'is_featured' => ($request->tag === 'Hot' || $request->tag === 'Nổi bật'),
        ]);

        // Re-sync variants and images
        $this->syncProductVariantsAndImages($product, $request);

        return response()->json([
            'message' => 'Cập nhật sản phẩm thành công!',
            'product' => $this->mapProductToFrontend($product)
        ]);
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Sản phẩm không tồn tại'], 404);
        }

        $product->delete();

        return response()->json([
            'message' => 'Xóa sản phẩm thành công!'
        ]);
    }

    public function restoreDefaults()
    {
        try {
            DB::statement('PRAGMA foreign_keys = OFF');
            
            // Truncate all tables in database
            $tables = [
                'roles', 'users', 'user_addresses', 'password_reset_tokens',
                'colors', 'sizes', 'brands', 'categories', 'products',
                'product_variants', 'product_images', 'product_size_guides',
                'inventory_transactions', 'product_tags', 'product_tag_items',
                'product_collections', 'product_collection_items', 'wishlists',
                'carts', 'cart_items', 'shipping_methods', 'vouchers',
                'voucher_usages', 'orders', 'order_items', 'shipments',
                'payment_transactions', 'order_status_histories', 'banners',
                'settings', 'blog_categories', 'blog_posts', 'reviews',
                'review_images', 'returns', 'return_items', 'refunds',
                'contacts', 'notifications'
            ];

            foreach ($tables as $table) {
                DB::table($table)->truncate();
            }

            DB::statement('PRAGMA foreign_keys = ON');

            // Re-seed
            Artisan::call('db:seed', ['--force' => true]);

            return response()->json([
                'message' => 'Đã khôi phục dữ liệu mẫu thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Lỗi khôi phục: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getOrders()
    {
        $orders = Order::with(['orderItems.product.images'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($order) {
                return $this->mapOrderToFrontend($order);
            });
            
        return response()->json($orders);
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::with('orderItems')->find($id);
        if (!$order) {
            return response()->json(['message' => 'Đơn hàng không tồn tại'], 404);
        }

        if ($order->order_status === 'Completed' || $order->order_status === 'Cancelled') {
            return response()->json(['message' => 'Không thể thay đổi trạng thái của đơn hàng đã giao hoặc đã hủy.'], 400);
        }

        $request->validate([
            'status' => 'required|string|in:Pending,Processing,Shipping,Completed,Cancelled'
        ]);

        $newStatus = $request->status;

        try {
            return DB::transaction(function() use ($order, $newStatus) {
                if ($newStatus === 'Cancelled') {
                    // Restore stock
                    foreach ($order->orderItems as $item) {
                        $variant = ProductVariant::lockForUpdate()->find($item->product_variant_id);
                        if ($variant) {
                            $variant->increment('stock_quantity', $item->quantity);
                        }
                    }
                }

                if ($newStatus === 'Completed') {
                    $order->payment_status = 'Paid';
                }

                $oldStatus = $order->order_status;
                $order->order_status = $newStatus;
                $order->save();

                // Log status history
                \App\Models\OrderStatusHistory::create([
                    'order_id' => $order->id,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'note' => 'Cập nhật trạng thái từ Admin Dashboard',
                ]);

                return response()->json([
                    'message' => 'Cập nhật trạng thái đơn hàng thành công!',
                    'order' => $this->mapOrderToFrontend($order)
                ]);
            });
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi cập nhật trạng thái đơn hàng: ' . $e->getMessage()], 400);
        }
    }

    public function deleteOrder($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Đơn hàng không tồn tại'], 404);
        }

        $order->delete();

        return response()->json([
            'message' => 'Xóa đơn hàng thành công!'
        ]);
    }

    public function getVouchers()
    {
        $vouchers = \App\Models\Voucher::orderBy('created_at', 'desc')->get()->map(function($voucher) {
            $voucher->discount_percent = $voucher->discount_value;
            $voucher->max_discount = $voucher->max_discount_amount;
            $voucher->expiry_date = $voucher->end_date;
            return $voucher;
        });
        return response()->json($vouchers);
    }

    public function createVoucher(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:vouchers,code',
            'discount_percent' => 'required|numeric|min:0|max:100',
            'max_discount' => 'nullable|numeric|min:0',
            'expiry_date' => 'required|date',
            'usage_limit' => 'nullable|integer|min:0'
        ]);

        $voucher = \App\Models\Voucher::create([
            'code' => $request->code,
            'name' => 'Mã giảm giá ' . $request->code,
            'discount_type' => 'percent',
            'discount_value' => $request->discount_percent,
            'max_discount_amount' => $request->max_discount ?: null,
            'min_order_amount' => 0,
            'start_date' => now(),
            'end_date' => $request->expiry_date,
            'usage_limit' => $request->usage_limit ?: null,
            'status' => 'Active',
        ]);

        return response()->json([
            'message' => 'Tạo voucher thành công!',
            'voucher' => [
                'id' => $voucher->id,
                'code' => $voucher->code,
                'discount_percent' => $voucher->discount_value,
                'max_discount' => $voucher->max_discount_amount,
                'usage_limit' => $voucher->usage_limit,
                'expiry_date' => $voucher->end_date,
                'created_at' => $voucher->created_at,
                'updated_at' => $voucher->updated_at
            ]
        ]);
    }

    public function updateVoucher(Request $request, $id)
    {
        $voucher = \App\Models\Voucher::find($id);
        if (!$voucher) {
            return response()->json(['message' => 'Voucher không tồn tại'], 404);
        }

        $request->validate([
            'code' => 'required|string|unique:vouchers,code,' . $id,
            'discount_percent' => 'required|numeric|min:0|max:100',
            'max_discount' => 'nullable|numeric|min:0',
            'expiry_date' => 'required|date',
            'usage_limit' => 'nullable|integer|min:0'
        ]);

        $voucher->update([
            'code' => $request->code,
            'discount_value' => $request->discount_percent,
            'max_discount_amount' => $request->max_discount ?: null,
            'end_date' => $request->expiry_date,
            'usage_limit' => $request->usage_limit ?: null,
        ]);

        return response()->json([
            'message' => 'Cập nhật voucher thành công!',
            'voucher' => [
                'id' => $voucher->id,
                'code' => $voucher->code,
                'discount_percent' => $voucher->discount_value,
                'max_discount' => $voucher->max_discount_amount,
                'usage_limit' => $voucher->usage_limit,
                'expiry_date' => $voucher->end_date,
                'created_at' => $voucher->created_at,
                'updated_at' => $voucher->updated_at
            ]
        ]);
    }

    public function deleteVoucher($id)
    {
        $voucher = \App\Models\Voucher::find($id);
        if (!$voucher) {
            return response()->json(['message' => 'Voucher không tồn tại'], 404);
        }

        $voucher->delete();

        return response()->json([
            'message' => 'Xóa voucher thành công!'
        ]);
    }

    public function getReviews()
    {
        return response()->json(Review::with('product')->orderBy('created_at', 'desc')->get());
    }

    public function deleteReview($id)
    {
        $review = Review::find($id);
        if (!$review) {
            return response()->json(['message' => 'Đánh giá không tồn tại'], 404);
        }

        $productId = $review->product_id;
        $review->delete();

        return response()->json([
            'message' => 'Xóa đánh giá thành công!'
        ]);
    }

    public function getUsers()
    {
        return response()->json(\App\Models\User::orderBy('created_at', 'desc')->get());
    }

    public function updateUser(Request $request, $id)
    {
        $user = \App\Models\User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Người dùng không tồn tại'], 404);
        }

        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string|in:Admin,Customer',
            'password' => 'nullable|string|min:6'
        ]);

        $role = Role::where('name', $data['role'])->first();

        $updateData = [
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'role_id' => $role ? $role->id : 2,
        ];

        if (!empty($data['password'])) {
            $updateData['password_hash'] = \Illuminate\Support\Facades\Hash::make($data['password']);
        }

        $user->update($updateData);

        return response()->json([
            'message' => 'Cập nhật tài khoản thành công!',
            'user' => $user
        ]);
    }

    public function deleteUser($id)
    {
        $user = \App\Models\User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Người dùng không tồn tại'], 404);
        }

        if (\Illuminate\Support\Facades\Auth::id() == $id) {
            return response()->json(['message' => 'Không thể tự xóa tài khoản của chính mình'], 400);
        }

        $user->delete();

        return response()->json([
            'message' => 'Xóa tài khoản thành công!'
        ]);
    }

    // --- Private Helper Methods ---

    private function mapProductToFrontend($product)
    {
        $primaryImage = $product->images->where('is_primary', true)->first() ?? $product->images->first();
        
        $sizes = $product->variants->map(function($v) {
            return $v->size?->name;
        })->filter()->unique()->values()->join(', ');

        $colors = $product->variants->map(function($v) {
            return $v->color?->name;
        })->filter()->unique()->values()->join(', ');

        $stock = $product->variants->sum('stock_quantity');

        $colorsOffset = [];
        $sizesOffset = [];

        foreach ($product->variants as $v) {
            if ($v->color && !isset($colorsOffset[$v->color->name])) {
                $colorImg = $product->images->where('color_id', $v->color_id)->first() ?? $primaryImage;
                $colorsOffset[$v->color->name] = [
                    'image' => $colorImg ? $colorImg->image_url : 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=600&auto=format&fit=crop&q=80',
                    'price_offset' => 0
                ];
            }
            if ($v->size && !isset($sizesOffset[$v->size->name])) {
                $sizesOffset[$v->size->name] = [
                    'price_offset' => 0
                ];
            }
        }

        $variantData = [
            'colors' => $colorsOffset,
            'sizes' => $sizesOffset
        ];

        return [
            'id' => $product->id,
            'category_id' => $product->category_id,
            'name' => $product->name,
            'slug' => $product->slug,
            'sku' => $product->sku,
            'short_description' => $product->short_description,
            'description' => $product->description,
            'price' => $product->sale_price ?? $product->base_price,
            'old_price' => $product->sale_price ? $product->base_price : null,
            'thumbnail_url' => $primaryImage ? $primaryImage->image_url : 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=600&auto=format&fit=crop&q=80',
            'tag' => $product->is_featured ? 'Nổi bật' : 'Mới',
            'rating' => $product->reviews->avg('rating') ? round($product->reviews->avg('rating'), 1) : 5.0,
            'sizes' => $sizes ?: 'Free Size',
            'colors' => $colors ?: 'Mặc định',
            'stock' => $stock,
            'variant_data' => json_encode($variantData),
            'category' => $product->category,
            'reviews' => $product->reviews,
        ];
    }

    private function syncProductVariantsAndImages($product, Request $request)
    {
        $sizesArr = array_map('trim', explode(',', $request->sizes ?: 'S, M, L, XL'));
        $colorsArr = array_map('trim', explode(',', $request->colors ?: 'Trắng, Đen'));

        // Delete old variants & images
        $product->variants()->delete();
        $product->images()->delete();

        $primaryImageCreated = false;
        foreach ($colorsArr as $cIndex => $colName) {
            $colorModel = Color::firstOrCreate(
                ['name' => $colName],
                ['hex_code' => $this->getRandomHexCode($colName)]
            );

            $imageUrl = $request->thumbnail_url ?: 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=600&auto=format&fit=crop&q=80';

            ProductImage::create([
                'product_id' => $product->id,
                'color_id' => $colorModel->id,
                'image_url' => $imageUrl,
                'alt_text' => "{$product->name} màu {$colName}",
                'is_primary' => !$primaryImageCreated,
                'sort_order' => $cIndex,
            ]);
            $primaryImageCreated = true;

            foreach ($sizesArr as $szName) {
                $sizeModel = Size::firstOrCreate(
                    ['name' => $szName],
                    ['sort_order' => 10]
                );

                ProductVariant::create([
                    'product_id' => $product->id,
                    'size_id' => $sizeModel->id,
                    'color_id' => $colorModel->id,
                    'sku' => "{$product->sku}-" . strtoupper(Str::slug($colName)) . "-{$szName}",
                    'price' => $product->base_price,
                    'sale_price' => $product->sale_price,
                    'stock_quantity' => isset($request->stock) ? $request->stock : 50,
                    'status' => 'Active',
                ]);
            }
        }
    }

    private function getRandomHexCode($colorName)
    {
        $colors = [
            'Trắng' => '#FFFFFF', 'Đen' => '#000000', 'Xám' => '#808080',
            'Be' => '#F5F5DC', 'Xanh Bơ' => '#568203', 'Hồng nhạt' => '#FFB6C1',
            'Xanh Đậm' => '#00008B', 'Xanh Sáng' => '#87CEEB', 'Xanh Navy' => '#000080',
            'Xanh Rêu' => '#4F7942', 'Kem' => '#FFFDD0', 'Nâu hạt dẻ' => '#705335'
        ];
        return $colors[$colorName] ?? '#' . substr(md5($colorName), 0, 6);
    }

    private function mapOrderToFrontend($order)
    {
        $items = $order->orderItems->map(function($item) {
            $primaryImage = $item->product ? ($item->product->images->where('is_primary', true)->first() ?? $item->product->images->first()) : null;
            return [
                'id' => $item->id,
                'order_id' => $item->order_id,
                'product_id' => $item->product_id,
                'price' => $item->price_at_purchase,
                'quantity' => $item->quantity,
                'size' => $item->size_name_snapshot,
                'color' => $item->color_name_snapshot,
                'product' => [
                    'id' => $item->product_id,
                    'name' => $item->product_name_snapshot,
                    'thumbnail_url' => $primaryImage ? $primaryImage->image_url : 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=600&auto=format&fit=crop&q=80'
                ]
            ];
        });

        $voucher = null;
        if ($order->voucher) {
            $voucher = [
                'id' => $order->voucher->id,
                'code' => $order->voucher->code,
                'discount_percent' => $order->voucher->discount_type === 'percent' ? $order->voucher->discount_value : null,
                'max_discount' => $order->voucher->max_discount_amount,
                'min_order_value' => $order->voucher->min_order_amount,
                'expiry_date' => $order->voucher->end_date->format('Y-m-d H:i:s'),
            ];
        }

        return [
            'id' => $order->id,
            'user_id' => $order->user_id,
            'status' => $order->order_status,
            'customer_name' => $order->customer_name,
            'customer_phone' => $order->customer_phone,
            'customer_address' => $order->shipping_address_snapshot,
            'customer_note' => $order->note,
            'payment_method' => $order->payment_method,
            'payment_status' => $order->payment_status,
            'total_amount' => $order->total_amount,
            'shipping_fee' => $order->shipping_fee,
            'voucher_id' => $order->voucher_id,
            'created_at' => $order->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $order->updated_at->format('Y-m-d H:i:s'),
            'order_items' => $items,
            'voucher' => $voucher,
        ];
    }
}
