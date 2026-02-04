@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/') }}" />
@endsection

@section('header-button')
    {{-- レジスターボタン--}}
@endsection

@section('content')
    <div class="login-container">
        <h2 class="login-title">Login</h2>
        <form class="login-form">
            @csrf
            <div class="login-form__item">
                <label class="login-form__label" for="email">メールアドレス</label>
                <input class="login-form__input" type="email" id="email" name="email" required />
            </div>
            <button type="submit" class="login-form__button">ログイン</button>
        </form>
    </div>
@endsection