<?php

namespace App\Exports;

use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;
use DB;

class PurchaseReturnExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $request;
    public function __construct($request){
        $this->request = $request;
    }
    public function headings():array{
        return[
            'Zella Invoice',
            'Supplier Invoice',
            'Supplier Name',
            'Order Date',
            'Delivery Date',
            'Payment Mode',
            'Invoice Total',
        ];
    }
    public function collection()
    {
        $request = $this->request;
        $inputs = explode(',', $request->inputs);
        $from = (!empty($inputs[0])) ? Carbon::createFromFormat('d/M/Y', $inputs[0])->format('Y-m-d') : NULL;
        $to = (!empty($inputs[1])) ? Carbon::createFromFormat('d/M/Y', $inputs[1])->format('Y-m-d') : NULL;
        $supplier = (!empty($inputs[2])) ? $inputs[2] : NULL;
        $product = (!empty($inputs[3])) ? $inputs[3] : NULL;

        $purchases = DB::table('purchases as p')->leftJoin('purchase_details as pd', 'p.id', 'pd.purchase_id')->leftJoin('suppliers as s', 'p.supplier', '=', 's.id')->selectRaw('p.id, p.invoice_number, s.name as sname, p.order_date, p.delivery_date, p.payment_mode, SUM(pd.qty*pd.price) as total')->where('pd.is_return', 1)->whereBetween('p.delivery_date', [$from, $to])->when(isset($supplier), function($query) use ($request, $supplier){
            return $query->where('p.supplier', $supplier);
        })->when(isset($product), function($query) use ($request, $product){
            return $query->where('pd.product', $product);
        })->groupBy('p.id', 'p.invoice_number', 'p.order_date', 'p.delivery_date', 'p.payment_mode', 's.name')->get();

        return $purchases;
    }
}
