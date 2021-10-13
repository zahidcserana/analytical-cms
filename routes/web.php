<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'welcome']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::group(['middleware' => 'auth'], function () {
Route::resource('customers', CustomerController::class);
Route::resource('invoices', InvoiceController::class);
Route::post('invoice-item/{invoice}', [InvoiceController::class, 'addItem']);
Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'createPDF'])->name('invoices.pdf');
Route::get('invoices/{invoice}/preview', [InvoiceController::class, 'preview'])->name('invoices.preview');
Route::post('invoice-item-delete/{invoice}', [InvoiceController::class, 'deleteItem']);
Route::get('reports/invoices', [ReportController::class, 'invoices'])->name('reports.invoices');
Route::get('reports/customers', [ReportController::class, 'customers'])->name('reports.customers');
});
