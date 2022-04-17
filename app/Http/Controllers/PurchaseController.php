<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use Carbon\Carbon;
use DB;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchases = Purchase::leftJoin('suppliers AS s', 'purchases.supplier', '=', 's.id')->select('purchases.id', DB::Raw("DATE_FORMAT(purchases.order_date, '%d/%b/%Y') AS odate"), DB::Raw("DATE_FORMAT(purchases.delivery_date, '%d/%b/%Y') AS ddate"), 'purchases.invoice_number', 's.name')->orderBy('purchases.delivery_date','ASC')->get();
        return view('purchase.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = DB::table('suppliers')->get();
        $products = DB::table('products')->get();
        return view('purchase.create', compact('suppliers', 'products'));
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
            'supplier' => 'required',
            'invoice_number' => 'required',
            'order_date' => 'required',
            'delivery_date' => 'required',
            'payment_mode' => 'required',
        ]);
        $input = $request->all();
        $input['order_date'] = (!empty($request->order_date)) ? Carbon::createFromFormat('d/M/Y', $request['order_date'])->format('Y-m-d') : NULL;
        $input['delivery_date'] = (!empty($request->delivery_date)) ? Carbon::createFromFormat('d/M/Y', $request['delivery_date'])->format('Y-m-d') : NULL;
        $purchase = Purchase::create($input);
        if($input['product']):
            for($i=0; $i<count($input['product']); $i++):
                if($input['product'][$i] > 0):
                    DB::table('purchase_details')->insert([
                        'purchase_id' => $purchase->id,
                        'product' => $input['product'][$i],
                        'qty' => $input['qty'][$i],
                        'price' => $input['price'][$i],
                        'total' => $input['total'][$i],
                    ]);
                endif;
            endfor;
        endif;
        return redirect()->route('purchase.index')->with('success','Purchase recorded successfully');
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
        $purchase = Purchase::find($id);
        $purchase_details = DB::table('purchase_details')->where('purchase_id', $id)->get();
        $suppliers = DB::table('suppliers')->get();
        $products = DB::table('products')->get();
        return view('purchase.edit', compact('suppliers', 'products', 'purchase', 'purchase_details'));
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
            'supplier' => 'required',
            'invoice_number' => 'required',
            'order_date' => 'required',
            'delivery_date' => 'required',
            'payment_mode' => 'required',
        ]);
        $input = $request->all();
        $input['order_date'] = (!empty($request->order_date)) ? Carbon::createFromFormat('d/M/Y', $request['order_date'])->format('Y-m-d') : NULL;
        $input['delivery_date'] = (!empty($request->delivery_date)) ? Carbon::createFromFormat('d/M/Y', $request['delivery_date'])->format('Y-m-d') : NULL;
        $purchase = Purchase::find($id);
        $purchase->update($input);
        DB::table("purchase_details")->where('purchase_id', $id)->delete();
        if($input['product']):
            for($i=0; $i<count($input['product']); $i++):
                if($input['product'][$i] > 0):
                    DB::table('purchase_details')->insert([
                        'purchase_id' => $id,
                        'product' => $input['product'][$i],
                        'qty' => $input['qty'][$i],
                        'price' => $input['price'][$i],
                        'total' => $input['total'][$i],
                    ]);
                endif;
            endfor;
        endif;
        return redirect()->route('purchase.index')->with('success','Purchase record updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Purchase::find($id)->delete();
        return redirect()->route('purchase.index')
                        ->with('success','Purchase record deleted successfully');
    }
}
