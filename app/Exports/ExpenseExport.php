<?php

namespace App\Exports;

use App\Models\Expense;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;
use DB;

class ExpenseExport implements FromCollection, WithHeadings
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
            'Date',
            'Department',
            'Description',
            'Amount',
        ];
    }

    public function collection()
    {
        $request = $this->request;
        $inputs = explode(',', $request->inputs);
        $from = (!empty($inputs[0])) ? Carbon::createFromFormat('d/M/Y', $inputs[0])->format('Y-m-d') : NULL;
        $to = (!empty($inputs[1])) ? Carbon::createFromFormat('d/M/Y', $inputs[1])->format('Y-m-d') : NULL;
        $department = (!empty($inputs[2])) ? $inputs[2] : NULL;
        $expenses = DB::table('expenses')->selectRaw("DATE_FORMAT(expense_Date, '%d/%b/%Y') AS edate, department, description, amount")->whereBetween('expense_date', [$from, $to])->when(isset($department), function($query) use ($department){
            return $query->where('department', $department);
        })->get();
        return $expenses;
    }
}
