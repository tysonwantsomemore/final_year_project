<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\Review;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function getStats()
    {
        $totalRevenue = Order::where('status', '!=', 'Cancelled')->sum('total_amount');
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
            $revenue = Order::where('status', '!=', 'Cancelled')
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
                    $q->where('status', '!=', 'Cancelled');
                })
                ->whereHas('product', function($q) use ($category) {
                    $q->where('category_id', $category->id);
                })
                ->sum(DB::raw('price * quantity'));
                
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
        return response()->json(Product::with('category')->orderBy('created_at', 'desc')->get());
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

        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'old_price' => $request->old_price,
            'tag' => $request->tag,
            'sizes' => $request->sizes ?: 'S, M, L, XL',
            'colors' => $request->colors ?: 'Trắng, Đen',
            'description' => $request->description,
            'thumbnail_url' => $request->thumbnail_url ?: 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=600&auto=format&fit=crop&q=80',
            'stock' => isset($request->stock) ? $request->stock : 50,
            'rating' => 5.0,
            'variant_data' => $request->variant_data
        ]);

        return response()->json([
            'message' => 'Thêm sản phẩm thành công!',
            'product' => $product
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

        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'old_price' => $request->old_price,
            'tag' => $request->tag,
            'sizes' => $request->sizes ?: 'S, M, L, XL',
            'colors' => $request->colors ?: 'Trắng, Đen',
            'description' => $request->description,
            'thumbnail_url' => $request->thumbnail_url ?: 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=600&auto=format&fit=crop&q=80',
            'stock' => isset($request->stock) ? $request->stock : $product->stock,
            'variant_data' => $request->variant_data
        ]);

        return response()->json([
            'message' => 'Cập nhật sản phẩm thành công!',
            'product' => $product
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
            // Delete existing products and reviews
            DB::statement('PRAGMA foreign_keys = OFF');
            Review::truncate();
            OrderItem::truncate();
            Product::truncate();
            Category::truncate();
            DB::statement('PRAGMA foreign_keys = ON');

            // Re-seed using artisan command
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
        $orders = Order::with(['orderItems.product'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json($orders);
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::with('orderItems')->find($id);
        if (!$order) {
            return response()->json(['message' => 'Đơn hàng không tồn tại'], 404);
        }

        if ($order->status === 'Completed' || $order->status === 'Cancelled') {
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
                        $product = Product::lockForUpdate()->find($item->product_id);
                        if ($product) {
                            $product->increment('stock', $item->quantity);
                        }
                    }
                }

                if ($newStatus === 'Completed') {
                    $order->payment_status = 'Paid';
                }

                $order->status = $newStatus;
                $order->save();

                return response()->json([
                    'message' => 'Cập nhật trạng thái đơn hàng thành công!',
                    'order' => $order
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

    // -------------------------------------------------------------
    // Voucher CRUD
    // -------------------------------------------------------------
    public function getVouchers()
    {
        $vouchers = \App\Models\Voucher::orderBy('created_at', 'desc')->get()->map(function($voucher) {
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
            'discount_percent' => $request->discount_percent,
            'max_discount_amount' => $request->max_discount ?: null,
            'min_order_value' => 0,
            'start_date' => now(),
            'end_date' => $request->expiry_date,
            'usage_limit' => $request->usage_limit ?: null,
        ]);

        return response()->json([
            'message' => 'Tạo voucher thành công!',
            'voucher' => [
                'id' => $voucher->id,
                'code' => $voucher->code,
                'discount_percent' => $voucher->discount_percent,
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
            'discount_percent' => $request->discount_percent,
            'max_discount_amount' => $request->max_discount ?: null,
            'end_date' => $request->expiry_date,
            'usage_limit' => $request->usage_limit ?: null,
        ]);

        return response()->json([
            'message' => 'Cập nhật voucher thành công!',
            'voucher' => [
                'id' => $voucher->id,
                'code' => $voucher->code,
                'discount_percent' => $voucher->discount_percent,
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

    // -------------------------------------------------------------
    // Review/Comment Moderation
    // -------------------------------------------------------------
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

        // Recalculate rating
        $avgRating = Review::where('product_id', $productId)->avg('rating');
        $product = Product::find($productId);
        if ($product) {
            $product->rating = $avgRating ? round($avgRating, 1) : 5.0;
            $product->save();
        }

        return response()->json([
            'message' => 'Xóa đánh giá thành công!'
        ]);
    }

    // -------------------------------------------------------------
    // User CRUD
    // -------------------------------------------------------------
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

        $updateData = [
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'role' => $data['role'],
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
}
