@extends('layouts.customer')

@section('title', __('Purchases'))

@section('content')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Product</th>
                <th>Time <i class="fa fa-caret-down"></i></th>
                <th>Amount</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchases as $purchase)
                <tr>
                    <td>
                        <a href="{{ $purchase->product->url() }}">
                            {{ $purchase->product->isApproved() ?
                                $purchase->product->title:
                                __('The product\'s been disapproved by the administrator.')
                             }}
                        </a>
                    </td>
                    <td>{{ $purchase->created_at }}</td>
                    <td>{{ $purchase->amount }}</td>
                    <td>
                        <a href="{{ url('product/'.$purchase->product->getRouteKey().'/file') }}"
                           class="btn btn-sm btn-success" title="@lang('Download')">
                            <i class="fa fa-download"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $purchases->links() }}
@endsection