<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // Doanh thu theo ngày/tuần/tháng/năm
    public function getRevenue(Request $request)
    {
        $period = $request->get('period', 'week'); // today, week, month, year
        $query = Order::where('status', '!=', 'Cancelled');

        $data = [];

        if ($period === 'today') {
            $data = $query->whereDate('created_at', now()->toDateString())
                ->selectRaw('HOUR(created_at) as label, SUM(total_amount) as revenue')
                ->groupBy('label')->orderBy('label')->get();
        } elseif ($period === 'week') {
            $data = $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->selectRaw("DAYNAME(created_at) as label, DATE(created_at) as date, SUM(total_amount) as revenue")
                ->groupBy('label', 'date')->orderBy('date')->get();
        } elseif ($period === 'month') {
            $data = $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)
                ->selectRaw('DAY(created_at) as label, SUM(total_amount) as revenue')
                ->groupBy('label')->orderBy('label')->get();
        } elseif ($period === 'year') {
            $data = $query->whereYear('created_at', now()->year)
                ->selectRaw('MONTH(created_at) as label, SUM(total_amount) as revenue')
                ->groupBy('label')->orderBy('label')->get();
        }

        $todayRevenue = Order::where('status', '!=', 'Cancelled')->whereDate('created_at', now()->toDateString())->sum('total_amount');

        return response()->json([
            'period' => $period,
            'today_revenue' => (float) $todayRevenue,
            'chart' => $data,
        ]);
    }

    // Thống kê đơn hàng theo trạng thái
    public function getOrderStats()
    {
        $total = Order::count();
        $byStatus = Order::selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status');

        return response()->json([
            'total_orders' => $total,
            'pending' => $byStatus['Pending'] ?? 0,
            'processing' => $byStatus['Processing'] ?? 0,
            'shipping' => $byStatus['Shipping'] ?? 0,
            'completed' => $byStatus['Completed'] ?? 0,
            'cancelled' => $byStatus['Cancelled'] ?? 0,
        ]);
    }

    // Top sản phẩm bán chạy
    public function getTopProducts(Request $request)
    {
        $limit = $request->get('limit', 10);

        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as sold'))
            ->whereHas('order', fn($q) => $q->where('status', '!=', 'Cancelled'))
            ->groupBy('product_id')
            ->orderByDesc('sold')
            ->limit($limit)
            ->with('product:id,name,thumbnail_url')
            ->get()
            ->map(fn($item) => [
                'product_id' => $item->product_id,
                'name' => $item->product->name ?? 'N/A',
                'thumbnail_url' => $item->product->thumbnail_url ?? null,
                'sold' => (int) $item->sold,
            ]);

        return response()->json($topProducts);
    }

    // Thống kê theo Size
    public function getSizeStats()
    {
        $stats = OrderItem::select('size', DB::raw('SUM(quantity) as sold'))
            ->whereNotNull('size')
            ->whereHas('order', fn($q) => $q->where('status', '!=', 'Cancelled'))
            ->groupBy('size')
            ->orderByDesc('sold')
            ->get();

        return response()->json($stats);
    }

    // Thống kê theo Màu sắc
    public function getColorStats()
    {
        $stats = OrderItem::select('color', DB::raw('SUM(quantity) as sold'))
            ->whereNotNull('color')
            ->whereHas('order', fn($q) => $q->where('status', '!=', 'Cancelled'))
            ->groupBy('color')
            ->orderByDesc('sold')
            ->get();

        return response()->json($stats);
    }

    // Thống kê tồn kho (cảnh báo dưới ngưỡng)
    public function getInventoryStats(Request $request)
    {
        $threshold = $request->get('threshold', 5);

        $products = Product::select('id', 'name', 'stock', 'sizes', 'colors')
            ->orderBy('stock')
            ->get()
            ->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'stock' => $p->stock,
                'low_stock' => $p->stock < $threshold,
            ]);

        return response()->json([
            'threshold' => $threshold,
            'products' => $products,
        ]);
    }

    // Thống kê khách hàng
    public function getCustomerStats()
    {
        $totalCustomers = User::where('role', 'Customer')->count();
        $newCustomers = User::where('role', 'Customer')->whereMonth('created_at', now()->month)->count();

        $topCustomers = Order::select('user_id', DB::raw('COUNT(*) as order_count'), DB::raw('SUM(total_amount) as total_spent'))
            ->where('status', '!=', 'Cancelled')
            ->whereNotNull('user_id')
            ->groupBy('user_id')
            ->orderByDesc('order_count')
            ->limit(10)
            ->with('user:id,full_name')
            ->get()
            ->map(fn($o) => [
                'customer' => $o->user->full_name ?? 'N/A',
                'order_count' => (int) $o->order_count,
                'total_spent' => (float) $o->total_spent,
            ]);

        return response()->json([
            'total_customers' => $totalCustomers,
            'new_customers' => $newCustomers,
            'top_customers' => $topCustomers,
        ]);
    }

    // Thống kê theo danh mục
    public function getCategoryStats()
    {
        $totalRevenue = OrderItem::whereHas('order', fn($q) => $q->where('status', '!=', 'Cancelled'))
            ->sum(DB::raw('price * quantity'));

        $categories = Category::all();
        $stats = $categories->map(function ($category) use ($totalRevenue) {
            $revenue = OrderItem::whereHas('order', fn($q) => $q->where('status', '!=', 'Cancelled'))
                ->whereHas('product', fn($q) => $q->where('category_id', $category->id))
                ->sum(DB::raw('price * quantity'));

            return [
                'category' => $category->name,
                'revenue' => (float) $revenue,
                'percent' => $totalRevenue > 0 ? round($revenue / $totalRevenue * 100, 1) : 0,
            ];
        });

        return response()->json($stats);
    }
}
