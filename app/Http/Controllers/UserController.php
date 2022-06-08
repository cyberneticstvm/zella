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
    protected $settings, $sales_this_year, $sales_this_month, $sales_last_month, $revenue_this_year, $revenue_this_month, $revenue_last_month, $expense_this_year, $expense_this_month, $expense_last_month, $purchase_this_year, $purchase_this_month, $purchase_last_month;

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

        $revenue = DB::table('sales AS s')->leftJoin('sales_details AS sd', 'sd.sales_id', '=', 's.id')->selectRaw('sum(sd.total) - s.discount as total')->where('sd.is_return', 0)->where('s.is_dead_stock', 0)->whereYear('s.sold_date', date('Y'))->groupBy('s.id', 's.discount')->get();
        $this->revenue_this_year = $revenue->sum('total');

        $revenue1 = DB::table('sales AS s')->leftJoin('sales_details AS sd', 'sd.sales_id', '=', 's.id')->selectRaw('sum(sd.total) - s.discount as total')->where('s.is_dead_stock', 0)->where('sd.is_return', 0)->whereMonth('s.sold_date', date('m'))->groupBy('s.id', 's.discount')->get();
        $this->revenue_this_month = $revenue1->sum('total');

        $revenue2 = DB::table('sales AS s')->leftJoin('sales_details AS sd', 'sd.sales_id', '=', 's.id')->selectRaw('sum(sd.total) - s.discount as total')->where('s.is_dead_stock', 0)->where('sd.is_return', 0)->whereMonth('s.sold_date', Carbon::now()->subMonth()->month)->whereYear('s.sold_date', date('Y'))->groupBy('s.id', 's.discount')->get();
        $this->revenue_last_month = $revenue2->sum('total');

        $this->expense_this_year = DB::table('expenses')->whereYear('expense_date', date('Y'))->sum('amount');
        $this->expense_this_month = DB::table('expenses')->whereMonth('expense_date', date('m'))->whereYear('expense_date', date('Y'))->sum('amount');
        $this->expense_last_month = DB::table('expenses')->whereMonth('expense_date', Carbon::now()->subMonth()->month)->whereYear('expense_date', date('Y'))->sum('amount');

        $purchase = DB::table('purchases AS p')->leftJoin('purchase_details AS pd', 'pd.purchase_id', '=', 'p.id')->selectRaw('sum(pd.total) + p.other_expense as total')->where('pd.is_return', 0)->whereYear('p.delivery_date', date('Y'))->groupBy('p.id', 'p.other_expense')->get();
        $this->purchase_this_year = $purchase->sum('total');

        $purchase1 = DB::table('purchases AS p')->leftJoin('purchase_details AS pd', 'pd.purchase_id', '=', 'p.id')->selectRaw('sum(pd.total) + p.other_expense as total')->where('pd.is_return', 0)->whereMonth('p.delivery_date', date('m'))->groupBy('p.id', 'p.other_expense')->get();
        $this->purchase_this_month = $purchase1->sum('total');

        $purchase2 = DB::table('purchases AS p')->leftJoin('purchase_details AS pd', 'pd.purchase_id', '=', 'p.id')->selectRaw('sum(pd.total) + p.other_expense as total')->where('pd.is_return', 0)->whereMonth('p.delivery_date', Carbon::now()->subMonth()->month)->whereYear('p.delivery_date', date('Y'))->groupBy('p.id', 'p.other_expense')->get();
        $this->purchase_last_month = $purchase2->sum('total');
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
        return view('dash', compact('sales_this_year', 'sales_this_month', 'sales_last_month', 'revenue_this_year', 'revenue_this_month', 'revenue_last_month', 'expense_this_year', 'expense_this_month', 'expense_last_month', 'purchase_this_year', 'purchase_this_month', 'purchase_last_month'));
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
            return view('dash', compact('sales_this_year', 'sales_this_month', 'sales_last_month', 'revenue_this_year', 'revenue_this_month', 'revenue_last_month', 'expense_this_year', 'expense_this_month', 'expense_last_month', 'purchase_this_year', 'purchase_this_month', 'purchase_last_month'));
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
