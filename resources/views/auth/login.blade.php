@extends('template.master')

@section('title', __('Login'))

@section('main-content')
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">

                    <div class="login-brand">
                        <img src="{{ asset('assets/img/stisla-fill.svg') }}" alt="logo" width="100"
                            class="shadow-light rounded-circle">
                    </div>

                    <div class="text-center mb-3">
                        <div class="dropdown d-inline-block">

                            <button class="btn btn-outline-primary btn-sm dropdown-toggle text-uppercase" type="button"
                                data-toggle="dropdown" aria-expanded="false">

                                <i class="fas fa-globe"></i>
                                {{ app()->getLocale() }}
                            </button>

                            <div class="dropdown-menu">

                                <a href="{{ route('lang.switch', 'en') }}"
                                    class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}">

                                    {{ __('English') }}
                                </a>

                                <a href="{{ route('lang.switch', 'id') }}"
                                    class="dropdown-item {{ app()->getLocale() == 'id' ? 'active' : '' }}">

                                    {{ __('Bahasa Indonesia') }}
                                </a>

                            </div>
                        </div>
                    </div>

                    <div class="card card-primary">

                        <div class="card-header">
                            <h4>{{ __('Login') }}</h4>
                        </div>

                        <div class="card-body">

                            <form method="POST" action="{{ route('signin') }}">
                                @csrf
                                @method('POST')

                                <div class="form-group">
                                    <label for="email">
                                        {{ __('Email') }}
                                    </label>

                                    <input id="email" type="email" class="form-control" name="email" tabindex="1"
                                        autofocus value="{{ old('email') }}">

                                    @error('email')
                                        <span class="text-danger text-sm">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">

                                    <div class="d-block">
                                        <label for="password" class="control-label">
                                            {{ __('Password') }}
                                        </label>
                                    </div>

                                    <input id="password" type="password" class="form-control" name="password"
                                        tabindex="2" value="{{ old('password') }}">

                                    @error('password')
                                        <span class="text-danger text-sm">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">

                                        {{ __('Login') }}
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>

                    <div class="mt-5 text-muted text-center">
                        {{ __("Don't have an account?") }}

                        <a href="{{ route('register') }}">
                            {{ __('Create one') }}
                        </a>
                    </div>

                    <div class="simple-footer">
                        Copyright &copy; Stisla
                        <span id="year"></span>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
