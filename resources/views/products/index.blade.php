@extends('layouts.app')

@section('title', __('Products'))

@section('content')
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-6 col-xl-4">
                @include('products._product-preview')
            </div>
        @endforeach
    </div>

    {{ $products->links('pagination::bootstrap-4') }}
@endsection