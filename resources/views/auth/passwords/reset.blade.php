@extends('layouts.app')

@section('content')
    <h6 class="h5 mb-0 mt-4">Сбросить пароль</h6>
    <p class="text-muted mt-1 mb-4">
        Введите новый пароль.
    </p>

    <form method="POST" action="{{ route('password.update') }}" class="authentication-form">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group">
            <label class="form-control-label">Email</label>
            <div class="input-group input-group-merge">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="icon-dual" data-feather="mail"></i>
                    </span>
                </div>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                       value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus
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
            <div class="input-group input-group-merge">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="icon-dual" data-feather="lock"></i>
                    </span>
                </div>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                       required autocomplete="current-password"
                       placeholder="Новый пароль">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <div class="input-group input-group-merge">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="icon-dual" data-feather="unlock"></i>
                    </span>
                </div>
                <input type="password" class="form-control" id="password"
                       name="password_confirmation" required autocomplete="new-password"
                       placeholder="Подтвердите новый пароль">
            </div>
        </div>

        <div class="form-group mb-0 text-center">
            <button class="btn btn-primary btn-block" type="submit">
                Войти
            </button>
        </div>
    </form>
@endsection
