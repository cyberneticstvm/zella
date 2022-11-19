<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\PatientPayment as PP;
use Carbon\Carbon;
use DB;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $incomes = Income::leftJoin('income_expense_heads as ie', 'incomes.head', '=', 'ie.id')->select('incomes.id', 'incomes.description', 'incomes.amount', 'ie.name as head', DB::raw("DATE_FORMAT(incomes.date, '%d/%b/%Y') AS edate"))->whereDate('incomes.created_at', Carbon::today())->orderByDesc("incomes.id")->get();
        return view('income.index', compact('incomes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {    
        $heads = DB::table('income_expense_heads')->where('type', 'I')->get();    
        return view('income.create', compact('heads'));
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
        $input['date'] = (!empty($request->date)) ? Carbon::createFromFormat('d/M/Y', $request['date'])->format('Y-m-d') : NULL;
        $income = Income::create($input);        
        return redirect()->route('income.index')->with('success','Income recorded successfully');
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
        $income = Income::find($id);
        $heads = DB::table('income_expense_heads')->where('type', 'I')->get();    
        return view('income.edit', compact('income', 'heads'));
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
        $income = Income::find($id);
        $input['created_by'] = $income->getOriginal('created_by');
        $input['branch'] = 1;
        $input['date'] = (!empty($request->date)) ? Carbon::createFromFormat('d/M/Y', $request['date'])->format('Y-m-d') : NULL;        
        $income->update($input);        
        return redirect()->route('income.index')->with('success','Income updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Income::find($id)->delete();
        return redirect()->route('income.index')
                        ->with('success','Record deleted successfully');
    }
}
