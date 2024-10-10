<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AreaChartController;
use App\Http\Controllers\Customers_Report;
use App\Http\Controllers\InvoiceArchiveController;
use App\Http\Controllers\Invoices_Report;
use App\Http\Controllers\InvoicesAttachmentsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/logout',[UserController::class,'logout']);
Route::get('invoices',[InvoicesController::class,'index']);
Route::get('/sections',[SectionsController::class,'index']);
Route::get('/products',[ProductsController::class,'index']);
Route::get('/Archive_invoices',[InvoiceArchiveController::class,'index']);
    
Route::post('/sections', [SectionsController::class, 'store'])->name('sections.store');
Route::post('/products', [ProductsController::class, 'store'])->name('products.store');
Route::post('/invoices', [InvoicesController::class, 'store'])->name('invoices.store');
Route::get('/InvoicesAttachments', [InvoicesAttachmentsController::class, 'store']);

Route::delete('/sections', [SectionsController::class, 'destroy'])->name('sections.destroy');
Route::delete('/products', [ProductsController::class, 'destroy'])->name('products.destroy');
Route::delete('/invoices', [InvoicesController::class, 'destroy'])->name('invoices.destroy');
Route::delete('/details', [InvoicesdetailsController::class, 'destroy'])->name('delete_file');
Route::delete('/Archive_invoices',[InvoiceArchiveController::class,'destroy'])->name('Archive_invoices.destroy');


Route::patch('/sections', [SectionsController::class, 'update'])->name('sections.update');
Route::patch('/products', [ProductsController::class, 'update'])->name('products.update');
Route::get('/invoices/Status_Update/{id}', [InvoicesController::class, 'Status_Update'])->name('Status_Update');
Route::patch('/Archive_invoices',[InvoiceArchiveController::class,'update'])->name('Archive_invoices.update');

Route::get('/invoices/update', [InvoicesController::class, 'update']);

Route::get('/invoices/create', [InvoicesController::class, 'create'])->name('invoices.create');
Route::get('/download/{invoice_number}/{file_name}',[InvoicesDetailsController::class,'download']);
Route::get('/show/{invoice_number}/{file_name}',[InvoicesDetailsController::class,'show']);
Route::get('Status_show/{id}',[InvoicesController::class,'show']);
Route::get('/section/{id}',[InvoicesController::class,'getproductes']);
Route::get('/InvoicesDetails/{id}',[InvoicesDetailsController::class,'edit']);
Route::get('/edit_invoice/{id}',[InvoicesController::class,'edit']);
Route::get('/invoices_paid',[InvoicesController::class,'invoices_paid']);
Route::get('/invoices_unpaid',[InvoicesController::class,'invoices_unpaid']);
Route::get('/invoices_partial',[InvoicesController::class,'invoices_partial']);
Route::get('/Print_invoice/{id}',[InvoicesController::class,'Print_invoice']);
Route::get('/export_invoices',[InvoicesController::class,'export_invoices']);

Route::group(['middleware' => ['auth']], function() {

    Route::resource('/roles',RoleController::class);
    
    Route::resource('/users',UserController::class);
});
Route::get('/invoices_report',[Invoices_Report::class,'index']);
Route::post('/Search_invoice',[Invoices_Report::class,'Search_invoice'])->name('Search_invoice');

Route::get('/customers_report',[Customers_Report::class,'index']);
Route::post('/Search_customers',[Customers_Report::class,'Search_customers'])->name('Search_customers');


Route::get('/MarkAsRead_all',[InvoicesController::class,'MarkAsRead_all'])->name('MarkAsRead_all');

Route::get('/{id}', [AdminController::class,'index']);

