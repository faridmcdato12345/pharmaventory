<?php

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
    return view('auth.login');
});
Auth::routes();
Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
});
Route::group(['middleware' => ['auth','isAdmin']], function () {
    Route::get('/dashboard','DashboardController@index')->name('dashboard.index');
    Route::get('/admin/users','AdminUserController@index')->name('user.index');
    Route::get('/admin/users/create','AdminUserController@create')->name('user.create');
    Route::post('/admin/users/','AdminUserController@store')->name('user.store');
    Route::get('/admin/products','ProductController@index')->name('product.index');
    Route::get('/admin/products/create','ProductController@create')->name('product.create');

    Route::get('/products','ProductController@index')->name('product.index');
    Route::post('/products','ProductController@store')->name('product.store');
    Route::get('/products/{product}','ProductController@show')->name('product.show');
    Route::patch('/products/{product}','ProductController@update')->name('product.update');
    Route::delete('/products/{product}', 'ProductController@destroy')->name('product.delete');

    Route::get('/admin/product/attribute/types','TypeController@index')->name('types.index');
    Route::get('/admin/product/attribute/types/create','TypeController@create')->name('types.create');
    Route::post('/admin/product/attribute/types','TypeController@store')->name('types.store');
    Route::patch('/admin/product/attribute/types/{type}','TypeController@update')->name('types.update');
    Route::delete('/admin/product/attribute/types/{type}','TypeController@destroy')->name('types.delete');

    Route::get('/classification/{classification}','ClassificationController@show')->name('product.classification.show');
    Route::post('/classification','ClassificationController@store')->name('product.classification.store');
    Route::patch('/classification/{classification}','ClassificationController@update')->name('product.classification.update');
    Route::delete('/classification/{classification}','ClassificationController@destroy')->name('product.classification.delete');

    Route::post('/unit','UnitController@store');
    Route::patch('/unit/{unit}','UnitController@update');
    Route::delete('/unit/{unit}','UnitController@destroy');

    Route::resource('/invoice','InvoiceController');

    Route::resource('/admin/product/attribute/brands', 'BrandController');
    Route::resource('/admin/product/attribute/categories', 'CategoryController');
    Route::resource('/admin/product/attribute/packagings', 'PackagingController');
    Route::resource('/admin/product/attribute/potencies', 'PotencyController');

    Route::get('/admin/product/attribute/all/types','ProductController@getAllTypes')->name('get.all.types');
    Route::get('/admin/product/attribute/all/brands','ProductController@getAllBrands')->name('get.all.brands');
    Route::get('/admin/product/attribute/all/potencies','ProductController@getAllPotencies')->name('get.all.potencies');
    Route::get('/admin/product/attribute/all/packagings','ProductController@getAllPackagings')->name('get.all.packagings');
    Route::get('/admin/product/attribute/all/categories','ProductController@getAllCategories')->name('get.all.categories');

    Route::get('/admin/report/inventory_report','ReportController@inventoryReport')->name('inventory.report');
    Route::post('/admin/report/inventory_report/','ReportController@expireSpecificDate')->name('get.expiration.by.day');
    Route::get('/admin/report/inventory_report/next_six_month','ReportController@reportForNextSixMonths')->name('next.six.months');
    Route::get('/admin/report/inventory_report/out_of_stocks','ReportController@outOfStocks')->name('out.of.stocks');
    Route::get('/admin/report/inventory_report/stock_count_and_value/','ReportController@stockCount')->name('stock.count');
    Route::get('/admin/report/inventory_report/{day}','ReportController@goToResultDays')->name('go.to.result.days');
    
    Route::post('/admin/report/inventory_report/quantity','ReportController@quantityCheck')->name('get.low.stock.value');
    Route::get('/admin/report/inventory_report/quantity/{quantity}','ReportController@goToResultQuantity')->name('go.to.result.quantity');   
    Route::get('/admin/point_of_sale','HomeController@adminPos')->name('admin.pos');
    Route::get('/admin/point_of_sale/new','HomeController@adminNewPos')->name('admin.new.pos');
    Route::post('/admin/storage/{id}', [
        'uses' => 'StorageController@delete',
        'as'   => 'storage.delete',
    ]);
    Route::resource('/admin/storage','StorageController');

    Route::get('/live_search/action','ProductController@liveSearchProduct')->name('live.search.product');
    Route::get('/product/get','ProductController@addToInvoiceSideCard')->name('get.product');
    Route::get('/product/get/edit','ProductController@edit')->name('edit.product');
    Route::patch('/product/update/{id}','ProductController@update')->name('update.product');
    Route::get('/report/sales','ReportController@sales')->name('sales.report');
    Route::post('/report/sales/date','ReportController@salesDate')->name('show.date.sales');
    Route::get('/user/log','UserLogController@index')->name('user.log.index');
    Route::get('/product/import','ImportController@index')->name('import.product');
    Route::post('/product/import','ImportController@store')->name('product.import.store');
    Route::post('/report/sales/print','ReportController@showSales')->name('show.printable.sales');
    Route::resource('/admin/business','BusinessController');
    Route::get('/admin/printable/invoice/{invoice}','InvoiceController@showSpecificInvoice')->name('print.invoice');
    Route::get('/admin/invoices/{id}','InvoiceController@showInvoice')->name('invoice.show');
    Route::get('/admin/invoices/','InvoiceController@allInvoice')->name('invoice.all');
    Route::get('/admin/printable/report/out_of_stock/','ReportController@outOfStockPrint')->name('print.out_of_stock');
    Route::post('user/setting/','AdminUserController@changePass')->name('change.password');
    Route::post('/return/product','InvoiceController@returnProduct')->name('return.product');
    Route::get('/admin/primtable/report/stock_count','ReportController@stockCountPrint')->name('print.stok_count');
    Route::get('/admin/print/report/quantity/{quantity}','ReportController@quantityCheckReport')->name('low.quantity.print');
    Route::get('/admin/print/report/next_six_month','ReportController@printReportForNextSixMonths')->name('next.six.months.print');
    Route::patch('admin/users/{id}/in_active/','AdminUserController@inActive')->name('user.inactive');
    Route::patch('admin/users/{id}/is_active/','AdminUserController@isActive')->name('user.active');
    

});

