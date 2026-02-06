<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionablyLate</title>
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inika:wght@400;700&display=swap" rel="stylesheet">
    {{-- CSS（読み込み順序が重要：sanitize → common → ページ固有） --}}
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <h1 class="header__logo">FashionablyLate</h1>
            <nav>
                <ul class="header__nav">
                    {{-- ここに要件に合わせたボタン（ログイン/登録/ログアウト）を配置します --}}
                    @yield('header-button')
                </ul>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>