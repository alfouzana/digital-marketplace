@extends('layouts.app')

@section('title', __('New Product').' &raquo; '.__('Cover'))

@section('content')
    <div class="row mt-5">
        <div class="col-lg-8 offset-lg-2">
            <div class="card">
                <div class="card-header">
                    @lang('Cover')
                </div>

                <div class="card-body">
                    {{ Form::open([
                        'url' => '/vendor/new-product/cover',
                        'files' => true
                    ]) }}

                    <div class="form-group row">
                        {{ Form::label('cover', __('Cover'), [
                            'class' => 'col-lg-4 col-form-label text-lg-right'
                        ]) }}

                        <div class="col-lg-6">
                            {{ Form::file('cover', [
                                'required',
                                'class' => 'form-control' . ($errors->has('cover') ? ' is-invalid' : '')
                            ]) }}

                            @if($errors->has('cover'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('cover') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-6 offset-lg-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Upload') }}
                            </button>
                        </div>
                    </div>

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
