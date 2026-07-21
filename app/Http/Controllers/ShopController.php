<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{

    public function index()
{
    return view('welcome'); // Đảm bảo file resources/views/home.blade.php tồn tại
}
    public function getCategories()
    {
        return response()->json(Category::all());
    }

    public function getProducts(Request $request)
    {
        $query = Product::query();

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
            $query->where('price', '<=', $request->input('max_price'));
        }

        // 4. Tag Filter
        if ($request->filled('tag')) {
            $query->where('tag', 'like', '%' . $request->input('tag') . '%');
        }

        // 5. Sorting
        $sort = $request->input('sort', 'default');
        if ($sort === 'price-asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'price-desc') {
            $query->orderBy('price', 'desc');
        } elseif ($sort === 'rating-desc') {
            $query->orderBy('rating', 'desc');
        } else {
            $query->orderBy('id', 'asc');
        }

        return response()->json($query->get());
    }

    public function getProductDetails($id)
    {
        $product = Product::with(['category', 'reviews' => function($q) {
            $q->orderBy('created_at', 'desc');
        }])->find($id);

        if (!$product) {
            return response()->json(['message' => 'Sản phẩm không tồn tại'], 404);
        }

        return response()->json($product);
    }

    public function submitReview(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'customer_name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $review = Review::create([
            'product_id' => $request->product_id,
            'customer_name' => $request->customer_name,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Recalculate average rating for product
        $avgRating = Review::where('product_id', $request->product_id)->avg('rating');
        $product = Product::find($request->product_id);
        if ($product) {
            $product->rating = round($avgRating, 1);
            $product->save();
        }

        return response()->json([
            'message' => 'Gửi đánh giá thành công!',
            'review' => $review,
            'new_rating' => $product ? $product->rating : 5.0
        ]);
    }

    public function applyVoucher(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'order_value' => 'required|numeric|min:0',
        ]);

        $voucher = Voucher::where('code', $request->code)->first();

        if (!$voucher) {
            return response()->json(['message' => 'Mã giảm giá không hợp lệ'], 400);
        }

        // Validate voucher limits
        if ($voucher->start_date && now()->lt($voucher->start_date)) {
            return response()->json(['message' => 'Mã giảm giá chưa đến hạn sử dụng'], 400);
        }

        if ($voucher->end_date && now()->gt($voucher->end_date)) {
            return response()->json(['message' => 'Mã giảm giá đã hết hạn sử dụng'], 400);
        }

        if ($voucher->min_order_value && $request->order_value < $voucher->min_order_value) {
            return response()->json([
                'message' => 'Đơn hàng chưa đạt giá trị tối thiểu ' . number_format($voucher->min_order_value) . 'đ'
            ], 400);
        }

        if ($voucher->usage_limit !== null && $voucher->usage_limit <= 0) {
            return response()->json(['message' => 'Mã giảm giá đã hết lượt sử dụng'], 400);
        }

        // Calculate discount
        $discountAmount = ($request->order_value * $voucher->discount_percent) / 100;
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
                $paymentStatus = 'Unpaid';
                if ($request->payment_method === 'online_vnpay') {
                    $paymentStatus = 'Paid';
                }

                // Create Order
                $order = Order::create([
                    'status' => 'Pending',
                    'customer_name' => $request->customer_name,
                    'customer_phone' => $request->customer_phone,
                    'customer_address' => $request->customer_address,
                    'customer_note' => $request->customer_note,
                    'payment_method' => $request->payment_method,
                    'payment_status' => $paymentStatus,
                    'total_amount' => $request->total_amount,
                    'shipping_fee' => 0.00, // Hardcoded for simplicity
                    'voucher_id' => $request->voucher_id,
                ]);

                // Save Items & Decrement Stock
                foreach ($request->items as $item) {
                    $product = Product::lockForUpdate()->find($item['product_id']);
                    if (!$product) {
                        throw new \Exception("Sản phẩm #" . $item['product_id'] . " không tồn tại.");
                    }
                    if ($product->stock < $item['quantity']) {
                        throw new \Exception("Sản phẩm '{$product->name}' không đủ số lượng trong kho (Hiện còn: {$product->stock}).");
                    }
                    $product->decrement('stock', $item['quantity']);

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product_id'],
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                        'size' => $item['size'] ?? null,
                        'color' => $item['color'] ?? null,
                    ]);
                }

                // Decrement voucher limit if applicable
                if ($request->voucher_id) {
                    $voucher = Voucher::find($request->voucher_id);
                    if ($voucher && $voucher->usage_limit !== null) {
                        $voucher->usage_limit = max(0, $voucher->usage_limit - 1);
                        $voucher->save();
                    }
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
        $order = Order::with(['orderItems.product', 'voucher'])->find($id);
        if (!$order) {
            return response()->json(['message' => 'Đơn hàng không tồn tại.'], 404);
        }
        return response()->json($order);
    }

    public function cancelClientOrder(Request $request, $id)
    {
        $order = Order::with('orderItems')->find($id);
        if (!$order) {
            return response()->json(['message' => 'Đơn hàng không tồn tại.'], 404);
        }

        if ($order->status !== 'Pending') {
            return response()->json(['message' => 'Chỉ có thể hủy đơn hàng khi trạng thái là Chờ xử lý.'], 400);
        }

        try {
            return DB::transaction(function() use ($order) {
                // Restore stock
                foreach ($order->orderItems as $item) {
                    $product = Product::lockForUpdate()->find($item->product_id);
                    if ($product) {
                        $product->increment('stock', $item->quantity);
                    }
                }

                $order->status = 'Cancelled';
                $order->save();

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

        $query = Order::with(['orderItems.product']);

        if ($request->filled('order_ids')) {
            $query->whereIn('id', $request->input('order_ids'));
        } elseif ($request->filled('phone')) {
            $query->where('customer_phone', $request->input('phone'));
        } else {
            return response()->json([]);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();
        return response()->json($orders);
    }
}
