@extends('layouts.app')

@section('content')
    <h6 class="h5 mb-0 mt-4">Добро пожаловать!</h6>
    <p class="text-muted mt-1 mb-4">
        Введите свой email-адрес, чтобы получить доступ к системе.
    </p>

    <form method="POST" action="{{ route('login') }}" class="authentication-form">
        @csrf
        <div class="form-group">
            <label class="form-control-label">Email</label>
            <div class="input-group input-group-merge">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="icon-dual" data-feather="mail"></i>
                    </span>
                </div>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                       value="{{ old('email') }}" required autocomplete="email" autofocus
                       placeholder="Введите Ваш email">

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group mt-4">
            <label class="form-control-label">Пароль</label>
            <a href="{{ route('password.request') }}"
               class="float-right text-muted text-unline-dashed ml-1">Забыли пароль?</a>
            <div class="input-group input-group-merge">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="icon-dual" data-feather="lock"></i>
                    </span>
                </div>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                       required autocomplete="current-password"
                       placeholder="Введите Ваш пароль">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group mb-4">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="remember"
                       id="checkbox-signin" {{ old('remember') ? 'checked' : '' }}>
                <label class="custom-control-label" for="checkbox-signin">
                    Запомнить меня
                </label>
            </div>
        </div>

        <div class="form-group mb-0 text-center">
            <button class="btn btn-primary btn-block" type="submit">
                Войти
            </button>
        </div>
    </form>
@endsection
