@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/') }}" />
@endsection

@section('header-button')
    {{-- ログインボタン--}}
@endsection

@section('content')
    <div class="register-container">
        <h2 class="register-title">Register</h2>
        <form class="register-form" action="/register" method="post">
            @csrf
            <div class="register-form__item">
                <label class="register-form__label" for="name">お名前</label>
                <input class="register-form__input" type="text" id="name" name="name" required />
                @error('name')
                    <span class="register-form__error">{{ $message }}</span>
                @enderror
            </div>
            <div class="register-form__item">
                <label class="register-form__label" for="email">メールアドレス</label>
                <input class="register-form__input" type="email" id="email" name="email" required />
                @error('email')
                    <span class="register-form__error">{{ $message }}</span>
                @enderror
            </div>
            <div class="register-form__item">
                <label class="register-form__label" for="password">パスワード</label>
                <input class="register-form__input" type="password" id="password" name="password" required />
                @error('password')
                    <span class="register-form__error">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="register-form__button">登録</button>
        </form>
    </div>
@endsection