@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/') }}" />
@endsection


@section('content')
<div class="confirm__content">
    <div class="confirm__heading">
        <h2>Confirm</h2>
    </div>
    <form class="form" action="/contacts" method="post">
        @csrf
        <div class="confirm-table">
            <table class="confirm-table__inner">
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お名前</th>
                    <td class="confirm-table__text">
                        <input type="hidden" name="last_name" value="{{ $contact['last_name'] }}" >
                        <input type="hidden" name="first_name" value="{{ $contact['first_name'] }}" >
                        <span>{{ $contact['last_name'] }} &nbsp;&nbsp;{{ $contact['first_name'] }}</span>
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">性別</th>
                    <td class="confirm-table__text">
                        <input type="hidden" name="gender" value="{{ $contact['gender'] }}" >
                        @if ($contact['gender'] == 1)
                            <span>男性</span>
                        @elseif ($contact['gender'] == 2)
                            <span>女性</span>
                        @else
                            <span>その他</span>
                        @endif
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">メールアドレス</th>
                    <td class="confirm-table__text">
                        <input type="text" name="email" value="{{ $contact['email'] }}" readonly>
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">電話番号</th>
                    <td class="confirm-table__text">
                        <input type="text" name="tel" value="{{ $contact['tel'] }}" readonly>
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">住所</th>
                    <td class="confirm-table__text">
                        <input type="text" name="address" value="{{ $contact['address'] }}" readonly>
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">建物名</th>
                    <td class="confirm-table__text">
                        <input type="text" name="building" value="{{ $contact['building'] }}" readonly>
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お問い合わせの種類</th>
                    <td class="confirm-table__text">
                        <input type="hidden" name="category_id" value="{{ $contact['category_id'] }}">
                        <span>{{ $contact['category_name'] }}</span>
                    </td>
                </tr>
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お問い合わせ内容</th>
                    <td class="confirm-table__text">
                        <textarea name="detail" readonly>{{ $contact['detail'] }}</textarea>
                    </td>
                </tr>
            </table>
        </div>
        <div class="form-button">
            <button class="form__button-submit" type="submit" name="action" value="submit">送信</button>
            <button class="form__button-back" type="submit" name="action" value="back">修正</button>
        </div>
    </form>
</div>