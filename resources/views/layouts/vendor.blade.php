@extends('layouts.app')

@section('header')
    @parent
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a href="{{ url('vendor/products') }}"
                   class="nav-link{{ Request::url() == url('vendor/products') ? ' active' : '' }}">
                    @lang('My Products')
                </a>
            </li>
        </ul>
    </div>
@endsection