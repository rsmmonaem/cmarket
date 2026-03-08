<?php

namespace Modules\Merchant\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $merchant = auth()->user()->merchant;
        
        // Date range filter
        $startDate = $request->get('start_date', now()->startOfMonth());
        $endDate = $request->get('end_date', now()->endOfMonth());

        // Sales statistics
        $totalSales = OrderItem::where('merchant_id', $merchant->id)
            ->whereHas('order', function($q) use ($startDate, $endDate) {
                $q->where('status', 'delivered')
                  ->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->sum('subtotal');

        $totalOrders = OrderItem::where('merchant_id', $merchant->id)
            ->whereHas('order', function($q) use ($startDate, $endDate) {
                $q->where('status', 'delivered')
                  ->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->count();

        $totalProducts = OrderItem::where('merchant_id', $merchant->id)
            ->whereHas('order', function($q) use ($startDate, $endDate) {
                $q->where('status', 'delivered')
                  ->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->sum('quantity');

        // Top selling products
        $topProducts = OrderItem::where('merchant_id', $merchant->id)
            ->whereHas('order', function($q) use ($startDate, $endDate) {
                $q->where('status', 'delivered')
                  ->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->select('product_id', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(subtotal) as total_sales'))
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_sales')
            ->take(10)
            ->get();

        // Daily sales chart data
        $dailySales = OrderItem::where('merchant_id', $merchant->id)
            ->whereHas('order', function($q) use ($startDate, $endDate) {
                $q->where('status', 'delivered')
                  ->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(subtotal) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('merchant.reports.sales', compact(
            'totalSales',
            'totalOrders',
            'totalProducts',
            'topProducts',
            'dailySales',
            'startDate',
            'endDate'
        ));
    }

    public function exportExcel(Request $request)
    {
        $merchant = auth()->user()->merchant;
        $startDate = $request->get('start_date', now()->startOfMonth());
        $endDate = $request->get('end_date', now()->endOfMonth());

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\MerchantSalesExport($merchant->id, $startDate, $endDate),
            'sales-report-' . now()->format('Y-m-d') . '.xlsx'
        );
    }
}
