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
     * 
     */
    protected $purchases;

    public function __construct(){
        $this->middleware('permission:purchase-list|purchase-create|purchase-edit|purchase-delete', ['only' => ['index','show']]);
        $this->middleware('permission:purchase-create', ['only' => ['create','store']]);
        $this->middleware('permission:purchase-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:purchase-delete', ['only' => ['destroy']]);

        $this->purchases = Purchase::leftJoin('suppliers AS s', 'purchases.supplier', '=', 's.id')->select('purchases.id', DB::Raw("DATE_FORMAT(purchases.order_date, '%d/%b/%Y') AS odate"), DB::Raw("DATE_FORMAT(purchases.delivery_date, '%d/%b/%Y') AS ddate"), 'purchases.invoice_number', 's.name')->where('purchases.supplier', '!=', 0)->orderBy('purchases.id','DESC')->get();
        //test        
    }

    public function index()
    {
        $purchases = $this->purchases;
        return view('purchase.index', compact('purchases'));
    }

    public function getPurchaseReturns(){
        $preturns = Purchase::leftJoin('purchase_details as pd', 'purchases.id', '=', 'pd.purchase_id')->leftJoin('suppliers as s', 'purchases.supplier', '=', 's.id')->select('purchases.id', DB::Raw("DATE_FORMAT(purchases.order_date, '%d/%b/%Y') AS odate"), DB::Raw("DATE_FORMAT(purchases.delivery_date, '%d/%b/%Y') AS ddate"), 'purchases.invoice_number', 's.name')->where('pd.is_return', '=', 1)->orderBy('purchases.created_at','DESC')->get();
        return view('purchase.return', compact('preturns'));
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
        $purchases = $this->purchases;
        return view('purchase.create', compact('suppliers', 'products', 'purchases'));
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
            'payment_status' => 'required',
            'payment_mode' => 'required',
        ]);
        $input = $request->all();
        $input['other_expense'] = ($request->other_expense > 0) ? $request->other_expense : 0;
        $input['order_date'] = (!empty($request->order_date)) ? Carbon::createFromFormat('d/M/Y', $request['order_date'])->format('Y-m-d') : NULL;
        $input['delivery_date'] = (!empty($request->delivery_date)) ? Carbon::createFromFormat('d/M/Y', $request['delivery_date'])->format('Y-m-d') : NULL;
        $input['created_by'] = $request->user()->id;
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
        //return redirect()->route('purchase.index')->with('success','Purchase recorded successfully');
        $purchases = Purchase::leftJoin('suppliers AS s', 'purchases.supplier', '=', 's.id')->select('purchases.id', DB::Raw("DATE_FORMAT(purchases.order_date, '%d/%b/%Y') AS odate"), DB::Raw("DATE_FORMAT(purchases.delivery_date, '%d/%b/%Y') AS ddate"), 'purchases.invoice_number', 's.name')->orderBy('purchases.id','desc')->get(); 
        $suppliers = DB::table('suppliers')->get();
        $products = DB::table('products')->get();
        return redirect()->route('purchase.create', ['suppliers' => $suppliers, 'products' => $products, 'purchases' => $purchases])->with('success','Purchase recorded successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fetch(Request $request)
    {
        $this->validate($request, [
            'invoice_number' => 'required',
        ]);
        $id = $request->invoice_number;
        $purchase = Purchase::find($id); $preturns = [];
        $purchases = DB::table('purchase_details as pu')->leftJoin('products as p', 'pu.product', '=', 'p.id')->select('pu.id', 'pu.qty', 'pu.price', 'pu.total', 'pu.is_return', 'p.name')->where('purchase_id', $id)->get();

        $preturns = Purchase::leftJoin('purchase_details as pd', 'purchases.id', '=', 'pd.purchase_id')->leftJoin('suppliers as s', 'purchases.supplier', '=', 's.id')->select('purchases.id', DB::Raw("DATE_FORMAT(purchases.order_date, '%d/%b/%Y') AS odate"), DB::Raw("DATE_FORMAT(purchases.delivery_date, '%d/%b/%Y') AS ddate"), 'purchases.invoice_number', 's.name')->where('pd.is_return', '=', 1)->orderBy('purchases.created_at','DESC')->get();
        
        return view('purchase.return', compact('purchase', 'purchases', 'preturns'));
    }

    public function updatereturn(Request $request){
        $today = Carbon::now()->format('Y-m-d');
        $val = $request->val;
        $id = $request->id;
        DB::table('purchase_details')->where('id', $id)->update([
            'is_return' => $val,
            'return_date' => $today
        ]);
        //echo "Record updated successfully.";
        echo "/purchase/return/";
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
        $input['other_expense'] = ($request->other_expense > 0) ? $request->other_expense : 0;
        $input['order_date'] = (!empty($request->order_date)) ? Carbon::createFromFormat('d/M/Y', $request['order_date'])->format('Y-m-d') : NULL;
        $input['delivery_date'] = (!empty($request->delivery_date)) ? Carbon::createFromFormat('d/M/Y', $request['delivery_date'])->format('Y-m-d') : NULL;
        $purchase = Purchase::find($id);
        $input['created_by'] = $purchase->getOriginal('created_by');
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
