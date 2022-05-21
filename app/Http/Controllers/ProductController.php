<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = DB::table('products as p')->leftJoin('collections as c', 'p.collection', '=', 'c.id')->select('p.id', 'p.name', 'p.sku', 'p.purchase_price', 'p.selling_price', 'p.description', 'p.vat_applicable', 'c.name as collection_name')->orderBy('p.name','ASC')->get();
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sizes = DB::table('variants')->where('parent', '=', '1')->get();
        $colors = DB::table('variants')->where('parent', '=', '2')->get();
        $materials = DB::table('variants')->where('parent', '=', '3')->get();
        $collections = DB::table('collections')->get();
        return view('product.create', compact('sizes', 'colors', 'materials', 'collections'));
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
            'name' => 'required|unique:products,name',
            'collection' => 'required',
            'sku' => 'required|unique:products,sku',
            'selling_price' => 'required|numeric|min:1',
        ]);
        $input = $request->all();
        $input['vat_applicable'] = ($request->has('vat_applicable')) ? 1 : 0;
        $product = Product::create($input);
        return redirect()->route('product.index')
                        ->with('success','Product created successfully');
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
        $sizes = DB::table('variants')->where('parent', '=', '1')->get();
        $colors = DB::table('variants')->where('parent', '=', '2')->get();
        $materials = DB::table('variants')->where('parent', '=', '3')->get();
        $collections = DB::table('collections')->get();
        $product = Product::find($id);
        return view('product.edit', compact('sizes', 'colors', 'materials', 'collections', 'product'));
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
            'name' => 'required|unique:products,name,'.$id,
            'collection' => 'required',
            'sku' => 'required|unique:products,sku,'.$id,
            'selling_price' => 'required|numeric|min:1',
        ]);
        $input = $request->all();
        $input['vat_applicable'] = ($request->has('vat_applicable')) ? 1 : 0;
        $product = Product::find($id);
        $product->update($input);
        return redirect()->route('product.index')
                        ->with('success','Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::find($id)->delete();
        return redirect()->route('product.index')
                        ->with('success','Product deleted successfully');
    }
}
