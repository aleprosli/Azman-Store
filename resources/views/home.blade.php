@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
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
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Item') }}</div>

                <div class="card-body">
                    <table class ="table">
                        <thead>
                            <tr>
                                <th></th>
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
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('My Purchase') }}</div>

                <div class="card-body">
                    <table class ="table">
                        <thead>
                            <tr>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $purchases as $purchase )
                            <tr>
                                <td>{{ $purchase -> real_price }}</td>
                                <td>{{ $purchase -> payment_status }}</td>
                                <td>{{ $purchase -> price }}</td>
                                <td><a href="{{ $purchase->payment_link }}" class="btn-btn-success">Bayar Sekarang</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                </div>
            </div>
        </div>
    </div>
    <passport-token></passport-token>
</div>
@endsection
