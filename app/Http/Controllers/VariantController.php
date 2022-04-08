<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Variant;
use DB;

class VariantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$variants = Variant::where('parent', '>', '0')->orderBy('name','ASC')->get();
        $variants = DB::table('variants as v1')->join('variants as v2', 'v1.id', '=', 'v2.parent')->select('v2.id', 'v1.name as parent', 'v2.name as child', 'v2.description')->get();
        return view('variant.index', compact('variants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $variants = Variant::where('parent', '=', '0')->orderBy('id','ASC')->pluck('name','id');
        return view('variant.create', compact('variants'));
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
            'name' => 'required|unique:variants,name',
            'parent' => 'required',
        ]);
        $input = $request->all();
        $variant = Variant::create($input);
        return redirect()->route('variant.index')
                        ->with('success','Variant created successfully');
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
        $variant = Variant::find($id);
        $variants = Variant::where('parent', '=', '0')->orderBy('id','ASC')->pluck('name','id');
        return view('variant.edit', compact('variant', 'variants'));
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
            'name' => 'required|unique:variants,name,'.$id,
            'parent' => 'required',
        ]);
        $input = $request->all();
        $variant = Variant::find($id);
        $variant->update($input);
        return redirect()->route('variant.index')
                        ->with('success','Variant updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Variant::find($id)->delete();
        return redirect()->route('variant.index')
                        ->with('success','Variant deleted successfully');
    }
}
