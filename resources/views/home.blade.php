@extends('layouts.app')

@section('content')
<div class="container">
    
        <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">{{ __('Dashboard') }}</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            {{ __('You are logged in!') }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">{{ __('Item') }}</div>

                        <div class="card-body">
                            <table class ="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $items as $item )
                                    <tr>
                                        <td>{{ $item -> name }}</td>
                                        <td>{{ $item -> description }}</td>
                                        <td>{{ $item -> type }}</td>
                                        <td>{{ $item -> Amount }}</td>
                                        <td><a href="{{ route('purchase-store',$item) }}" class="btn-btn-success">Purchase</a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('My Purchase') }}</div>
                        <table class ="table">
                            <thead>
                                <tr>
                                    <th>Price</th>
                                    <th>Payment Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $purchases as $purchase )
                                <tr>
                                    <td>{{ $purchase -> real_price }}</td>
                                    <td>{{ $purchase -> payment_status }}</td>
                                    <td><a href="{{ $purchase->payment_link }}" class="btn-btn-success">Bayar Sekarang</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    <passport-token></passport-token>
</div>
@endsection
