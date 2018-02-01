@extends('layouts.app')

@section('title', __('My Products'))

@section('content')
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
                                {{ $product->approval_lang }}
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
                            <a href="#" title="@lang('Archive')" class="btn btn-sm btn-light"
                               role="button">
                                <i class="fa fa-archive"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $products->links('pagination::bootstrap-4') }}
    @endif
@endsection
