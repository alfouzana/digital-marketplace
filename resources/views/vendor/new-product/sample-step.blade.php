@extends('layouts.app')

@section('title', __('New Product').' &raquo; '.__('Sample'))

@section('content')
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card">
                <div class="card-header">
                    {{ __('Sample') }}
                </div>
                <div class="card-body">
                    {{ Form::open([
                        'url' => 'vendor/new-product/sample',
                        'files' => true
                    ]) }}

                    <div class="form-group row">
                        {{-- todo: Rename sample field to file --}}
                        {{ Form::label('file', __('File'), [
                            'class' => 'col-form-label col-lg-4 text-lg-right'
                        ]) }}
                        <div class="col-lg-6">
                            {{ Form::file('file', [
                                'required',
                                'class' => 'form-control' . ($errors->has('file') ? ' is-invalid': '')
                            ]) }}

                            @if($errors->has('file'))
                                <div class="invalid-feedback">
                                    <strong>
                                        {{ $errors->first('file') }}
                                    </strong>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 offset-lg-4">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection

