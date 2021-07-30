<?php

namespace App\Http\Controllers\User;

use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Item $item)
    {
        $toyyibpay_secret_key = config('services.toyyibpay.secret');

        $purchase = Purchase::create([
            'user_id' => auth()->user()->id,
            'item_id' => $item->id,
            'price' => $item->amount,
        ]);

        $url = 'https://dev.toyyibpay.com/index.php/api/createBill';

        $body =[
            'userSecretKey' => $toyyibpay_secret_key,
            'categoryCode' => 'k8sqmgm2',
            'billName' => $item->name,
            'billDescription' => $item->description,
            'billAmount' => $purchase->price,
            'billReturnUrl'=>URL('/return-url'),
            'billCallbackUrl'=>'http://azman-store.test/callback-url/',
            'billExternalReferenceNo' => $purchase->uuid.$purchase->id,
            'billTo'=>auth()->user()->name,
            'billEmail'=>auth()->user()->email,
            'billPriceSetting'=>1,
            'billContentEmail'=>'Thank you for purchasing our product!',
            'billChargeToCustomer'=>1
        ];

        $response = Http::asForm()->post($url, $body);

        $bill_code = $response->object()['0']->BillCode;

        $purchase->update(['toyyibpay_bill_code' => $bill_code]);

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        $response = Http::get('https://dev.toyyibpay.com/index.php/api/getBankFPX');

        $fpx_banks = $response->object();
        return view('purchase.show',compact('purchase','fpx_banks'));
    }

    public function payBanks(Request $request, Purchase $purchase)
    {
        $toyyibpay_secret_key = config('services.toyyibpay.secret');

        $response = Http::asForm()->post('https://dev.toyyibpay.com/index.php/api/runBill',[
            'userSecretKey' => $toyyibpay_secret_key,
            'billCode' => $purchase->toyyibpay_bill_code,
            'billBankID' =>$request->banks,
        ]);

        echo($response);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
