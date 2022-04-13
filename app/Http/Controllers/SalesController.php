<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sales;
use Carbon\Carbon;
use DB;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sales::get();
        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = DB::table('products')->get();
        return view('sales.create', compact('products'));
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
            'customer_name' => 'required',
            'contact_number' => 'required',
            'address' => 'required',
            'sold_date' => 'required',
        ]);
        $input = $request->all();
        $input['sold_date'] = (!empty($request->sold_date)) ? Carbon::createFromFormat('d/M/Y', $request['sold_date'])->format('Y-m-d') : NULL;
        $input['created_by'] = $request->user()->id;
        $sales = Sales::create($input);
        if($input['product']):
            for($i=0; $i<count($input['product']); $i++):
                if($input['product'][$i] > 0):
                    DB::table('sales_details')->insert([
                        'sales_id' => $sales->id,
                        'product' => $input['product'][$i],
                        'qty' => $input['qty'][$i],
                        'price' => $input['price'][$i],
                        'total' => $input['total'][$i],
                    ]);
                endif;
            endfor;
        endif;
        return redirect()->route('sales.index')->with('success','Sales recorded successfully');
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
        $sales = Sales::find($id);
        $sales_details = DB::table('sales_details')->where('sales_id', $id)->get();
        $products = DB::table('products')->get();
        return view('sales.edit', compact('sales', 'products', 'sales_details'));
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
            'customer_name' => 'required',
            'contact_number' => 'required',
            'address' => 'required',
            'sold_date' => 'required',
        ]);
        $input = $request->all();
        $input['sold_date'] = (!empty($request->sold_date)) ? Carbon::createFromFormat('d/M/Y', $request['sold_date'])->format('Y-m-d') : NULL;

        $sales = Sales::find($id);
        $input['created_by'] = $sales->getOriginal('created_by');
        $sales->update($input);
        DB::table("sales_details")->where('sales_id', $id)->delete();
        if($input['product']):
            for($i=0; $i<count($input['product']); $i++):
                if($input['product'][$i] > 0):
                    DB::table('sales_details')->insert([
                        'sales_id' => $sales->id,
                        'product' => $input['product'][$i],
                        'qty' => $input['qty'][$i],
                        'price' => $input['price'][$i],
                        'total' => $input['total'][$i],
                    ]);
                endif;
            endfor;
        endif;
        return redirect()->route('sales.index')->with('success','Sales record updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Sales::find($id)->delete();
        return redirect()->route('sales.index')
                        ->with('success','Sales record deleted successfully');
    }
}
