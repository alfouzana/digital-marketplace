@extends('layouts.app')

@section('header')
    @parent
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a href="{{ url('customer/purchases') }}"
                   class="nav-link{{ Request::url() == url('customer/purchases') ? ' active' : '' }}">
                    @lang('Purchases')
                </a>
            </li>
        </ul>
    </div>
@endsection