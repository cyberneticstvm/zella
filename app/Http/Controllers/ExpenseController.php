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
        $expenses = Expense::get();
        return view('expense.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'expense_date' => 'required',
            'amount' => 'required',
            'department' => 'required',
            'description' => 'required',
        ]);
        $input = $request->all();
        $input['expense_date'] = (!empty($request->expense_date)) ? Carbon::createFromFormat('d/M/Y', $request->expense_date)->format('Y-m-d') : NULL;
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
        return view('expense.edit', compact('expense'));
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
            'expense_date' => 'required',
            'amount' => 'required',
            'department' => 'required',
            'description' => 'required',
        ]);
        $input = $request->all();
        $input['expense_date'] = (!empty($request->expense_date)) ? Carbon::createFromFormat('d/M/Y', $request->expense_date)->format('Y-m-d') : NULL;
        $expense = Expense::find($id);
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
