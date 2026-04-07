<x-app-layout>
    <div>
        <div>
            <h2>読書記録一覧</h2>
            <form action="{{ route('books.index') }}" method="GET">
                <h3>検索</h3>
                <input type="text" name="title" value="{{ request('title') }}" placeholder="タイトルで検索">
                <input type="text" name="author" value="{{ request('author') }}" placeholder="著者名で検索">
                <p>ジャンルで検索</p>
                <select name="genre">
                    <option value="">ジャンル指定なし</option>
                    @foreach ($genres as $genre)
                        <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : ''}}>
                            {{ $genre->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit">検索</button>
                <a href="{{ route('books.index') }}">リセット</a>
            </form>
            <div>
                <p>全{{ $count }}件</p>
                <a href="{{ route('books.create') }}">新しい記録</a>
            </div>
            
        </div>
        <div>
            @forelse ($books as $book)
                <div>
                    <h3><a href="{{ route('books.show',$book) }}">{{ $book->title }}</a></h3>
                    <p>{{ $book->author }}</p>
                    <p>{{ Str::limit($book->memo, 50, '…つづきを読む') }}</p>
                    <div>
                        <p>{{ $book->status_label }}</p>
                        <p>記録日：{{ $book->created_at->format('Y/m/d') }}</p>
                    </div>
                </div>
            @empty
                <p>読書記録がありません</p>
            @endforelse
        </div>
        {{ $books->withQueryString()->links() }}
    </div>
</x-app-layout>