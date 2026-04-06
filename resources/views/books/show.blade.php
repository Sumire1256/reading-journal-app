<x-app-layout>
    <div>
        <a href="{{ route('books.index') }}">一覧に戻る</a>
        <div>
            <a href="{{ route('books.edit', $book) }}">編集</a>
            <form action="{{ route('books.destroy', $book) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('削除しますか？')">削除</button>
            </form>
        </div>
    </div>
    <div>
        <h2>{{ $book->title }} <span>{{ $book->status_label }}</span></h2>
        <div>
            @foreach ($genres as $genre)
                <span>{{ $genre->name }}</span>
            @endforeach
        </div>
        <p>著者：{{ $book->author }}</p>
        <p>記録日：{{ $book->created_at->format('Y/m/d') }}</p>
        <p>{{ $book->memo }}</p>
    </div>
</x-app-layout>