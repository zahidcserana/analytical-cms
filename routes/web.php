<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/clear', [HomeController::class, 'clear']);
Route::get('/heroku', [HomeController::class, 'heroku']);


require __DIR__ . '/auth.php';

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::prefix('data')->name('data.')->group(function () {
        Route::get('download', [DataController::class, 'download'])->name('download');
        Route::get('email', [DataController::class, 'email'])->name('email');
        Route::get('backup', [DataController::class, 'backup'])->name('backup');
    });

    Route::resource('suppliers', SupplierController::class);

    Route::resource('purchases', PurchaseController::class);
    Route::resource('expenses', ExpenseController::class);

    Route::get('customers/ajax-search', [CustomerController::class, 'customerSearch']);
    Route::resource('customers', CustomerController::class);
    Route::get('customers/{customer}/invoices', [CustomerController::class, 'invoices'])->name('customers.invoices');
    Route::get('customers/{customer}/details', [CustomerController::class, 'details'])->name('customers.details');
    Route::get('customers/ajax-search-by-id/{customer}', [CustomerController::class, 'customerSearchById']);

    Route::resource('invoices', InvoiceController::class);
    Route::post('invoice-item/{invoice}', [InvoiceController::class, 'addItem']);
    Route::get('invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');
    Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'pdf'])->name('invoices.pdf');
    Route::get('invoices/{invoice}/preview', [InvoiceController::class, 'preview'])->name('invoices.preview');
    Route::get('invoices/{invoice}/emailing', [InvoiceController::class, 'emailing'])->name('invoices.emailing');
    Route::post('invoice-item-delete/{invoice}', [InvoiceController::class, 'deleteItem']);

    Route::resource('payments', PaymentController::class);
    Route::get('payments/{payment}/adjust', [PaymentController::class, 'adjust'])->name('payments.adjust');
    Route::post('payments/{payment}/adjust', [PaymentController::class, 'applied'])->name('payments.adjust');
    Route::get('payments/{payment}/preview', [PaymentController::class, 'preview'])->name('payments.preview');
    Route::get('payments/{payment}/print', [PaymentController::class, 'print'])->name('payments.print');

    Route::get('reports/invoices', [ReportController::class, 'invoices'])->name('reports.invoices');
    Route::get('reports/customers/{print?}', [ReportController::class, 'customers'])->name('reports.customers');
    Route::get('reports/payments/{print?}', [ReportController::class, 'payments'])->name('reports.payments');
});
