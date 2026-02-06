@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/') }}" />
@endsection

@section('header-button')
    <a href="/register" class="register-button">Register</a>
@endsection

@section('content')
    <div class="login-container">
        <h2 class="login-title">Login</h2>
        <form class="login-form" action="/login" method="post">
            @csrf
            <div class="login-form__item">
                <label class="login-form__label" for="email">メールアドレス</label>
                <input class="login-form__input" type="email" id="email" name="email" placeholder="例：test@example.com" value="{{ old('email') }}" />
                @error('email')
                    <span class="login-form__error">{{ $message }}</span>
                @enderror
            </div>
            <div class="login-form__item">
                <label class="login-form__label" for="password">パスワード</label>
                <input class="login-form__input" type="password" id="password" name="password" placeholder="例：coachtech1106" />
                @error('password')
                    <span class="login-form__error">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="login-form__button">ログイン</button>
        </form>
    </div>
@endsection