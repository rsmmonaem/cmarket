<?php

namespace App\Exports;

use App\Models\OrderItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesReportExport implements FromCollection, WithHeadings, WithMapping
{
    protected $merchantId;
    protected $startDate;
    protected $endDate;

    public function __construct($merchantId, $startDate, $endDate)
    {
        $this->merchantId = $merchantId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return OrderItem::where('merchant_id', $this->merchantId)
            ->whereHas('order', function($q) {
                $q->where('status', 'delivered')
                  ->whereBetween('created_at', [$this->startDate, $this->endDate]);
            })
            ->with(['order.user', 'product'])
            ->get();
    }

    public function headings(): array
    {
        return [
            'Order Number',
            'Customer Name',
            'Product Name',
            'Quantity',
            'Price',
            'Subtotal',
            'Cashback',
            'Date',
        ];
    }

    public function map($item): array
    {
        return [
            $item->order->order_number,
            $item->order->user->name,
            $item->product->name,
            $item->quantity,
            $item->price,
            $item->subtotal,
            $item->cashback_amount,
            $item->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
