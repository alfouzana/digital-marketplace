@extends('layouts.app')

@section('header')
    @parent
    <div class="container">
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a href="{{ url('/user/products') }}"
                   class="nav-link{{ Request::url() == url('/user/products') ? ' active' : '' }}">
                    @lang('My Products')
                </a>
            </li>
             <li class="nav-item">
                <a href="{{ url('/user/purchases') }}"
                   class="nav-link{{ Request::url() == url('/user/purchases') ? ' active' : '' }}">
                    @lang('Purchases')
                </a>
            </li>
        </ul>
    </div>
@endsection