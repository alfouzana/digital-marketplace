@extends('layouts.app')

@section('title', e($product->title))

@section('content')
    <article>
        <h2>{{ $product->title }}</h2>
        <div class="row">
            <div class="col-lg-8">
                <img src="{{ $product->cover->url }}"
                     alt="Cover" class="img-thumbnail w-100 mb-1">

                <div class="mb-3 d-flex justify-content-between">
                    <a href="{{ $product->sample->url }}"
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

                        {{--<button type="button"--}}
                                {{--class="btn btn-primary w-100"--}}
                        {{-->Purchase</button>--}}

                        <form id="purchase-form"
                              action="{{ url('customer/purchases?product='.Hashids::encode($product->id)) }}"
                              method="POST"
                              data-stripe-name="{{ config('app.name') }}"
                              data-stripe-description="{{ $product->title }}"
                              data-stripe-key="{{ config('services.stripe.key') }}"
                              data-stripe-amount="{{ $product->getAttribute('price') * 100 }}">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </article>
@endsection