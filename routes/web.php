<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChargeInvoiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DailyReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkOrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::group(['middleware' => ['guest', 'auth']], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
    // Portal Admin
    Route::group(['prefix' => 'portal', 'middleware' => ['auth']], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('generate_workorder_view={id}', [DashboardController::class, 'generate_workorder_view'])->name('dashboard.workorder.view');
        });
        Route::get('/user', [UserController::class, 'index'])->name('user');
        Route::group(['prefix' => 'user'], function () {
            Route::get('create', [UserController::class, 'create'])->name('user.create');
            Route::post('store', [UserController::class, 'store'])->name('user.store');
            Route::get('edit={id}', [UserController::class, 'edit'])->name('user.edit');
            Route::post('modify={id}', [UserController::class, 'modify'])->name('user.modify');
        });
        Route::get('/status', [StatusController::class, 'index'])->name('status');
        Route::group(['prefix' => 'status'], function () {
            Route::post('store', [StatusController::class, 'store'])->name('status.store');
            Route::get('edit={id}', [StatusController::class, 'edit'])->name('status.edit');
            Route::post('status={id}', [StatusController::class, 'modify'])->name('status.modify');
        });
        Route::get('/customer', [CustomerController::class, 'index'])->name('customer');
        Route::group(['prefix' => 'customer'], function () {
            Route::get('create', [CustomerController::class, 'create'])->name('customer.create');
            Route::post('store', [CustomerController::class, 'store'])->name('customer.store');
            Route::get('edit={id}', [CustomerController::class, 'edit'])->name('customer.edit');
            Route::post('modify={id}', [CustomerController::class, 'modify'])->name('customer.modify');
        });
        Route::get('/workorder', [WorkOrderController::class, 'index'])->name('workorder');
        Route::group(['prefix' => 'workorder'], function () {
            Route::get('autocomplete', [WorkOrderController::class, 'autocomplete'])->name('workorder.autocomplete');
            Route::post('store', [WorkOrderController::class, 'store'])->name('workorder.store');
            Route::get('edit={id}', [WorkOrderController::class, 'edit'])->name('workorder.edit');
            Route::post('modify={id}', [WorkOrderController::class, 'modify'])->name('workorder.modify');
            Route::get('status={id}', [WorkOrderController::class, 'status'])->name('workorder.status');
            Route::post('confirm={id}', [WorkOrderController::class, 'confirmation'])->name('workorder.confirmation');
            Route::get('balance={id}', [PaymentsController::class, 'balance_payment'])->name('payments.balance');
            Route::post('pay', [PaymentsController::class, 'pay'])->name('payments.pay');
        });
        Route::get('/chargeinvoice', [ChargeInvoiceController::class, 'index'])->name('chargeinvoice');
        Route::group(['prefix' => 'chargeinvoice'], function () {
            Route::get('chargeinvoiceadd', [ChargeInvoiceController::class, 'add'])->name('chargeinvoice.add');
            Route::post('register', [ChargeInvoiceController::class, 'register'])->name('chargeinvoice.register');
            Route::get('autocomplete', [ChargeInvoiceController::class, 'autocomplete'])->name('chargeinvoice.autocomplete');
            Route::get('/preview={id}', [ChargeInvoiceController::class, 'preview'])->name('chargeinvoice.preview');
        });
        Route::get('/dailyreport', [DailyReportController::class, 'index'])->name('dailyreport');
        Route::get('/soa={id}', [DailyReportController::class, 'generate_soa'])->name('dailyreport.soa.generate');
        Route::get('/preview={id}', [DailyReportController::class, 'preview'])->name('preview');
        Route::group(['prefix' => 'dailyreport'], function () {
            Route::get('search_workorder', [DailyReportController::class, 'index'])->name('dailyreport.workorder.search');
            Route::get('search_receivable', [DailyReportController::class, 'index'])->name('dailyreport.receivable.search');
            Route::get('view_receivable={id}', [DailyReportController::class, 'receivable_view'])->name('dailyreport.receivable.view');
            Route::get('generate_workorder_claimed={id}', [DailyReportController::class, 'generate_workorder_claimed'])->name('dailyreport.workorder.generate');
        });
        Route::get('/salesreport', [SalesReportController::class, 'index'])->name('salesreport');
    });
});
