@extends('layouts.app')

@section('title', __('New Product').' &raquo; '.__('Details'))

@section('content')
    {{ Form::open([
        'url' => url('/vendor/new-product/details')
    ]) }}

        <div class="form-group row">
            {{ Form::label('title', __('Title'), [
                'class' => 'col-lg-4 col-form-label text-lg-right'
            ]) }}

            <div class="col-lg-6">
                {{ Form::text('title', null, [
                    'required',
                    'class' => 'form-control' . ($errors->has('title') ? ' is-invalid' : '')
                ]) }}

                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group row">
            {{ Form::label('body', __('Body'), [
                'class' => 'col-lg-4 col-form-label text-lg-right'
            ]) }}

            <div class="col-lg-6">
                {{ Form::textarea('body', null, [
                    'required',
                    'class' => 'form-control' . ($errors->has('body') ? ' is-invalid' : '')
                ]) }}

                @if($errors->has('body'))
                    <div class="invalid-feedback">
                        {{ $errors->first('body') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group row">
            {{ Form::label('price', __('Price'), [
                'class' => 'col-lg-4 col-form-label text-lg-right'
            ]) }}

            <div class="col-lg-6">
                {{ Form::number('price', null, [
                    'required',
                    'min' => '0',
                    'class' => 'form-control' . ($errors->has('price') ? ' is-invalid' : '')
                ]) }}

                @if($errors->has('price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('price') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="form-group row">
            {{ Form::label('category_id', __('Category'), [
                'class' => 'col-lg-4 col-form-label text-lg-right'
            ]) }}

            <div class="col-lg-6">
                {{ Form::select('category_id', $category_options, null, [
                    'required',
                    'class' => 'form-control' . ($errors->has('category_id') ? ' is-invalid' : '')
                ]) }}

                @if($errors->has('category_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('category_id') }}
                    </div>
                @endif
            </div>
        </div>
    
        <div class="form-group row">
            <div class="col-lg-6 offset-lg-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Submit') }}
                </button>
            </div>
        </div>
    {{ Form::close() }}
@endsection