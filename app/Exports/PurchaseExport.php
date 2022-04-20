<?php

namespace App\Exports;

use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;
use DB;

class PurchaseExport implements FromCollection, WithHeadings
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

        $purchases = DB::table('purchases as p')->leftJoin('purchase_details as pd', 'p.id', 'pd.purchase_id')->leftJoin('suppliers as s', 'p.supplier', '=', 's.id')->selectRaw("p.id, p.invoice_number, s.name as sname, DATE_FORMAT(p.order_date, '%d/%b/%Y') as odate, DATE_FORMAT(p.delivery_date, '%d/%b/%Y') as ddate, p.payment_mode, SUM(pd.total)+p.other_expense as total")->where('pd.is_return', 0)->whereBetween('p.delivery_date', [$from, $to])->when(isset($supplier), function($query) use ($request){
            return $query->where('p.supplier', $supplier);
        })->when(isset($product), function($query) use ($request, $product){
            return $query->where('pd.product', $product);
        })->groupBy('p.id', 'p.invoice_number', 'p.order_date', 'p.delivery_date', 'p.payment_mode', 's.name', 'p.other_expense')->get();
        return $purchases;
    }
}
