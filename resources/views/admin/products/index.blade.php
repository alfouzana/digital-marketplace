@extends('layouts.admin')

@section('title', __('Products'))

@section('content')
    <table class="table table-hover">
        <thead>
            <tr>
                <th>{{ __('Title') }}</th>
                <th>{{ __('Category') }}</th>
                <th>{{ __('Approval Status') }}</th>
                <th>{{ __('Created At') }}</th>
                <th>{{ __('Updated At') }} <i class="fa fa-caret-down"></i></th>
                <th>{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr class="table-{{ $product->approval_context }}">
                    <td>{{ $product->title }}</td>
                    <td>
                        <span class="badge badge-info">
                            {{ $product->category->name }}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-{{ $product->approval_context }}">
                            {{ $product->approval_status }}
                        </span>
                    </td>
                    <td>{{ $product->created_at }}</td>
                    <td>{{ $product->updated_at }}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $products->appends(request()->all())->links('pagination::bootstrap-4') }}
@endsection