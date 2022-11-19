<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Hash;
use Session;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $settings, $sales_this_year, $sales_this_month, $sales_last_month, $revenue_this_year, $revenue_this_month, $revenue_last_month, $expense_this_year, $expense_this_month, $expense_last_month, $purchase_this_year, $purchase_this_month, $purchase_last_month, $sales_last_year, $revenue_last_year, $expense_last_year, $purchase_last_year, $products, $collections, $sales_this_week, $sales_today, $revenue_today, $revenue_this_week, $expense_this_week, $expense_today, $purchase_this_week, $purchase_today;

    function __construct(){

        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','show']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);

        $this->settings = DB::table('settings')->find(1);
        $vat = $this->settings->vat_percentage;

        $this->sales_this_year = DB::table('sales')->where('is_dead_stock', 0)->whereYear('sold_date', date('Y'))->count('id');
        $this->sales_this_month = DB::table('sales')->where('is_dead_stock', 0)->whereMonth('sold_date', date('m'))->whereYear('sold_date', date('Y'))->count('id');
        $this->sales_last_month = DB::table('sales')->where('is_dead_stock', 0)->whereMonth('sold_date', Carbon::now()->subMonth()->month)->whereYear('sold_date', date('Y'))->count('id');
        $this->sales_last_year = DB::table('sales')->where('is_dead_stock', 0)->whereYear('sold_date', date("Y", strtotime("-1 year")))->count('id');
        $this->sales_today = DB::table('sales')->where('is_dead_stock', 0)->whereDate('sold_date', Carbon::today())->count('id');
        $this->sales_this_week = DB::table('sales')->where('is_dead_stock', 0)->whereBetween('sold_date', [Carbon::now()->subWeek()->format("Y-m-d"), Carbon::today()])->count('id');

        $this->revenue_this_year = DB::table('sales AS s')->leftJoin('sales_details AS sd', 's.id', 'sd.sales_id')->selectRaw("s.id, DATE_FORMAT(s.sold_date, '%d/%b/%Y') AS sdate, s.customer_name, s.contact_number, s.address, s.payment_status, s.payment_mode, CASE WHEN sd.vat_percentage > 0 THEN (SUM(sd.qty*sd.price)+((SUM(sd.qty*sd.price)*sd.vat_percentage)/100)) - s.discount ELSE SUM(sd.qty*sd.price) - s.discount END AS total1, s.order_total as total")->where('s.is_dead_stock', 0)->where('sd.is_return', 0)->whereYear('s.sold_date', Carbon::today()->year)->groupBy('s.id', 's.customer_name', 's.contact_number', 's.address', 's.payment_status', 's.payment_mode', 's.sold_date', 's.discount', 's.order_total', 'sd.vat_percentage')->get()->sum('total');

        $this->revenue_last_year = DB::table('sales AS s')->leftJoin('sales_details AS sd', 's.id', 'sd.sales_id')->selectRaw("s.id, DATE_FORMAT(s.sold_date, '%d/%b/%Y') AS sdate, s.customer_name, s.contact_number, s.address, s.payment_status, s.payment_mode, CASE WHEN sd.vat_percentage > 0 THEN (SUM(sd.qty*sd.price)+((SUM(sd.qty*sd.price)*sd.vat_percentage)/100)) - s.discount ELSE SUM(sd.qty*sd.price) - s.discount END AS total1, s.order_total as total")->where('s.is_dead_stock', 0)->where('sd.is_return', 0)->whereYear('s.sold_date', Carbon::today()->subYear()->year)->groupBy('s.id', 's.customer_name', 's.contact_number', 's.address', 's.payment_status', 's.payment_mode', 's.sold_date', 's.discount', 's.order_total', 'sd.vat_percentage')->get()->sum('total');

        $this->revenue_this_month = DB::table('sales AS s')->leftJoin('sales_details AS sd', 's.id', 'sd.sales_id')->selectRaw("s.id, DATE_FORMAT(s.sold_date, '%d/%b/%Y') AS sdate, s.customer_name, s.contact_number, s.address, s.payment_status, s.payment_mode, CASE WHEN sd.vat_percentage > 0 THEN (SUM(sd.qty*sd.price)+((SUM(sd.qty*sd.price)*sd.vat_percentage)/100)) - s.discount ELSE SUM(sd.qty*sd.price) - s.discount END AS total1, s.order_total as total")->where('s.is_dead_stock', 0)->where('sd.is_return', 0)->whereMonth('s.sold_date', Carbon::today()->month)->groupBy('s.id', 's.customer_name', 's.contact_number', 's.address', 's.payment_status', 's.payment_mode', 's.sold_date', 's.discount', 's.order_total', 'sd.vat_percentage')->get()->sum('total');

        $this->revenue_last_month = DB::table('sales AS s')->leftJoin('sales_details AS sd', 's.id', 'sd.sales_id')->selectRaw("s.id, DATE_FORMAT(s.sold_date, '%d/%b/%Y') AS sdate, s.customer_name, s.contact_number, s.address, s.payment_status, s.payment_mode, CASE WHEN sd.vat_percentage > 0 THEN (SUM(sd.qty*sd.price)+((SUM(sd.qty*sd.price)*sd.vat_percentage)/100)) - s.discount ELSE SUM(sd.qty*sd.price) - s.discount END AS total1, s.order_total as total")->where('s.is_dead_stock', 0)->where('sd.is_return', 0)->whereMonth('s.sold_date', Carbon::today()->subMonth()->month)->groupBy('s.id', 's.customer_name', 's.contact_number', 's.address', 's.payment_status', 's.payment_mode', 's.sold_date', 's.discount', 's.order_total', 'sd.vat_percentage')->get()->sum('total');

        $this->revenue_today = DB::table('sales AS s')->leftJoin('sales_details AS sd', 's.id', 'sd.sales_id')->selectRaw("s.id, DATE_FORMAT(s.sold_date, '%d/%b/%Y') AS sdate, s.customer_name, s.contact_number, s.address, s.payment_status, s.payment_mode, CASE WHEN sd.vat_percentage > 0 THEN (SUM(sd.qty*sd.price)+((SUM(sd.qty*sd.price)*sd.vat_percentage)/100)) - s.discount ELSE SUM(sd.qty*sd.price) - s.discount END AS total1, s.order_total as total")->where('s.is_dead_stock', 0)->where('sd.is_return', 0)->whereDate('s.sold_date', Carbon::today())->groupBy('s.id', 's.customer_name', 's.contact_number', 's.address', 's.payment_status', 's.payment_mode', 's.sold_date', 's.discount', 's.order_total', 'sd.vat_percentage')->get()->sum('total');

        $this->revenue_this_week = DB::table('sales AS s')->leftJoin('sales_details AS sd', 's.id', 'sd.sales_id')->selectRaw("s.id, DATE_FORMAT(s.sold_date, '%d/%b/%Y') AS sdate, s.customer_name, s.contact_number, s.address, s.payment_status, s.payment_mode, CASE WHEN sd.vat_percentage > 0 THEN (SUM(sd.qty*sd.price)+((SUM(sd.qty*sd.price)*sd.vat_percentage)/100)) - s.discount ELSE SUM(sd.qty*sd.price) - s.discount END AS total1, s.order_total as total")->where('s.is_dead_stock', 0)->where('sd.is_return', 0)->whereBetween('s.sold_date', [Carbon::now()->subWeek()->format("Y-m-d"), Carbon::today()])->groupBy('s.id', 's.customer_name', 's.contact_number', 's.address', 's.payment_status', 's.payment_mode', 's.sold_date', 's.discount', 's.order_total', 'sd.vat_percentage')->get()->sum('total');
        

        $this->expense_this_year = DB::table('expenses')->whereYear('date', date('Y'))->sum('amount');
        $this->expense_this_month = DB::table('expenses')->whereMonth('date', date('m'))->whereYear('date', date('Y'))->sum('amount');
        $this->expense_last_month = DB::table('expenses')->whereMonth('date', Carbon::now()->subMonth()->month)->whereYear('date', date('Y'))->sum('amount');
        $this->expense_last_year = DB::table('expenses')->whereYear('date', date('Y', strtotime("-1 year")))->sum('amount');

        $this->expense_this_week = DB::table('expenses')->whereBetween('date', [Carbon::now()->subWeek()->format("Y-m-d"), Carbon::today()])->sum('amount');
        $this->expense_today = DB::table('expenses')->whereDate('date', Carbon::today())->sum('amount');

        $this->purchase_this_year = DB::table('purchases as p')->leftJoin('purchase_details as pd', 'p.id', 'pd.purchase_id')->leftJoin('suppliers as s', 'p.supplier', '=', 's.id')->selectRaw('p.id, p.invoice_number, p.order_date, p.delivery_date, p.payment_mode, s.name as sname, SUM(pd.total)+p.other_expense as total')->where('pd.is_return', 0)->whereYear('p.delivery_date', Carbon::today()->year)->groupBy('p.id', 'p.invoice_number', 'p.order_date', 'p.delivery_date', 'p.payment_mode', 's.name', 'p.other_expense')->get()->sum('total');

        $this->purchase_this_month = DB::table('purchases as p')->leftJoin('purchase_details as pd', 'p.id', 'pd.purchase_id')->leftJoin('suppliers as s', 'p.supplier', '=', 's.id')->selectRaw('p.id, p.invoice_number, p.order_date, p.delivery_date, p.payment_mode, s.name as sname, SUM(pd.total)+p.other_expense as total')->where('pd.is_return', 0)->whereMonth('p.delivery_date', Carbon::today()->month)->groupBy('p.id', 'p.invoice_number', 'p.order_date', 'p.delivery_date', 'p.payment_mode', 's.name', 'p.other_expense')->get()->sum('total');

        $this->purchase_last_month = DB::table('purchases as p')->leftJoin('purchase_details as pd', 'p.id', 'pd.purchase_id')->leftJoin('suppliers as s', 'p.supplier', '=', 's.id')->selectRaw('p.id, p.invoice_number, p.order_date, p.delivery_date, p.payment_mode, s.name as sname, SUM(pd.total)+p.other_expense as total')->where('pd.is_return', 0)->whereMonth('p.delivery_date', Carbon::today()->subMonth()->month)->groupBy('p.id', 'p.invoice_number', 'p.order_date', 'p.delivery_date', 'p.payment_mode', 's.name', 'p.other_expense')->get()->sum('total');

        $this->purchase_last_year = DB::table('purchases as p')->leftJoin('purchase_details as pd', 'p.id', 'pd.purchase_id')->leftJoin('suppliers as s', 'p.supplier', '=', 's.id')->selectRaw('p.id, p.invoice_number, p.order_date, p.delivery_date, p.payment_mode, s.name as sname, SUM(pd.total)+p.other_expense as total')->where('pd.is_return', 0)->whereYear('p.delivery_date', Carbon::today()->subYear()->year)->groupBy('p.id', 'p.invoice_number', 'p.order_date', 'p.delivery_date', 'p.payment_mode', 's.name', 'p.other_expense')->get()->sum('total');

        $this->purchase_this_week = DB::table('purchases as p')->leftJoin('purchase_details as pd', 'p.id', 'pd.purchase_id')->leftJoin('suppliers as s', 'p.supplier', '=', 's.id')->selectRaw('p.id, p.invoice_number, p.order_date, p.delivery_date, p.payment_mode, s.name as sname, SUM(pd.total)+p.other_expense as total')->where('pd.is_return', 0)->whereBetween('p.delivery_date', [Carbon::now()->subWeek()->format("Y-m-d"), Carbon::today()])->groupBy('p.id', 'p.invoice_number', 'p.order_date', 'p.delivery_date', 'p.payment_mode', 's.name', 'p.other_expense')->get()->sum('total');

        $this->purchase_today = DB::table('purchases as p')->leftJoin('purchase_details as pd', 'p.id', 'pd.purchase_id')->leftJoin('suppliers as s', 'p.supplier', '=', 's.id')->selectRaw('p.id, p.invoice_number, p.order_date, p.delivery_date, p.payment_mode, s.name as sname, SUM(pd.total)+p.other_expense as total')->where('pd.is_return', 0)->whereDate('p.delivery_date', Carbon::today())->groupBy('p.id', 'p.invoice_number', 'p.order_date', 'p.delivery_date', 'p.payment_mode', 's.name', 'p.other_expense')->get()->sum('total');

        $this->products = DB::table('products')->get();
        $this->collections = DB::table('collections')->get();
    }
    public function index()
    {
        $users = User::orderBy('name','ASC')->get();
        return view('user.index', compact('users'));
    }

    public function dash(){
        $sales_this_year = $this->sales_this_year;
        $sales_this_month = $this->sales_this_month;
        $sales_last_month = $this->sales_last_month;
        $revenue_this_year = $this->revenue_this_year;
        $revenue_this_month = $this->revenue_this_month;
        $revenue_last_month = $this->revenue_last_month;
        $expense_this_year = $this->expense_this_year;
        $expense_this_month = $this->expense_this_month;
        $expense_last_month = $this->expense_last_month;
        $purchase_this_year = $this->purchase_this_year;
        $purchase_this_month = $this->purchase_this_month;
        $purchase_last_month = $this->purchase_last_month;
        $revenue_last_year = $this->revenue_last_year;
        $expense_last_year = $this->expense_last_year;
        $purchase_last_year = $this->purchase_last_year;

        $sales_last_year = $this->sales_last_year;
        $products = $this->products;
        $collections = $this->collections;
        $sales_this_week = $this->sales_this_week;
        $sales_today = $this->sales_today;
        $revenue_this_week = $this->revenue_this_week;
        $revenue_today = $this->revenue_today;
        $expense_this_week = $this->expense_this_week;
        $expense_today = $this->expense_today;
        $purchase_this_week = $this->purchase_this_week;
        $purchase_today = $this->purchase_today;

        return view('dash', compact('sales_this_year', 'sales_this_month', 'sales_last_month', 'revenue_this_year', 'revenue_this_month', 'revenue_last_month', 'expense_this_year', 'expense_this_month', 'expense_last_month', 'purchase_this_year', 'purchase_this_month', 'purchase_last_month', 'sales_last_year', 'revenue_last_year', 'expense_last_year', 'purchase_last_year', 'products', 'collections', 'sales_today', 'sales_this_week', 'revenue_this_week', 'revenue_today', 'expense_this_week', 'expense_today', 'purchase_this_week', 'purchase_today'));
    }

    public function login(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)){   
            $sales_this_year = $this->sales_this_year;        
            $sales_this_month = $this->sales_this_month;
            $sales_last_month = $this->sales_last_month;
            $revenue_this_year = $this->revenue_this_year;
            $revenue_this_month = $this->revenue_this_month;
            $revenue_last_month = $this->revenue_last_month;
            $expense_this_year = $this->expense_this_year;
            $expense_this_month = $this->expense_this_month;
            $expense_last_month = $this->expense_last_month;
            $purchase_this_year = $this->purchase_this_year;
            $purchase_this_month = $this->purchase_this_month;
            $purchase_last_month = $this->purchase_last_month;
            $revenue_last_year = $this->revenue_last_year;
            $expense_last_year = $this->expense_last_year;
            $purchase_last_year = $this->purchase_last_year;

            $sales_last_year = $this->sales_last_year;
            $products = $this->products;
            $collections = $this->collections;
            $sales_this_week = $this->sales_this_week;
            $sales_today = $this->sales_today;
            $revenue_this_week = $this->revenue_this_week;
            $revenue_today = $this->revenue_today;
            $expense_this_week = $this->expense_this_week;
            $expense_today = $this->expense_today;
            $purchase_this_week = $this->purchase_this_week;
            $purchase_today = $this->purchase_today;

            return view('dash', compact('sales_this_year', 'sales_this_month', 'sales_last_month', 'revenue_this_year', 'revenue_this_month', 'revenue_last_month', 'expense_this_year', 'expense_this_month', 'expense_last_month', 'purchase_this_year', 'purchase_this_month', 'purchase_last_month', 'sales_last_year', 'revenue_last_year', 'expense_last_year', 'purchase_last_year', 'products', 'collections', 'sales_today', 'sales_this_week', 'revenue_this_week', 'revenue_today', 'expense_this_week', 'expense_today', 'purchase_this_week', 'purchase_today'));
        }
        return redirect()->route('login')->withErrors('Login details are not valid');
    }

    public function logout() {
        Session::flush();
        Auth::logout();
        //return redirect()->away('https://erp.zellaboutiqueuae.com');
        return redirect()->route('login')->with('success','User logged out successfully');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('user.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $items = $request->get('branch_id');
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'roles' => 'required',
        ]);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        return redirect()->route('user.index')
                        ->with('success','User created successfully');
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
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view('user.edit',compact('user', 'roles', 'userRole'));
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
        $items = $request->get('branch_id');
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required|unique:users,username,'.$id,
            'email' => 'required|email|unique:users,email,'.$id,
        ]);
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('roles'));
        return redirect()->route('user.index')
                        ->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('user.index')
                        ->with('success','User deleted successfully');
    }
}
