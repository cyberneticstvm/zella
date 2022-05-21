<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SettingsController extends Controller
{
    private $settings;

    public function __construct(){
        $this->settings = DB::table('settings')->find(1);
    }

    public function getvat(){
        $settings = $this->settings;
        return view('settings.vat', compact('settings'));
    }

    public function updatevat(Request $request, $id){
        $this->validate($request, [
            'vat_percentage' => 'required',
        ]);
        DB::table('settings')->where('id', $id)->update(['vat_percentage' => $request->vat_percentage]);
        $settings = $this->settings;
        return redirect()->route('settings.vat')
                        ->with('success','VAT updated successfully');
    }

    public function getcardfee(){
        $settings = $this->settings;
        return view('settings.cardfee', compact('settings'));
    }

    public function updatecardfee(Request $request, $id){
        $this->validate($request, [
            'card_fee' => 'required',
        ]);
        DB::table('settings')->where('id', $id)->update(['card_fee' => $request->card_fee]);
        $settings = $this->settings;
        return redirect()->route('settings.cardfee')
                        ->with('success','Card Fee updated successfully');
    }
}
