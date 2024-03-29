<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use Carbon\Carbon;
use DB;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expense::leftJoin('income_expense_heads as h', 'expenses.head', '=', 'h.id')->select('expenses.id', 'expenses.description', 'expenses.amount', DB::raw("DATE_FORMAT(expenses.date, '%d/%b/%Y') AS edate"), 'h.name as head')->whereDate('expenses.created_at', Carbon::today())->orderByDesc('expenses.id')->get();
        return view('expense.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {    
        $heads = DB::table('income_expense_heads')->where('type', 'E')->get();    
        return view('expense.create', compact('heads'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'required',
            'amount' => 'required',
            'head' => 'required',
        ]);
        $input = $request->all();
        $input['created_by'] = $request->user()->id;
        $input['branch'] = 1;
        $input['date'] = (!empty($request->date)) ? Carbon::createFromFormat('d/M/Y', $input['date'])->format('Y-m-d') : NULL;
        $expense = Expense::create($input);        
        return redirect()->route('expense.index')->with('success','Expense recorded successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expense = Expense::find($id);
        $heads = DB::table('income_expense_heads')->where('type', 'E')->get();    
        return view('expense.edit', compact('expense', 'heads'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'date' => 'required',
            'amount' => 'required',
            'head' => 'required',
        ]);
        $input = $request->all();
        $expense = Expense::find($id);
        $input['created_by'] = $expense->getOriginal('created_by');
        $input['branch'] = 1;
        $input['date'] = (!empty($request->date)) ? Carbon::createFromFormat('d/M/Y', $request['date'])->format('Y-m-d') : NULL;        
        $expense->update($input);        
        return redirect()->route('expense.index')->with('success','Expense updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Expense::find($id)->delete();
        return redirect()->route('expense.index')
                        ->with('success','Expense deleted successfully');
    }
}
