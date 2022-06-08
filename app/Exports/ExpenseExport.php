<?php

namespace App\Exports;

use App\Models\Expense;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithPreCalculateFormulas;
use Maatwebsite\Excel\Concerns\WithStyles;
use Carbon\Carbon;
use DB;

class ExpenseExport implements FromCollection, WithHeadings, WithPreCalculateFormulas, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $request, $expenses;

    public function __construct($request){
        $this->request = $request;
        $inputs = explode(',', $request->inputs);
        $from = (!empty($inputs[0])) ? Carbon::createFromFormat('d/M/Y', $inputs[0])->format('Y-m-d') : NULL;
        $to = (!empty($inputs[1])) ? Carbon::createFromFormat('d/M/Y', $inputs[1])->format('Y-m-d') : NULL;
        $department = (!empty($inputs[2])) ? $inputs[2] : NULL;
        $this->expenses = DB::table('expenses')->selectRaw("DATE_FORMAT(expense_Date, '%d/%b/%Y') AS edate, department, description, amount")->whereBetween('expense_date', [$from, $to])->when(isset($department), function($query) use ($department){
            return $query->where('department', $department);
        })->get();
    }

    public function headings():array{
        return[
            'Date',
            'Department',
            'Description',
            'Amount',
        ];
    }

    public function styles(Worksheet $sheet){
        $numOfRows = count($this->expenses) + 1; //Including header;
        $totalRow = $numOfRows + 2; // Including Header
        $sheet->setCellValue("C{$totalRow}", "Total");
        $sheet->setCellValue("D{$totalRow}", "=SUM(D1:D{$numOfRows})");
    }

    public function collection(){
        return $this->expenses;
    }
}
