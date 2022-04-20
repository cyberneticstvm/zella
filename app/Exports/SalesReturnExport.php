<?php

namespace App\Exports;

use App\Models\Sales;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;
use DB;

class SalesReturnExport implements FromCollection, WithHeadings
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

        $sales = DB::table('sales AS s')->leftJoin('sales_details AS sd', 's.id', 'sd.sales_id')->selectRaw("s.id, DATE_FORMAT(s.sold_date, '%d/%b/%Y') AS sdate, s.customer_name, s.contact_number, s.address, SUM(sd.qty*sd.price) AS total")->where('sd.is_return', 1)->whereBetween('s.sold_date', [$from, $to])->when(isset($request->product), function($query) use ($request){
            return $query->where('sd.product', $request->product);
        })->groupBy('s.id', 's.customer_name', 's.contact_number', 's.address', 's.sold_date')->get();

        return $sales;
    }
}
