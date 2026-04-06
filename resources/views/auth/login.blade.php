<x-app-layout>
    <div>
        <div>
            <h2>ログイン</h2>
            <form action="{{ route('login') }}" method="POST" novalidate>
                @csrf
                <div>
                    <label for="email">メールアドレス</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <p>{{ $message }}</p>
                    @enderror
                    <label for="password">パスワード</label>
                    <input type="password" name="password" id="password" required>
                    @error('password')
                        <p>{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label>
                        <input type="checkbox" name="remember">
                        <span>ログイン状態を保持する</span>
                    </label>
                </div>
                <button type="submit">
                    ログイン
                </button>
            </form>

            <p>
                アカウントをお持ちでない方は<a href="{{ route('register') }}">新規登録</a>
            </p>
        </div>
    </div>
</x-app-layout>