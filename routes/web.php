<?php

use App\Helpers\Whatsapp;
use App\Models\LogNotifikasi;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
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
    // return DB::table('users')->get();
    return redirect('admin/login');
});

Route::middleware(['\crocodicstudio\crudbooster\middlewares\CBBackend'])->group(function () {
    Route::any('/transaksis/print/{id}', 'AdminTransaksisController@print');
    Route::any('/transaksis/ubah-harga/{id}/{nilai}', 'AdminLaporanController@UbahHarga');    
    Route::any('/transaksis/ubah-status/{id}/{status}', 'AdminLaporanController@UbahStatus');

    Route::any('/transaksis-all/ubah-harga/{id}/{nilai}', 'AdminLaporanTransaksiController@UbahHarga');    
    Route::any('/transaksis-all/ubah-status/{id}/{status}', 'AdminLaporanTransaksiController@UbahStatus');


    Route::any('/admin/order/save', 'AdminOrdersController@save');
    Route::any('/admin/orders/cancel/{id}', 'AdminOrdersController@cancelOrder');
    Route::any('/admin/order/saveitem', 'AdminOrdersController@saveitem');
    Route::post('/admin/order/approve', 'AdminTransaksisController@approveOrder');
    Route::post('/admin/order/reject', 'AdminTransaksisController@rejectOrder');
    Route::post('/admin/order/confirm', 'AdminTransaksisController@confirmOrder');
    Route::post('/admin/order/finish', 'AdminTransaksisController@finishOrder');
    Route::post('/admin/order/cancel', 'AdminTransaksisController@cancelOrder');

    Route::get('/admin/dashboard', 'AdminInfosController@dashboard');
    // Route::any('/admin/laporan/harian', 'AdminLaporanController@laporan');
    Route::any('/admin/laporan/harian/export/{prdawal}/{prdakhir}/{status}/{layanan}', 'AdminLaporanController@export');
    Route::any('/admin/laporan/transaksi', 'AdminDataTransaksiController@laporan');
    Route::any('/admin/laporan/transaksi/export/{prdawal}/{prdakhir}/{status}/{layanan}', 'AdminDataTransaksiController@export');
});


Route::get('/test', function () {
    $trx = Transaksi::firstWhere('trxid', '10915/PBM/WOWS/05-04/2023');
    $trx->sendNotifPembelian();
    return $trx;
    return LogNotifikasi::create([
        'phone' => '085231028718',
        'message' => 'Test',
    ]);
});