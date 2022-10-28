<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sales;
use Carbon\Carbon;
use DB;

class SalesController extends Controller
{
    private $settings;

    public function __construct(){
        $this->middleware('permission:sales-list|sales-create|sales-edit|sales-delete', ['only' => ['index','show']]);
        $this->middleware('permission:sales-create', ['only' => ['create','store']]);
        $this->middleware('permission:sales-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:sales-delete', ['only' => ['destroy']]);

        $this->settings = DB::table('settings')->find(1);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sales::orderBy('id', 'desc')->where('is_dead_stock', 0)->get();
        return view('sales.index', compact('sales'));
    }

    public function getSalesReturns(){
        $sreturns = Sales::leftJoin('sales_details as sd', 'sales.id', '=', 'sd.sales_id')->select('sales.id', DB::Raw("DATE_FORMAT(sales.sold_date, '%d/%b/%Y') AS sdate"), 'sales.customer_name', 'sales.contact_number', 'sales.address', 'sales.payment_mode')->where('sd.is_return', '=', 1)->orderBy('sales.sold_date','DESC')->get();
        return view('sales.return', compact('sreturns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = DB::table('products')->get();
        $sales = Sales::orderBy('id', 'desc')->where('is_dead_stock', 0)->get();
        $settings = $this->settings;
        return view('sales.create', compact('products', 'sales', 'settings'));
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
            'payment_mode' => 'required',
            'payment_status' => 'required',
        ]);
        $input = $request->all();
        $input['discount'] = ($request->discount > 0) ? $request->discount : 0;
        $input['sold_date'] = (!empty($request->sold_date)) ? Carbon::createFromFormat('d/M/Y', $request['sold_date'])->format('Y-m-d') : NULL;
        $input['card_fee'] = ($request->payment_mode == 'card') ? $this->settings->card_fee : 0.00;
        $input['vat_percentage'] = $this->settings->vat_percentage;
        $input['created_by'] = $request->user()->id;
        $is_stock_in_hand = ($this->settings->allow_sales_zero_qty == 0) ? $this->checkStockInHand($input['product'], $input['qty']) : true;
        if(!$is_stock_in_hand):
            return back()->withInput()->withErrors("One or more items in this order doesn't have enough qty.");
        else:
            $sales = Sales::create($input);
            if($input['product']):
                for($i=0; $i<count($input['product']); $i++):
                    if($input['product'][$i] > 0):
                        $product = DB::table('products')->find($input['product'][$i]);
                        $vat_percentage = ($this->settings->vat_percentage > 0 && $product->vat_applicable == 1) ? $this->settings->vat_percentage : 0;
                        DB::table('sales_details')->insert([
                            'sales_id' => $sales->id,
                            'product' => $input['product'][$i],
                            'qty' => $input['qty'][$i],
                            'price' => ($input['is_dead_stock'] == 0) ? $input['price'][$i] : 0.00,
                            'vat_percentage' => $vat_percentage,
                            'total' => ($input['is_dead_stock'] == 0) ? $input['total'][$i] : 0.00,
                        ]);
                    endif;
                endfor;
            endif;
            $products = DB::table('products')->get();
            if($request->is_dead_stock == 0):
                $sales = Sales::orderBy('id', 'desc')->get();
                return redirect()->route('sales.create', ['sales' => $sales, 'products' => $products])->with('success','Sales recorded successfully');
            else:
                $sales = Sales::orderBy('id', 'desc')->where('is_dead_stock', 0)->get();
                return redirect()->route('sales.deadstock', ['sales' => $sales, 'products' => $products])->with('success','Deadstock recorded successfully');
            endif;
        endif;
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
        $sale = Sales::find($id); $sreturns = [];
        $sales = DB::table('sales_details as s')->leftJoin('products as p', 's.product', '=', 'p.id')->select('s.id', 's.qty', 's.price', 's.total', 's.is_return', 'p.name')->where('sales_id', $id)->get();

        $sreturns = Sales::leftJoin('sales_details as sd', 'sales.id', '=', 'sd.sales_id')->select('sales.id', DB::Raw("DATE_FORMAT(sales.sold_date, '%d/%b/%Y') AS sdate"), 'sales.customer_name', 'sales.contact_number', 'sales.address', 'sales.payment_mode')->where('sd.is_return', '=', 1)->orderBy('sales.sold_date','DESC')->get();
        
        return view('sales.return', compact('sale', 'sales', 'sreturns'));
    }

    public function updatereturn(Request $request){
        $today = Carbon::now()->format('Y-m-d');
        $val = $request->val;
        $id = $request->id;
        DB::table('sales_details')->where('id', $id)->update([
            'is_return' => $val,
            'return_date' => $today
        ]);
        echo "/sales/return/";
        //echo "Record updated successfully.";
        //return redirect()->route('sales.return')->with('success','Record updated successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function return($id){
        $sales = Sales::find($id);
        $sales_details = DB::table('sales_details')->where('sales_id', $id)->get();
        $products = DB::table('products')->get();
        $settings = $this->settings;
        return view('sales.return1', compact('sales', 'products', 'sales_details', 'settings'));
    }

    public function returnupdate(Request $request, $id){
        $input = $request->all();
        $is_stock_in_hand = ($this->settings->allow_sales_zero_qty == 0) ? $this->checkStockInHand($input['product'], $input['qty']) : true;
        //if(!$is_stock_in_hand):
            //return back()->withInput()->withErrors("One or more items in this order doesn't have enough qty.");
        //else:
            $upd = Sales::where('id', $id)->update(['order_total' => $request->order_total, 'cash_collected' => $request->cash_collected, 'card_collected' => $request->card_collected, 'payment_mode' => $request->payment_mode]);
            DB::table("sales_details")->where('sales_id', $id)->delete();
            if($input['product']):
                for($i=0; $i<count($input['product']); $i++):
                    if($input['product'][$i] > 0):
                        $product = DB::table('products')->find($input['product'][$i]);
                        $vat_percentage = ($this->settings->vat_percentage > 0 && $product->vat_applicable == 1) ? $this->settings->vat_percentage : 0;
                        DB::table('sales_details')->insert([
                            'sales_id' => $id,
                            'product' => $input['product'][$i],
                            'old_product' => ($input['status'][$i] == 2) ? $input['old_product'][$i] : 0,
                            'qty' => $input['qty'][$i],
                            'price' => ($input['is_dead_stock'] == 0) ? $input['price'][$i] : 0.00,
                            'vat_percentage' => $vat_percentage,
                            'total' => ($input['is_dead_stock'] == 0) ? $input['total'][$i] : 0.00,
                            'is_return' => ($input['status'][$i] == 1) ? $input['status'][$i] : 0,
                            'return_date' => ($input['status'][$i] == 1 || $input['status'][$i] == 2) ? Carbon::now() : NULL,
                        ]);
                    endif;
                endfor;
            endif;
            return redirect()->route('sales.index')->with('success','Sales record updated successfully');
        //endif;
    }

    public function edit($id)
    {
        $sales = Sales::find($id);
        $sales_details = DB::table('sales_details')->where('sales_id', $id)->get();
        $products = DB::table('products')->get();
        $settings = $this->settings;
        return view('sales.edit', compact('sales', 'products', 'sales_details', 'settings'));
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
            'payment_mode' => 'required',
            'payment_status' => 'required',
        ]);
        $input = $request->all();
        $input['sold_date'] = (!empty($request->sold_date)) ? Carbon::createFromFormat('d/M/Y', $request['sold_date'])->format('Y-m-d') : NULL;
        $input['card_fee'] = ($request->payment_mode == 'card') ? $this->settings->card_fee : 0.00;
        $input['vat_percentage'] = $this->settings->vat_percentage;
        $input['discount'] = ($request->discount > 0) ? $request->discount : 0;
        $sales = Sales::find($id);
        $input['created_by'] = $sales->getOriginal('created_by');
        $is_stock_in_hand = ($this->settings->allow_sales_zero_qty == 0) ? $this->checkStockInHand($input['product'], $input['qty']) : true;
        //if(!$is_stock_in_hand):
            //return back()->withInput()->withErrors("One or more items in this order doesn't have enough qty.");
        //else:
            $sales->update($input);
            DB::table("sales_details")->where('sales_id', $id)->delete();
            if($input['product']):
                for($i=0; $i<count($input['product']); $i++):
                    if($input['product'][$i] > 0):
                        $product = DB::table('products')->find($input['product'][$i]);
                        $vat_percentage = ($this->settings->vat_percentage > 0 && $product->vat_applicable == 1) ? $this->settings->vat_percentage : 0;
                        DB::table('sales_details')->insert([
                            'sales_id' => $sales->id,
                            'product' => $input['product'][$i],
                            'qty' => $input['qty'][$i],
                            'price' => ($input['is_dead_stock'] == 0) ? $input['price'][$i] : 0.00,
                            'vat_percentage' => $vat_percentage,
                            'total' => ($input['is_dead_stock'] == 0) ? $input['total'][$i] : 0.00,
                        ]);
                    endif;
                endfor;
            endif;
            return redirect()->route('sales.index')->with('success','Sales record updated successfully');
        //endif;
    }

    public function checkStockInHand($products, $qty){
        $item = true;
        if($products):
            for($i=0; $i<count($products); $i++):
                if($products[$i] > 0):
                    $stockin = DB::table('purchase_details')->where('product', $products[$i])->where('is_return', 0)->sum('qty');
                    $stockout = DB::table('sales_details')->where('product', $products[$i])->where('is_return', 0)->sum('qty');
                    $stock = $stockin - $stockout;
                    $item = ($stock >= $qty[$i]) ? true : false;
                    if(!$item) break;
                endif;
            endfor;
        endif;
        return $item;
    }

    public function deadstock(){
        $products = DB::table('products')->get();
        $sales = Sales::orderBy('id', 'desc')->where('is_dead_stock', 1)->get();
        return view('sales.deadstock', compact('products', 'sales'));
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
