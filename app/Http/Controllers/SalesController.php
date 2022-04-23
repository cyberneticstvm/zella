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
        $this->settings = DB::table('settings')->find(1);
    }
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
            'payment_mode' => 'required',
        ]);
        $input = $request->all();
        $input['discount'] = ($request->discount > 0) ? $request->discount : 0;
        $input['sold_date'] = (!empty($request->sold_date)) ? Carbon::createFromFormat('d/M/Y', $request['sold_date'])->format('Y-m-d') : NULL;
        $input['created_by'] = $request->user()->id;
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
                        'price' => $input['price'][$i],
                        'vat_percentage' => $vat_percentage,
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
            'payment_mode' => 'required',
        ]);
        $input = $request->all();
        $input['sold_date'] = (!empty($request->sold_date)) ? Carbon::createFromFormat('d/M/Y', $request['sold_date'])->format('Y-m-d') : NULL;
        $input['discount'] = ($request->discount > 0) ? $request->discount : 0;
        $sales = Sales::find($id);
        $input['created_by'] = $sales->getOriginal('created_by');
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
                        'price' => $input['price'][$i],
                        'vat_percentage' => $vat_percentage,
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
