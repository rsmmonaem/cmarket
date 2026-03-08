<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MerchantSalesExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $merchantId;
    protected $startDate;
    protected $endDate;

    public function __construct($merchantId, $startDate = null, $endDate = null)
    {
        $this->merchantId = $merchantId;
        $this->startDate  = $startDate;
        $this->endDate    = $endDate;
    }

    public function collection()
    {
        $query = Order::whereHas('items', fn($q) => $q->where('merchant_id', $this->merchantId))
            ->with(['items' => fn($q) => $q->where('merchant_id', $this->merchantId), 'user'])
            ->latest();

        if ($this->startDate) $query->whereDate('created_at', '>=', $this->startDate);
        if ($this->endDate)   $query->whereDate('created_at', '<=', $this->endDate);

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Order ID', 'Order Number', 'Customer', 'Items', 'Total (৳)',
            'Payment', 'Status', 'Date',
        ];
    }

    public function map($order): array
    {
        $items = $order->items->map(fn($i) => $i->product_name . ' x' . $i->quantity)->implode(', ');

        return [
            $order->id,
            $order->order_number,
            $order->user->name ?? 'N/A',
            $items,
            number_format($order->total_amount, 2),
            strtoupper($order->payment_method),
            strtoupper($order->status),
            $order->created_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF1a1a2e']]],
        ];
    }
}
