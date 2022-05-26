<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use DB;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
         $this->middleware('permission:collection-list|collection-create|collection-edit|collection-delete', ['only' => ['index','show']]);
         $this->middleware('permission:collection-create', ['only' => ['create','store']]);
         $this->middleware('permission:collection-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:collection-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $collections = Collection::orderBy('name','ASC')->get();
        return view('collection.index', compact('collections'));
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
            'name' => 'required|unique:collections,name',
        ]);
        $input = $request->all();
        $input['created_by'] = $request->user()->id;
        $collection = Collection::create($input);
        return redirect()->route('collection.index')
                        ->with('success','Collection created successfully');
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
        $collection = Collection::find($id);
        return view('collection.edit', compact('collection'));
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
            'name' => 'required|unique:collections,name,'.$id,
        ]);
        $input = $request->all();
        $collection = Collection::find($id);
        $input['created_by'] = $collection->getOriginal('created_by');
        $collection->update($input);
        return redirect()->route('collection.index')
                        ->with('success','Collection updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Collection::find($id)->delete();
        return redirect()->route('collection.index')
                        ->with('success','Collection deleted successfully');
    }
}
