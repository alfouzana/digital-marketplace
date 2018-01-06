@extends('layouts.app')

@section('title', __('Login'))

@section('content')
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card">
                <div class="card-header">
                    @lang('Login')
                </div>

                <div class="card-body">
                    <form id="login-form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group row">
                            <label for="email" class="col-lg-4 col-form-label">
                                @lang('E-Mail Address')
                            </label>

                            <div class="col-lg-8">
                                <input type="email" id="email" name="email"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} }}"
                                       value="{{ old('email') }}" required autofocus>

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
                                <input id="password" type="password" name="password"
                                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} }}"
                                       required>

                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-8 offset-lg-4">
                                <div class="form-check">
                                    <input type="checkbox" name="remember" id="remember"
                                           class="form-check-input"{{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember" class="form-check-label">
                                        @lang('Remember Me')
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-8 offset-lg-4">
                                <button type="submit" class="btn btn-primary">
                                    @lang('Login')
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    @lang('Forgot Your Password?')
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
