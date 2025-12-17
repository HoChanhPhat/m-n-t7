<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RevenueController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $startMonth = Carbon::now()->startOfMonth();
        $start7 = Carbon::today()->subDays(6);

        // ✅ chỉ tính đơn đã giao
        $base = DB::table('orders')->where('status', 'Đã giao');

        $totalRevenue = (clone $base)->sum('total');
        $totalOrdersDelivered = (clone $base)->count();

        $todayRevenue = (clone $base)->whereDate('created_at', $today)->sum('total');
        $monthRevenue = (clone $base)->whereBetween('created_at', [$startMonth, Carbon::now()])->sum('total');

        // Doanh thu 7 ngày gần nhất (để vẽ chart)
        $daily = (clone $base)
            ->selectRaw('DATE(created_at) as d, SUM(total) as revenue')
            ->whereDate('created_at', '>=', $start7)
            ->groupBy('d')
            ->orderBy('d')
            ->get();

        // build đủ 7 ngày, ngày nào không có thì = 0
        $labels = [];
        $values = [];
        $map = $daily->pluck('revenue', 'd')->toArray();

        for ($i = 0; $i < 7; $i++) {
            $d = $start7->copy()->addDays($i)->format('Y-m-d');
            $labels[] = Carbon::parse($d)->format('d/m');
            $values[] = (int) ($map[$d] ?? 0);
        }

        return view('admin.revenue.index', compact(
            'totalRevenue',
            'totalOrdersDelivered',
            'todayRevenue',
            'monthRevenue',
            'labels',
            'values'
        ));
    }
}
