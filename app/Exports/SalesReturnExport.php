<?php

namespace App\Exports;

use App\Models\Sales;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithPreCalculateFormulas;
use Maatwebsite\Excel\Concerns\WithStyles;
use Carbon\Carbon;
use DB;

class SalesReturnExport implements FromCollection, WithHeadings, WithPreCalculateFormulas, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $request, $sales;
    public function __construct($request){
        $this->request = $request;
        $inputs = explode(',', $request->inputs);
        $from = (!empty($inputs[0])) ? Carbon::createFromFormat('d/M/Y', $inputs[0])->format('Y-m-d') : NULL;
        $to = (!empty($inputs[1])) ? Carbon::createFromFormat('d/M/Y', $inputs[1])->format('Y-m-d') : NULL;
        $product = (!empty($inputs[2])) ? $inputs[2] : NULL;

        $this->sales = DB::table('sales AS s')->leftJoin('sales_details AS sd', 's.id', 'sd.sales_id')->selectRaw("s.id, DATE_FORMAT(s.sold_date, '%d/%b/%Y') AS sdate, s.customer_name, s.contact_number, s.address, CASE WHEN sd.vat_percentage > 0 THEN (SUM(sd.qty*sd.price)+((SUM(sd.qty*sd.price)*sd.vat_percentage)/100)) ELSE SUM(sd.qty*sd.price) END AS total")->where('sd.is_return', 1)->whereBetween('s.sold_date', [$from, $to])->when(isset($product), function($query) use ($request, $product){
            return $query->where('sd.product', $product);
        })->groupBy('s.id', 's.customer_name', 's.contact_number', 's.address', 's.sold_date', 'sd.vat_percentage')->get();
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
    public function styles(Worksheet $sheet){
        $numOfRows = count($this->sales) + 1; //Including header;
        $totalRow = $numOfRows + 2; // Including Header
        $sheet->setCellValue("E{$totalRow}", "Total");
        $sheet->setCellValue("F{$totalRow}", "=SUM(F1:F{$numOfRows})");
    }
    public function collection(){
        return $this->sales;
    }
}
