@extends('layouts.admin')

@section('title', __('Products'))

@section('content')
    <products-admin 
        :products="{{ json_encode(ProductResource::collection($products->getCollection())) }}">
    </products-admin>

    {{ $products->appends(Request::all())->links('pagination::bootstrap-4') }}
@endsection