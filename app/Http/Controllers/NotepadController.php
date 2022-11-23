<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notepad;
use Carbon\Carbon;
use DB;

class NotepadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notepads = Notepad::select('id', 'matter', DB::raw("DATE_FORMAT(date, '%d/%b/%Y') AS edate"))->orderByDesc("id")->get();
        return view('notepad.index', compact('notepads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('notepad.create');
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
            'matter' => 'required',
        ]);
        $input = $request->all();
        $input['created_by'] = $request->user()->id;
        $input['date'] = (!empty($request->date)) ? Carbon::createFromFormat('d/M/Y', $request['date'])->format('Y-m-d') : NULL;
        $notepad = Notepad::create($input);        
        return redirect()->route('notepad.index')->with('success','Data recorded successfully');
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
        $notepad = Notepad::find($id);  
        return view('notepad.edit', compact('notepad'));
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
            'matter' => 'required',
        ]);
        $input = $request->all();
        $notepad = Notepad::find($id);
        $input['created_by'] = $notepad->getOriginal('created_by');
        $input['date'] = (!empty($request->date)) ? Carbon::createFromFormat('d/M/Y', $request['date'])->format('Y-m-d') : NULL;        
        $notepad->update($input);        
        return redirect()->route('notepad.index')->with('success','Data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Notepad::find($id)->delete();
        return redirect()->route('notepad.index')
                        ->with('success','Record deleted successfully');
    }
}
