<?php

namespace App\Exports;

use App\Models\Sales;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;
use DB;

class SalesExport implements FromCollection, WithHeadings
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
            'Invoice Number',
            'Date',
            'Customer Name',
            'Contact Number',
            'Address',
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
        $product = (!empty($inputs[2])) ? $inputs[2] : NULL;
        $pmode = (!empty($inputs[3])) ? $inputs[3] : NULL;

        $sales = DB::table('sales AS s')->leftJoin('sales_details AS sd', 's.id', 'sd.sales_id')->selectRaw("s.id, DATE_FORMAT(s.sold_date, '%d/%b/%Y') AS sdate, s.customer_name, s.contact_number, s.address, s.payment_mode, CASE WHEN sd.vat_percentage > 0 THEN (SUM(sd.qty*sd.price)+((SUM(sd.qty*sd.price)*sd.vat_percentage)/100)) - s.discount ELSE SUM(sd.qty*sd.price) - s.discount END AS total")->where('sd.is_return', 0)->whereBetween('s.sold_date', [$from, $to])->when(isset($product), function($query) use ($request, $product){
            return $query->where('sd.product', $product);
        })->when(isset($pmode), function($query) use ($request, $pmode){
            return $query->where('s.payment_mode', $pmode);
        })->groupBy('s.id', 's.customer_name', 's.contact_number', 's.address', 's.payment_mode', 's.sold_date', 's.discount', 'sd.vat_percentage')->get();
        return $sales;
    }
}
