@extends('layouts.app')

@section('title', __('Register'))

@section('content')
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card">
                <div class="card-header">
                    @lang('Register')
                </div>

                <div class="card-body">
                    <form id="registration-form"
                          method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group row">
                            <label for="name" class="col-lg-4 col-form-label">
                                @lang('Name')
                            </label>

                            <div class="col-lg-8">
                                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                       id="name" name="name" value="{{ old('name') }}" required autofocus>

                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-lg-4 col-form-label">
                                @lang('E-Mail Address')
                            </label>

                            <div class="col-lg-8">
                                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       id="email" name="email" value="{{ old('email') }}" required>

                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-lg-4 col-form-label">
                                @lang('Password')
                            </label>

                            <div class="col-lg-8">
                                <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       id="password" name="password" required>

                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-lg-4 col-form-label">
                                @lang('Confirm Password')
                            </label>

                            <div class="col-lg-8">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-lg-4 pt-0">@lang('Type')</legend>
                                <div class="col-lg-8">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                               id="type-vendor" name="type"
                                               value="{{ \App\Enums\UserTypes::VENDOR }}"
                                               required>
                                        <label class="form-check-label" for="type-vendor">
                                            @lang('Vendor')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                               id="type-customer" name="type"
                                               value="{{ \App\Enums\UserTypes::CUSTOMER }}"
                                               required>
                                        <label class="form-check-label" for="type-customer">
                                            @lang('Customer')
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <div class="form-group row">
                            <div class="col-lg-8 offset-lg-4">
                                <button type="submit" class="btn btn-primary">
                                    @lang('Register')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
