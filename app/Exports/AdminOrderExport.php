<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AdminOrderExport implements FromView
{
    public $orders;
    public $startDate;
    public $endDate;

    public function __construct($orders, $startDate = null, $endDate = null)
    {
        $this->orders = $orders;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        return view('admin.order-table', [
            'orders' => $this->orders,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ]);
    }
}
