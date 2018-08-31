@extends('layouts.app')

@section('title', !Request::has('archived') ? __('My Products') : __('Archived Products'))

@section('content')
    <div>
        @if(!Request::has('archived'))
            <a href="{{ url('/vendor/products?archived=1') }}"
               class="btn btn-outline-secondary float-right mb-3"
               title="@lang('Archived Products')">
                <i class="fa fa-archive"></i>
            </a>
        @else
            <a href="{{ url('/vendor/products') }}"
               class="btn btn-outline-primary float-right mb-3"
               title="@lang('Current Products')">
                <i class="fa fa-arrow-left"></i>
            </a>
        @endif
    </div>
    @if($products->isEmpty())
        <div class="alert alert-info" role="alert">
            @lang('You have not added any products yet.')
            {{-- TODO: Add the 'new product' url --}}
            <a href="#">@lang('Add your first product here.')</a>
        </div>
    @else
        <div class="table-responsive-lg">
            <table class="table table-hover">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">@lang('Title')</th>
                        <th scope="col">@lang('Category')</th>
                        <th scope="col">@lang('Last Change')</th>
                        <th scope="col">@lang('Creation')</th>
                        <th scope="col">@lang('Approval Status')</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr class="table-{{ $product->approval_context() }}">
                        <td>{{ $product->title }}</td>
                        <td>
                            <span class="badge badge-info">
                                {{ $product->category->name }}
                            </span>
                        </td>
                        <td>{{ $product->updated_at }}</td>
                        <td>{{ $product->created_at }}</td>
                        <td>
                            <span class="badge badge-{{ $product->approval_context() }}">
                                {{ $product->approval_status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ $product->url() }}" title="@lang('View')"
                               class="btn btn-sm btn-light{{! $product->showable ? ' disabled' : ''}}"
                               @if(! $product->showable) onclick="event.preventDefault()" tabindex="-1" aria-disabled="true" @endif>
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="#" title="@lang('Edit')" class="btn btn-sm btn-light">
                                <i class="fa fa-edit"></i>
                            </a>
                            @if(!$product->trashed())
                                <a href="#" class="btn btn-sm btn-light"
                                   title="@lang('Archive')"
                                   role="button">
                                    <i class="fa fa-archive"></i>
                                </a>
                            @else
                                <a href="#" class="btn btn-sm btn-light"
                                   title="@lang('Restore')"
                                   role="button">
                                    <i class="fa fa-recycle"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $products->appends(Request::only(['archived']))->links('pagination::bootstrap-4') }}
    @endif
@endsection
