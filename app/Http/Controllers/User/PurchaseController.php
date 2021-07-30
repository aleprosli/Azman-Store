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
        $purchase = Purchase::create([
            'user_id' => auth()->user()->id,
            'item_id' => $item->id,
            'price' => $item->amount,
        ]);

        $url = 'https://dev.toyyibpay.com/index.php/api/createBill';

        $body =[
            'userSecretKey' => 'vhom6diw-637f-ihtz-hj1r-aiy9eegnvoug',
            'categoryCode' => 'k8sqmgm2',
            'billName' => $item->name,
            'billDescription' => $item->description,
            'billAmount' => $purchase->price,
            // 'billReturnUrl'=>'http://api-training.test/return-url/',
            // 'billCallbackUrl'=>'http://api-training.test/callback-url/',
            'billExternalReferenceNo' => $purchase->id,
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
