@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}" />
@endsection

@section('header-button')
    <a href="/login" class="login-button">login</a>
@endsection

@section('content')
    <div class="register-container">
        <h2 class="register-title">Register</h2>
        <form class="register-form" action="/register" method="post">
            @csrf
            <div class="register-form__item">
                <label class="register-form__label" for="name">お名前</label>
                <input class="register-form__input" type="text" id="name" name="name" placeholder="例：山田  太郎" value="{{ old('name') }}" />
                @error('name')
                    <span class="register-form__error">{{ $message }}</span>
                @enderror
            </div>
            <div class="register-form__item">
                <label class="register-form__label" for="email">メールアドレス</label>
                <input class="register-form__input" type="email" id="email" name="email" placeholder="例：test@example.com" value="{{ old('email') }}" />
                @error('email')
                    <span class="register-form__error">{{ $message }}</span>
                @enderror
            </div>
            <div class="register-form__item">
                <label class="register-form__label" for="password">パスワード</label>
                <input class="register-form__input" type="password" id="password" name="password" placeholder="例：coachtech1106" />
                @error('password')
                    <span class="register-form__error">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="register-form__button">登録</button>
        </form>
    </div>
@endsection