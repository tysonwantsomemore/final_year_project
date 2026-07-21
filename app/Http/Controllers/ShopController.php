<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Color;
use App\Models\Size;
use App\Models\Voucher;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use App\Models\ReviewImage;
use App\Models\Shipment;
use App\Models\PaymentTransaction;
use App\Models\OrderStatusHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function getCategories()
    {
        return response()->json(Category::where('status', 'Active')->orderBy('sort_order')->get());
    }

    public function getProducts(Request $request)
    {
        $query = Product::with(['images', 'variants.color', 'variants.size', 'tags']);

        // 1. Search Query
        if ($request->filled('search')) {
            $search = '%' . $request->input('search') . '%';
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', $search)
                  ->orWhere('description', 'like', $search);
            });
        }

        // 2. Category
        if ($request->filled('category') && $request->input('category') !== 'all') {
            $categorySlug = $request->input('category');
            $category = Category::where('slug', $categorySlug)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // 3. Price Filter
        if ($request->filled('max_price')) {
            $maxPrice = $request->input('max_price');
            $query->where(function($q) use ($maxPrice) {
                $q->where('base_price', '<=', $maxPrice)
                  ->orWhere('sale_price', '<=', $maxPrice);
            });
        }

        // 4. Tag Filter
        if ($request->filled('tag')) {
            $tagQuery = $request->input('tag');
            $query->whereHas('tags', function($q) use ($tagQuery) {
                $q->where('name', 'like', '%' . $tagQuery . '%');
            });
        }

        $products = $query->get()->map(function($product) {
            return $this->mapProductToFrontend($product);
        });

        // 5. Sorting
        $sort = $request->input('sort', 'default');
        if ($sort === 'price-asc') {
            $products = $products->sortBy('price')->values();
        } elseif ($sort === 'price-desc') {
            $products = $products->sortByDesc('price')->values();
        } elseif ($sort === 'rating-desc') {
            $products = $products->sortByDesc('rating')->values();
        }

        return response()->json($products);
    }

    public function getProductDetails($id)
    {
        $product = Product::with([
            'category', 
            'images', 
            'variants.color', 
            'variants.size', 
            'tags', 
            'reviews.user',
            'reviews.images'
        ])->find($id);

        if (!$product) {
            return response()->json(['message' => 'Sản phẩm không tồn tại'], 404);
        }

        return response()->json($this->mapProductToFrontend($product));
    }

    public function submitReview(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'customer_name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $user = Auth::user();
        if (!$user) {
            // Find or create guest user
            $user = User::where('email', 'guest@beestyle.vn')->first();
            if (!$user) {
                $customerRole = \App\Models\Role::where('name', 'Customer')->first();
                $user = User::create([
                    'role_id' => $customerRole ? $customerRole->id : 2,
                    'full_name' => 'Khách Vãng Lai',
                    'email' => 'guest@beestyle.vn',
                    'password_hash' => bcrypt(Str::random(16)),
                    'phone' => '0900000000',
                ]);
            }
        }

        // Find a matching completed order item or fallback to first order item of this product
        $orderItem = OrderItem::where('product_id', $request->product_id)
            ->whereHas('order', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })->first();

        if (!$orderItem) {
            $orderItem = OrderItem::where('product_id', $request->product_id)->first();
        }

        if (!$orderItem) {
            // Create dummy order/item to satisfy FK
            $dummyOrder = Order::create([
                'user_id' => $user->id,
                'order_code' => 'DUMMY-' . strtoupper(Str::random(8)),
                'customer_name' => $user->full_name,
                'customer_phone' => $user->phone ?? '0900000000',
                'shipping_address_snapshot' => 'N/A',
                'subtotal' => 0,
                'total_amount' => 0,
                'payment_method' => 'cod',
                'order_status' => 'Completed',
            ]);
            $firstVariant = ProductVariant::where('product_id', $request->product_id)->first();
            $orderItem = OrderItem::create([
                'order_id' => $dummyOrder->id,
                'product_id' => $request->product_id,
                'product_variant_id' => $firstVariant->id,
                'product_name_snapshot' => Product::find($request->product_id)->name,
                'sku_snapshot' => $firstVariant->sku,
                'size_name_snapshot' => $firstVariant->size->name,
                'color_name_snapshot' => $firstVariant->color->name,
                'quantity' => 1,
                'price_at_purchase' => $firstVariant->price,
                'total_price' => $firstVariant->price,
            ]);
        }

        // Check if review already exists for this order item to avoid duplicate key error
        $existingReview = Review::where('user_id', $user->id)
            ->where('order_item_id', $orderItem->id)
            ->first();

        if ($existingReview) {
            $existingReview->update([
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);
            $review = $existingReview;
        } else {
            $review = Review::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
                'order_item_id' => $orderItem->id,
                'rating' => $request->rating,
                'comment' => $request->comment,
                'status' => 'Approved',
            ]);
        }

        return response()->json([
            'message' => 'Gửi đánh giá thành công!',
            'review' => $review,
            'new_rating' => $request->rating
        ]);
    }

    public function applyVoucher(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'order_value' => 'required|numeric|min:0',
        ]);

        $voucher = Voucher::where('code', $request->code)->first();

        if (!$voucher || $voucher->status !== 'Active') {
            return response()->json(['message' => 'Mã giảm giá không hợp lệ hoặc đã bị khóa'], 400);
        }

        if ($voucher->start_date && now()->lt($voucher->start_date)) {
            return response()->json(['message' => 'Mã giảm giá chưa đến hạn sử dụng'], 400);
        }

        if ($voucher->end_date && now()->gt($voucher->end_date)) {
            return response()->json(['message' => 'Mã giảm giá đã hết hạn sử dụng'], 400);
        }

        if ($voucher->min_order_amount && $request->order_value < $voucher->min_order_amount) {
            return response()->json([
                'message' => 'Đơn hàng chưa đạt giá trị tối thiểu ' . number_format($voucher->min_order_amount) . 'đ'
            ], 400);
        }

        if ($voucher->usage_limit !== null && $voucher->used_count >= $voucher->usage_limit) {
            return response()->json(['message' => 'Mã giảm giá đã hết lượt sử dụng'], 400);
        }

        // Calculate discount
        $discountAmount = 0;
        if ($voucher->discount_type === 'percent') {
            $discountAmount = ($request->order_value * $voucher->discount_value) / 100;
        } else {
            $discountAmount = $voucher->discount_value;
        }

        if ($voucher->max_discount_amount && $discountAmount > $voucher->max_discount_amount) {
            $discountAmount = $voucher->max_discount_amount;
        }

        return response()->json([
            'message' => 'Áp dụng mã giảm giá thành công!',
            'code' => $voucher->code,
            'voucher_id' => $voucher->id,
            'discount_amount' => $discountAmount
        ]);
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'customer_note' => 'nullable|string',
            'payment_method' => 'required|string|in:cod,bank,online_vnpay',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.size' => 'nullable|string',
            'items.*.color' => 'nullable|string',
            'total_amount' => 'required|numeric|min:0',
            'voucher_id' => 'nullable|exists:vouchers,id',
        ]);

        try {
            return DB::transaction(function() use ($request) {
                $user = Auth::user();
                $paymentStatus = 'Unpaid';
                if ($request->payment_method === 'online_vnpay') {
                    $paymentStatus = 'Paid';
                }

                $shippingMethod = \App\Models\ShippingMethod::where('code', 'STANDARD')->first();

                // Create Order
                $order = Order::create([
                    'user_id' => $user ? $user->id : null,
                    'shipping_method_id' => $shippingMethod ? $shippingMethod->id : null,
                    'order_code' => 'ORD-' . strtoupper(Str::random(8)) . '-' . rand(100, 999),
                    'customer_name' => $request->customer_name,
                    'customer_phone' => $request->customer_phone,
                    'customer_email' => $user ? $user->email : null,
                    'shipping_address_snapshot' => $request->customer_address,
                    'subtotal' => $request->total_amount, // fallback if single items don't add up
                    'discount_amount' => 0,
                    'shipping_fee' => $shippingMethod ? $shippingMethod->fee : 0,
                    'total_amount' => $request->total_amount,
                    'payment_method' => $request->payment_method,
                    'payment_status' => $paymentStatus,
                    'order_status' => 'Pending',
                    'note' => $request->customer_note,
                    'voucher_id' => $request->voucher_id,
                ]);

                $subtotal = 0;

                // Save Items & Decrement Stock
                foreach ($request->items as $item) {
                    $color = Color::where('name', $item['color'])->first();
                    $size = Size::where('name', $item['size'])->first();

                    $variant = ProductVariant::where('product_id', $item['product_id'])
                        ->where('color_id', $color?->id)
                        ->where('size_id', $size?->id)
                        ->lockForUpdate()
                        ->first();

                    if (!$variant) {
                        // Fallback if variant not found
                        $variant = ProductVariant::where('product_id', $item['product_id'])->lockForUpdate()->first();
                    }

                    if (!$variant) {
                        throw new \Exception("Biến thể sản phẩm #" . $item['product_id'] . " không tồn tại.");
                    }

                    if ($variant->stock_quantity < $item['quantity']) {
                        throw new \Exception("Sản phẩm '{$variant->product->name}' (Màu: {$item['color']}, Size: {$item['size']}) không đủ số lượng trong kho (Hiện còn: {$variant->stock_quantity}).");
                    }

                    // Decrement stock
                    $variant->decrement('stock_quantity', $item['quantity']);

                    $itemTotal = $item['price'] * $item['quantity'];
                    $subtotal += $itemTotal;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product_id'],
                        'product_variant_id' => $variant->id,
                        'product_name_snapshot' => $variant->product->name,
                        'sku_snapshot' => $variant->sku,
                        'size_name_snapshot' => $variant->size->name,
                        'color_name_snapshot' => $variant->color->name,
                        'quantity' => $item['quantity'],
                        'price_at_purchase' => $item['price'],
                        'total_price' => $itemTotal,
                    ]);
                }

                // Decrement voucher limit if applicable
                $discount = 0;
                if ($request->voucher_id) {
                    $voucher = Voucher::find($request->voucher_id);
                    if ($voucher) {
                        if ($voucher->discount_type === 'percent') {
                            $discount = ($subtotal * $voucher->discount_value) / 100;
                        } else {
                            $discount = $voucher->discount_value;
                        }
                        if ($voucher->max_discount_amount && $discount > $voucher->max_discount_amount) {
                            $discount = $voucher->max_discount_amount;
                        }

                        $voucher->increment('used_count');
                        
                        // Log voucher usage
                        \App\Models\VoucherUsage::create([
                            'voucher_id' => $voucher->id,
                            'user_id' => $user ? $user->id : null,
                            'order_id' => $order->id,
                            'discount_amount' => $discount,
                        ]);
                    }
                }

                $order->subtotal = $subtotal;
                $order->discount_amount = $discount;
                $order->total_amount = max(0, $subtotal - $discount + $order->shipping_fee);
                $order->save();

                // Create default shipment record
                Shipment::create([
                    'order_id' => $order->id,
                    'shipping_method_id' => $order->shipping_method_id,
                    'carrier_name' => 'Beestyle Delivery',
                    'shipping_status' => 'Pending',
                ]);

                // Log status history
                OrderStatusHistory::create([
                    'order_id' => $order->id,
                    'old_status' => 'None',
                    'new_status' => 'Pending',
                    'note' => 'Khách hàng đặt hàng thành công',
                    'changed_by' => $user ? $user->id : null,
                ]);

                // Log payment transaction if online
                if ($paymentStatus === 'Paid') {
                    PaymentTransaction::create([
                        'order_id' => $order->id,
                        'method' => $request->payment_method,
                        'amount' => $order->total_amount,
                        'status' => 'Success',
                        'paid_at' => now(),
                    ]);
                }

                return response()->json([
                    'message' => 'Đặt hàng thành công!',
                    'order_id' => $order->id
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function getOrderDetails($id)
    {
        $order = Order::with(['orderItems.product.images', 'voucher'])->find($id);
        if (!$order) {
            return response()->json(['message' => 'Đơn hàng không tồn tại.'], 404);
        }

        return response()->json($this->mapOrderToFrontend($order));
    }

    public function cancelClientOrder(Request $request, $id)
    {
        $order = Order::with('orderItems')->find($id);
        if (!$order) {
            return response()->json(['message' => 'Đơn hàng không tồn tại.'], 404);
        }

        if ($order->order_status !== 'Pending') {
            return response()->json(['message' => 'Chỉ có thể hủy đơn hàng khi trạng thái là Chờ xử lý.'], 400);
        }

        try {
            return DB::transaction(function() use ($order) {
                // Restore stock
                foreach ($order->orderItems as $item) {
                    $variant = ProductVariant::lockForUpdate()->find($item->product_variant_id);
                    if ($variant) {
                        $variant->increment('stock_quantity', $item->quantity);
                    }
                }

                $order->order_status = 'Cancelled';
                $order->save();

                OrderStatusHistory::create([
                    'order_id' => $order->id,
                    'old_status' => 'Pending',
                    'new_status' => 'Cancelled',
                    'note' => 'Khách hàng hủy đơn hàng',
                ]);

                return response()->json(['message' => 'Hủy đơn hàng thành công!']);
            });
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi khi hủy đơn hàng: ' . $e->getMessage()], 400);
        }
    }

    public function getOrders(Request $request)
    {
        $request->validate([
            'order_ids' => 'nullable|array',
            'phone' => 'nullable|string'
        ]);

        $query = Order::with(['orderItems.product.images']);

        if ($request->filled('order_ids')) {
            $query->whereIn('id', $request->input('order_ids'));
        } elseif ($request->filled('phone')) {
            $query->where('customer_phone', $request->input('phone'));
        } else {
            return response()->json([]);
        }

        $orders = $query->orderBy('created_at', 'desc')->get()->map(function($order) {
            return $this->mapOrderToFrontend($order);
        });

        return response()->json($orders);
    }

    // --- Private Mapper Helpers ---

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

        // Build variant_data JSON
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

    private function mapOrderToFrontend($order)
    {
        // Format order items for frontend
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

        // Format voucher
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
