<nav>
    <div>
        <a href="{{ route('books.index') }}">
            📚読書記録アプリ
        </a>

        <div>
            @auth
                <span>
                    {{ auth()->user()->name }}さん
                </span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">ログアウト</button>
                </form>
            @else
                <a href="{{ route('login') }}" >ログイン</a>
                <a href="{{ route('register') }}">新規登録</a>
            @endauth
        </div>
    </div>
</nav>