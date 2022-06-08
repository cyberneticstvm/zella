<?php

namespace App\Exports;

use App\Models\Purchase;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithPreCalculateFormulas;
use Maatwebsite\Excel\Concerns\WithStyles;
use Carbon\Carbon;
use DB;

class PurchaseReturnExport implements FromCollection, WithHeadings, WithPreCalculateFormulas, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $request, $purchases;
    public function __construct($request){
        $this->request = $request;
        $inputs = explode(',', $request->inputs);
        $from = (!empty($inputs[0])) ? Carbon::createFromFormat('d/M/Y', $inputs[0])->format('Y-m-d') : NULL;
        $to = (!empty($inputs[1])) ? Carbon::createFromFormat('d/M/Y', $inputs[1])->format('Y-m-d') : NULL;
        $supplier = (!empty($inputs[2])) ? $inputs[2] : NULL;
        $product = (!empty($inputs[3])) ? $inputs[3] : NULL;

        $this->purchases = DB::table('purchases as p')->leftJoin('purchase_details as pd', 'p.id', 'pd.purchase_id')->leftJoin('suppliers as s', 'p.supplier', '=', 's.id')->selectRaw('p.id, p.invoice_number, s.name as sname, p.order_date, p.delivery_date, p.payment_mode, SUM(pd.qty*pd.price) as total')->where('pd.is_return', 1)->whereBetween('p.delivery_date', [$from, $to])->when(isset($supplier), function($query) use ($request, $supplier){
            return $query->where('p.supplier', $supplier);
        })->when(isset($product), function($query) use ($request, $product){
            return $query->where('pd.product', $product);
        })->groupBy('p.id', 'p.invoice_number', 'p.order_date', 'p.delivery_date', 'p.payment_mode', 's.name')->get();
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
    public function styles(Worksheet $sheet){
        $numOfRows = count($this->purchases) + 1; //Including header;
        $totalRow = $numOfRows + 2; // Including Header
        $sheet->setCellValue("F{$totalRow}", "Total");
        $sheet->setCellValue("G{$totalRow}", "=SUM(G1:G{$numOfRows})");
    }
    public function collection(){
        return $this->purchases;
    }
}
