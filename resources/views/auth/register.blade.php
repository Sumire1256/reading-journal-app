<x-app-layout>
    <div>
        <div>
            <h2>新規登録</h2>
            <form action="{{ route('register') }}" method="POST" novalidate>
                @csrf
                <div>
                    <label for="name">名前</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <p>{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="email">メールアドレス</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                    @error('email')
                        <p>{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password">パスワード</label>
                    <input type="password" name="password" id="password" required>
                    @error('password')
                        <p>{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation">パスワード（確認）</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required>
                </div>
                <button type="submit">登録</button>
            </form>
            
            <p>
                すでにアカウントをお持ちの方は<a href="{{ route('login') }}">ログイン</a>
            </p>
        </div>
    </div>
</x-app-layout>