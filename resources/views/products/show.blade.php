@extends('layouts.app')

@section('title', e($product->title))

@section('content')
    <article>
        <h2>{{ $product->title }}</h2>
        <div class="row">
            <div class="col-lg-8">
                <img src="{{ asset($product->cover_path) }}"
                     alt="Cover" class="img-thumbnail w-100 mb-1">

                <div class="mb-3 d-flex justify-content-between">
                    <a href="{{ asset($product->sample_path) }}"
                       class="btn btn-outline-info" download
                    >
                        <i class="far fa-download"></i> @lang('Sample')
                    </a>

                    <span>
                        <i class="far fa-clock"></i> {{ $product->created_at }}
                    </span>

                    <a href="{{ $product->category->url() }}">
                        <i class="far fa-folder"></i> {{ $product->category->name }}
                    </a>

                    <a href="#">
                        <i class="far fa-user-circle"></i> {{ $product->vendor->name }}
                    </a>
                </div>

                <div>{{ $product->body }}</div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="far fa-tag"></i> {{ $product->price }}
                        </div>

                        <button type="button"
                                class="btn btn-primary w-100"
                        >Purchase</button>
                    </div>
                </div>
            </div>
        </div>
    </article>
@endsection