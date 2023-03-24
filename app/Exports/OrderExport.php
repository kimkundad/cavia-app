<?php

namespace App\Exports;

use App\Models\order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class OrderExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $objs = DB::table('orders')->select(
            'orders.*',
            'order_details.*',
            )
            ->leftjoin('order_details', 'order_details.order_no',  'orders.id')
            ->orderby('orders.id', 'desc')
            ->get();
    }
}
