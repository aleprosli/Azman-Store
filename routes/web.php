<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/purchase/{item}', [App\Http\Controllers\User\PurchaseController::class, 'store'])->name('purchase-store');

Route::get('return-url', function(Request $request){
    $purchase = App\Models\Purchase::where('toyyibpay_bill_code',$request->billcode)->first();
    if($purchase){ 
        if($purchase->uuid.$purchase->id == $request->order_id){
            $purchase->update(['payment_status'=>1]);

            return "Thank you, Arigatao";
        }
        return'try again. Please click here'.$purchase->payment_link;
       
    }
    else
    {
        return 'Please check your response';
    }
});

Route::get('callback-url', function(Request $request){
    \info(['from payment gateway' => $request->all()]);
    $purchase = App\Models\Purchase::where('toyyibpay_bill_code',$request->billcode)->first();
    if($purchase){
        if($purchase->uuid == $request->order_id){
            $purchase->update(['payment_status'=>1]);

            \info(['success' => 'update order success']);
        }

        \info(['failed' => 'respond is not valid']);
    }
    else
    {
        \info(['failed' => 'failed']);
    }
});
