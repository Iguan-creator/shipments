@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <h6 class="h5 mb-0 mt-4">Сброс пароля</h6>
    <p class="text-muted mt-1 mb-5">
        Введите Ваш email и мы отправим Вам письмо с инструкциями по восстановлению пароля.
    </p>

    <form method="POST" action="{{ route('password.email') }}" class="authentication-form">
        @csrf
        <div class="form-group">
            <label class="form-control-label">Email</label>
            <div class="input-group input-group-merge">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="icon-dual" data-feather="mail"></i>
                    </span>
                </div>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                       value="{{ old('email') }}" required autocomplete="email" autofocus
                       placeholder="Введите Ваш email">

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group mb-0 text-center">
            <button class="btn btn-primary btn-block" type="submit">
                Отправить
            </button>
        </div>
    </form>
@endsection
