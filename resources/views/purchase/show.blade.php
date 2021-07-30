@extends('layouts.app')

@section('content')
<div class="container">
    
        <div class="row justify-content-center">
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">{{ __('Purchase') }}</div>

                        <div class="card-body">
                            <h1>Purchase:{{ $purchase->uuid }}</h1>
                            <a href="{{ $purchase->payment_link }}" class="btn-btn-success">Pay Using Normal Window</a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('purchase-payBanks', $purchase) }}" >
                            <select name="banks">
                                @foreach ($fpx_banks as $bank)
                                <option value="{{ $bank->CODE }}">{{ $bank->NAME }}</option>
                                @endforeach
                            </select>
                            <button type="submit">Terus ke bank</button>
                            </form>
                        </div>
                    </div>
                </div>

        </div>
    <passport-token></passport-token>
</div>
@endsection
