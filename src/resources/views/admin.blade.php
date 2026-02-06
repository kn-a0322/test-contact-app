@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}" />
@endsection

@section('header-button')
  @if (Auth::check())
    <form action="/logout" method="post">
        @csrf
        <button type="submit" class="logout-button">ログアウト</button>
    </form>
  @endif
@endsection

@section('content')
<div class="admin-form__content">
        <div class="admin-form__heading">
            <h2>Admin</h2>
        </div>
        <form class="admin-form__search" action="/search" method="get">
            <input type="text" name="keyword" placeholder="名前やメールアドレスを入力してください">
            <select name="gender">
                <option value="">性別</option>
                <option value="1">男性</option>
                <option value="2">女性</option>
                <option value="3">その他</option>
            </select>
            <select name="category_id">
                <option value="">お問い合わせの種類</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->content }}</option>
                @endforeach
            </select>

            <input type="date" name="date" placeholder="年/月/日">
            <button type="submit" class="search-button">検索</button>
            <a href="/reset" class="reset__button">リセット</a>
        </form>
            <div class="admin-form__controller">
                <button class="export-button">エクスポート</button>
                <div class="admin-table__pagination">
                    {!! $contacts->links() !!}
                </div>
            </div>

        <div class="admin-table">
            <table class="admin-table__inner">
                <tr class="admin-table__row">
                    <th class="admin-table__header">お名前</th>
                    <th class="admin-table__header">性別</th>
                    <th class="admin-table__header">メールアドレス</th>
                    <th class="admin-table__header">お問い合わせの種類</th>
                    <th class="admin-table__header"></th>
                </tr>
                @foreach ($contacts as $contact)
                <tr class="admin-table__row">
                    <td class="admin-table__text">{{ $contact->last_name }}&nbsp;{{ $contact->first_name }}</td>
                    <td class="admin-table__text">
                        @if ($contact->gender == 1)
                            <span>男性</span>
                        @elseif ($contact->gender == 2)
                            <span>女性</span>
                        @else
                            <span>その他</span>
                        @endif
                    </td>
                    <td class="admin-table__text">{{ $contact->email }}</td>
                    <td class="admin-table__text">{{ $contact->category->content }}</td>
                    <td class="admin-table__button">
                        <a href="#modal-{{ $contact->id }}" class="detail-button">詳細</a>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>

        @foreach ($contacts as $contact)
        <div id="modal-{{ $contact->id }}" class="modal-container">
            
            <div class="modal-body">
                <a href="#" class="modal-close">&times;</a>
                
                <div class="modal-content">
                    <table class="modal-table">
                        <tr>
                            <th class="modal-table__header">お名前</th>
                            <td class="modal-table__text">{{ $contact->last_name }} {{ $contact->first_name }}</td>
                        </tr>
                        <tr>
                            <th class="modal-table__header">性別</th>
                            <td class="modal-table__text">
                                @if ($contact->gender == 1)
                                    男性
                                @elseif ($contact->gender == 2)
                                    女性
                                @else
                                    その他
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="modal-table__header">メールアドレス</th>
                            <td class="modal-table__text">{{ $contact->email }}</td>
                        </tr>
                        <tr>
                            <th class="modal-table__header">電話番号</th>
                            <td class="modal-table__text">{{ $contact->tel }}</td>
                        </tr>
                        <tr>
                            <th class="modal-table__header">住所</th>
                            <td class="modal-table__text">{{ $contact->address }}</td>
                        </tr>
                        <tr>
                            <th class="modal-table__header">建物名</th>
                            <td class="modal-table__text">{{ $contact->building }}</td>
                        </tr>
                        <tr>
                            <th class="modal-table__header">お問い合わせの種類</th>
                            <td class="modal-table__text">{{ $contact->category->content }}</td>
                        </tr>
                        <tr>
                            <th class="modal-table__header">お問い合わせ内容</th>
                            <td class="modal-table__text">{{ $contact->detail }}</td>
                        </tr>
                    </table>
                    <form action="/delete/{{ $contact->id }}" method="post" class="modal-delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="modal-delete-button">削除</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>