@extends('layouts.app')

@section('title', __('New Product').' &raquo; '.__('Confirmation'))

@section('content')
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card">
                <div class="card-header">
                    {{ __('Confirmation') }}
                </div>
                <div class="card-body">
                    {{ Form::open([
                        'url' => '/vendor/new-product/confirmation'
                    ]) }}
                    <div class="form-group row">
                        {{ Form::label('', __('Cover'), [
                            'class' => 'col-form-label col-lg-4 text-lg-right'
                        ]) }}
                        <div class="col-lg-6">
                            <img src="{{ $cover->url }}"
                                 alt="{{ __('Cover') }}" class="img-thumbnail">
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('title', __('Title'), [
                            'class' => 'col-form-label col-lg-4 text-lg-right'
                        ]) }}
                        <div class="col-lg-6">
                            {{ Form::text('title', $product_data['title'], [
                                'class' => 'form-control',
                                'disabled'
                            ]) }}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('body', __('Body'), [
                            'class' => 'col-form-label col-lg-4 text-lg-right'
                        ]) }}
                        <div class="col-lg-6">
                            {{ Form::textarea('body', $product_data['body'], [
                                'class' => 'form-control',
                                'disabled'
                            ]) }}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('price', __('Price'), [
                            'class' => 'col-form-label col-lg-4 text-lg-right'
                        ]) }}
                        <div class="col-lg-6">
                            {{ Form::text('price', $product_data['price'], [
                                'class' => 'form-control',
                                'disabled'
                            ]) }}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('category', __('Category'), [
                            'class' => 'col-form-label col-lg-4 text-lg-right'
                        ]) }}
                        <div class="col-lg-6">
                            {{ Form::text('category_name', $category->name, [
                                'class' => 'form-control',
                                'disabled'
                            ]) }}
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('', __('Sample'), [
                            'class' => 'col-form-label col-lg-4 text-lg-right'
                        ]) }}
                        <div class="col-lg-6">
                            @component('vendor.new-product._file-preview', [
                                'url' => $sample->url,
                                'size' => $sample->size
                            ])
                                {{ $sample->original_name }}
                            @endcomponent
                        </div>
                    </div>
                    <div class="form-group row">
                        {{ Form::label('', __('File'), [
                            'class' => 'col-form-label col-lg-4 text-lg-right'
                        ]) }}
                        <div class="col-lg-6">
                            @component('vendor.new-product._file-preview', [
                                'url' => url('vendor/new-product/download-product-file'),
                                'size' => $file->size
                            ])
                                {{ $file->original_name }}
                            @endcomponent
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 offset-lg-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Confirm') }}
                            </button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection