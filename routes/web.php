<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\HelperController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
})->name('login');

Route::get('/phpinfo/', function () {
    return view('phpinfo');
})->name('phpinfo');

Route::post('/', 'App\Http\Controllers\UserController@login')->name('user.login');

Route::group(['middleware' => ['auth']], function(){

    Route::get('/logout/', 'App\Http\Controllers\UserController@logout');
    Route::get('/dash/', 'App\Http\Controllers\UserController@dash')->name('dash');

    // user //
    Route::get('/user/', 'App\Http\Controllers\UserController@index')->name('user.index');
    Route::get('/user/create/', 'App\Http\Controllers\UserController@create')->name('user.create');
    Route::post('/user/create/', 'App\Http\Controllers\UserController@store')->name('user.create');
    Route::get('/user/{id}/edit/', 'App\Http\Controllers\UserController@edit')->name('user.edit');
    Route::put('/user/{id}/edit/', 'App\Http\Controllers\UserController@update')->name('user.update');
    Route::delete('/user/{id}/delete/', 'App\Http\Controllers\UserController@destroy')->name('user.delete');
    // end user //

    // roles //
    Route::get('/roles/', 'App\Http\Controllers\RoleController@index')->name('roles.index');
    Route::get('/roles/create/', 'App\Http\Controllers\RoleController@create')->name('role.create');
    Route::post('/roles/create/', 'App\Http\Controllers\RoleController@store')->name('role.create');
    Route::get('/roles/{id}/edit/', 'App\Http\Controllers\RoleController@edit')->name('role.edit');
    Route::put('/roles/{id}/edit/', 'App\Http\Controllers\RoleController@update')->name('role.update');
    Route::delete('/roles/{id}/delete/', 'App\Http\Controllers\RoleController@destroy')->name('role.delete');
    // end roles //

    // collection //
    Route::get('/collection/', 'App\Http\Controllers\CollectionController@index')->name('collection.index');
    Route::get('/collection/create/', function () {
        return view('collection.create');
    });
    Route::post('/collection/create/', 'App\Http\Controllers\CollectionController@store')->name('collection.create');
    Route::get('/collection/{id}/edit/', 'App\Http\Controllers\CollectionController@edit')->name('collection.edit');
    Route::put('/collection/{id}/edit/', 'App\Http\Controllers\CollectionController@update')->name('collection.update');
    Route::delete('/collection/{id}/delete/', 'App\Http\Controllers\CollectionController@destroy')->name('collection.delete');
    // end collection //

    // variant //
    Route::get('/variant/', 'App\Http\Controllers\VariantController@index')->name('variant.index');
    Route::get('/variant/create/', 'App\Http\Controllers\VariantController@create')->name('variant.create');
    Route::post('/variant/create/', 'App\Http\Controllers\VariantController@store')->name('variant.create');
    Route::get('/variant/{id}/edit/', 'App\Http\Controllers\VariantController@edit')->name('variant.edit');
    Route::put('/variant/{id}/edit/', 'App\Http\Controllers\VariantController@update')->name('variant.update');
    Route::delete('/variant/{id}/delete/', 'App\Http\Controllers\VariantController@destroy')->name('variant.delete');
    // end variant //

    // product //
    Route::get('/product/', 'App\Http\Controllers\ProductController@index')->name('product.index');
    Route::get('/product/create/', 'App\Http\Controllers\ProductController@create')->name('product.create');
    Route::post('/product/create/', 'App\Http\Controllers\ProductController@store')->name('product.create');
    Route::get('/product/{id}/edit/', 'App\Http\Controllers\ProductController@edit')->name('product.edit');
    Route::put('/product/{id}/edit/', 'App\Http\Controllers\ProductController@update')->name('product.update');
    Route::delete('/product/{id}/delete/', 'App\Http\Controllers\ProductController@destroy')->name('product.delete');
    // end product //

    // suppler //
    Route::get('/supplier/', 'App\Http\Controllers\SupplierController@index')->name('supplier.index');
    Route::get('/supplier/create/', function () {
        return view('supplier.create');
    });
    Route::post('/supplier/create/', 'App\Http\Controllers\SupplierController@store')->name('supplier.create');
    Route::get('/supplier/{id}/edit/', 'App\Http\Controllers\SupplierController@edit')->name('supplier.edit');
    Route::put('/supplier/{id}/edit/', 'App\Http\Controllers\SupplierController@update')->name('supplier.update');
    Route::delete('/supplier/{id}/delete/', 'App\Http\Controllers\SupplierController@destroy')->name('supplier.delete');
    // end supplier //

    // Income / Expense Heads //
    Route::get('/income-expense-heads/', 'App\Http\Controllers\IncomeExpenseHeadController@index')->name('income-expense-heads.index');
    Route::get('/income-expense-heads/create/', 'App\Http\Controllers\IncomeExpenseHeadController@create')->name('income-expense-heads.create');
    Route::post('/income-expense-heads/create/', 'App\Http\Controllers\IncomeExpenseHeadController@store')->name('income-expense-heads.save');
    Route::get('/income-expense-heads/edit/{id}/', 'App\Http\Controllers\IncomeExpenseHeadController@edit')->name('income-expense-heads.edit');
    Route::put('/income-expense-heads/edit/{id}/', 'App\Http\Controllers\IncomeExpenseHeadController@update')->name('income-expense-heads.update');
    Route::delete('/income-expense-heads/delete/{id}/', 'App\Http\Controllers\IncomeExpenseHeadController@destroy')->name('income-expense-heads.delete');
    // End Income / Expense Heads //

    // Expense //
    Route::get('/expense/', 'App\Http\Controllers\ExpenseController@index')->name('expense.index');
    Route::get('/expense/create/', 'App\Http\Controllers\ExpenseController@create')->name('expense.create');
    Route::post('/expense/create/', 'App\Http\Controllers\ExpenseController@store')->name('expense.save');
    Route::get('/expense/edit/{id}/', 'App\Http\Controllers\ExpenseController@edit')->name('expense.edit');
    Route::put('/expense/edit/{id}/', 'App\Http\Controllers\ExpenseController@update')->name('expense.update');
    Route::delete('/expense/delete/{id}/', 'App\Http\Controllers\ExpenseController@destroy')->name('expense.delete');
    // End Expenses //

    // Income //
    Route::get('/income/', 'App\Http\Controllers\IncomeController@index')->name('income.index');
    Route::get('/income/create/', 'App\Http\Controllers\IncomeController@create')->name('income.create');
    Route::post('/income/create/', 'App\Http\Controllers\IncomeController@store')->name('income.save');
    Route::get('/income/edit/{id}/', 'App\Http\Controllers\IncomeController@edit')->name('income.edit');
    Route::put('/income/edit/{id}/', 'App\Http\Controllers\IncomeController@update')->name('income.update');
    Route::delete('/income/delete/{id}/', 'App\Http\Controllers\IncomeController@destroy')->name('income.delete');
    // End Income //

    // Notepad //
    Route::get('/notepad/', 'App\Http\Controllers\NotepadController@index')->name('notepad.index');
    Route::get('/notepad/create/', 'App\Http\Controllers\NotepadController@create')->name('notepad.create');
    Route::post('/notepad/create/', 'App\Http\Controllers\NotepadController@store')->name('notepad.save');
    Route::get('/notepad/edit/{id}/', 'App\Http\Controllers\NotepadController@edit')->name('notepad.edit');
    Route::put('/notepad/edit/{id}/', 'App\Http\Controllers\NotepadController@update')->name('notepad.update');
    Route::delete('/notepad/delete/{id}/', 'App\Http\Controllers\NotepadController@destroy')->name('notepad.delete');
    // End Notepad //

    // purchase //
    Route::get('/purchase/', 'App\Http\Controllers\PurchaseController@index')->name('purchase.index');
    Route::get('/purchase/create/', 'App\Http\Controllers\PurchaseController@create')->name('purchase.create');
    Route::post('/purchase/create/', 'App\Http\Controllers\PurchaseController@store')->name('purchase.save');
    Route::get('/purchase/{id}/edit/', 'App\Http\Controllers\PurchaseController@edit')->name('purchase.edit');
    Route::put('/purchase/{id}/edit/', 'App\Http\Controllers\PurchaseController@update')->name('purchase.update');
    Route::delete('/purchase/{id}/delete/', 'App\Http\Controllers\PurchaseController@destroy')->name('purchase.delete');

    Route::get('/purchase/return/', 'App\Http\Controllers\PurchaseController@getPurchaseReturns')->name('purchase.return');
    Route::post('/purchase/return/', 'App\Http\Controllers\PurchaseController@fetch')->name('preturn.fetch');
    Route::put('/purchase/return/update/', 'App\Http\Controllers\PurchaseController@updatereturn')->name('purchase.updatereturn');
    // end purchase //

    // sales //
    Route::get('/sales/', 'App\Http\Controllers\SalesController@index')->name('sales.index');
    Route::get('/sales/create/', 'App\Http\Controllers\SalesController@create')->name('sales.create');
    Route::post('/sales/create/', 'App\Http\Controllers\SalesController@store')->name('sales.save');
    Route::get('/sales/return/{id}/', 'App\Http\Controllers\SalesController@return')->name('sales.return1');
    Route::put('/sales/return/{id}/', 'App\Http\Controllers\SalesController@returnupdate')->name('sales.returnupdate');
    Route::get('/sales/{id}/edit/', 'App\Http\Controllers\SalesController@edit')->name('sales.edit');
    Route::put('/sales/{id}/edit/', 'App\Http\Controllers\SalesController@update')->name('sales.update');
    Route::delete('/sales/{id}/delete/', 'App\Http\Controllers\SalesController@destroy')->name('sales.delete');

    Route::get('/sales/return/', 'App\Http\Controllers\SalesController@getSalesReturns')->name('sales.return');
    Route::post('/sales/return/', 'App\Http\Controllers\SalesController@fetch')->name('sreturn.fetch');
    Route::put('/sales/return/update/', 'App\Http\Controllers\SalesController@updatereturn')->name('sales.updatereturn');

    Route::get('/sales/deadstock/', 'App\Http\Controllers\SalesController@deadstock')->name('sales.deadstock');    

    // end sales //

    // reports //
    Route::get('/reports/purchase/', 'App\Http\Controllers\ReportsController@showPurchase')->name('reports.purchase');
    Route::post('/reports/purchase/', 'App\Http\Controllers\ReportsController@getPurchase')->name('reports.purchase');
    Route::get('/reports/purchase-return/', 'App\Http\Controllers\ReportsController@showPurchaseReturn')->name('reports.purchase-return');
    Route::post('/reports/purchase-return/', 'App\Http\Controllers\ReportsController@getPurchaseReturn')->name('reports.purchase-return');
    Route::get('/reports/sales/', 'App\Http\Controllers\ReportsController@showSales')->name('reports.sales');
    Route::post('/reports/sales/', 'App\Http\Controllers\ReportsController@getSales')->name('reports.sales');
    Route::get('/reports/sales-return/', 'App\Http\Controllers\ReportsController@showSalesReturn')->name('reports.sales-return');
    Route::post('/reports/sales-return/', 'App\Http\Controllers\ReportsController@getSalesReturn')->name('reports.sales-return');
    Route::get('/reports/expense/', 'App\Http\Controllers\ReportsController@showExpense')->name('reports.expense');
    Route::post('/reports/expense/', 'App\Http\Controllers\ReportsController@getExpense')->name('reports.expense');
    Route::get('/reports/income/', 'App\Http\Controllers\ReportsController@showIncome')->name('reports.income');
    Route::post('/reports/income/', 'App\Http\Controllers\ReportsController@getIncome')->name('reports.income');
    Route::get('/reports/pandl/', 'App\Http\Controllers\ReportsController@showPandL')->name('reports.pandl');
    Route::post('/reports/pandl/', 'App\Http\Controllers\ReportsController@getPandL')->name('reports.pandl');
    Route::get('/reports/stockin/', 'App\Http\Controllers\ReportsController@showStockIn')->name('reports.stockin');
    Route::post('/reports/stockin/', 'App\Http\Controllers\ReportsController@getStockIn')->name('reports.stockin');
    Route::get('/reports/stockout/', 'App\Http\Controllers\ReportsController@showStockOut')->name('reports.stockout');
    Route::post('/reports/stockout/', 'App\Http\Controllers\ReportsController@getStockOut')->name('reports.stockout');
    Route::get('/reports/stockinhand/', 'App\Http\Controllers\ReportsController@getStockInHand')->name('reports.stockinhand');
    Route::get('/reports/stockinhandc/', 'App\Http\Controllers\ReportsController@getStockInHandCollection')->name('reports.stockinhandc');
    Route::get('/reports/consolidated/', 'App\Http\Controllers\ReportsController@showConsolidated')->name('reports.consolidated');
    Route::post('/reports/consolidated/', 'App\Http\Controllers\ReportsController@getConsolidated')->name('reports.consolidated');
    Route::get('/reports/daybook/', 'App\Http\Controllers\ReportsController@dayBook')->name('reports.daybook');
    // end reports //

    // search //
    Route::get('/search/purchase/', 'App\Http\Controllers\SearchController@showPurchase')->name('search.purchase');
    Route::post('/search/purchase/', 'App\Http\Controllers\SearchController@getPurchase')->name('search.purchase');
    Route::get('/search/sales/', 'App\Http\Controllers\SearchController@showSales')->name('search.sales');
    Route::post('/search/sales/', 'App\Http\Controllers\SearchController@getSales')->name('search.sales');
    Route::get('/search/stock-status/', 'App\Http\Controllers\SearchController@showStockStatus')->name('search.status');
    Route::post('/search/stock-status/', 'App\Http\Controllers\SearchController@getStockStatus')->name('search.status');
    // end search //

    // settings //
    Route::get('/settings/vat/', 'App\Http\Controllers\SettingsController@getvat')->name('settings.vat');
    Route::post('/settings/vat/{id}', 'App\Http\Controllers\SettingsController@updatevat')->name('vat.update');
    Route::get('/settings/cardfee/', 'App\Http\Controllers\SettingsController@getcardfee')->name('settings.cardfee');
    Route::post('/settings/cardfee/{id}', 'App\Http\Controllers\SettingsController@updatecardfee')->name('cardfee.update');
    // end settings //

    // helper //
    Route::get('/helper/product/', 'App\Http\Controllers\HelperController@getproducts');
    Route::get('/helper/product/{id}', 'App\Http\Controllers\HelperController@getproduct');
    Route::get('/helper/product/{id}/{qty}/{dval}/{stype}', 'App\Http\Controllers\HelperController@checkStockInHand');
    //Route::get('/product/barcode/{id}/', [HelperController::class, 'barcode'])->name('barcode.html');
    // end helper //

    // pdf //
    Route::get('/sales-invoice/{id}/', [PDFController::class, 'salesinvoice']);
    Route::get('/purchase-invoice/{id}/', [PDFController::class, 'purchaseinvoice']);
    Route::get('/product/download/pdf/', [PDFController::class, 'products']);
    Route::get('/product/download/barcodes/', [PDFController::class, 'barcodes']);
    Route::post('/purchase/download/pdf/', [PDFController::class, 'purchase'])->name('purchase.pdf');
    Route::post('/purchase-return/download/pdf/', [PDFController::class, 'purchasereturn'])->name('purchase-return.pdf');
    Route::post('/sales/download/pdf/', [PDFController::class, 'sales'])->name('sales.pdf');
    Route::post('/sales-return/download/pdf/', [PDFController::class, 'salesreturn'])->name('sales-return.pdf');
    Route::post('/expense/download/pdf/', [PDFController::class, 'expense'])->name('expense.pdf');
    Route::post('/pandl/download/pdf/', [PDFController::class, 'pandl'])->name('pandl.pdf');
    Route::get('/product/barcode/{id}/', [PDFController::class, 'barcode'])->name('barcode.pdf');
    // end pdf //

    // excel //
    Route::get('/product/download/excel/', [ExcelController::class, 'productExport'])->name('product-export');
    Route::post('/purchase/download/excel/', [ExcelController::class, 'purchaseExport'])->name('purchase-export');
    Route::post('/purchase-return/download/excel/', [ExcelController::class, 'purchaseReturnExport'])->name('purchase-return-export');
    Route::post('/sales/download/excel/', [ExcelController::class, 'salesExport'])->name('sales-export');
    Route::post('/sales-return/download/excel/', [ExcelController::class, 'salesReturnExport'])->name('sales-return-export');
    Route::post('/expense/download/excel/', [ExcelController::class, 'expenseExport'])->name('expense-export');
    // end excel //

    Route::get('/updatesku/', [HelperController::class, 'updateSKU']);

});
