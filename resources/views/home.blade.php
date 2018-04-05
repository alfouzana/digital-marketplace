@extends('layouts.app')

@section('title', __('Home'))

@section('content')
    <div class="card">
        <div class="card-header">
            @lang('Latest Products')
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($latestProducts as $product)
                    <div class="col-md-6 col-xl-4">
                        @include('products._preview')
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection