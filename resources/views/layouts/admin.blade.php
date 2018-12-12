@extends('layouts.app')

@section('title', 'Admin')

@section('header')
    @parent
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a href="{{ url('admin/products') }}"
                   class="nav-link{{ Request::url() == url('admin/products') ? ' active' : '' }}">
                    @lang('Products')
                </a>
            </li>
        </ul>
    </div>
@endsection