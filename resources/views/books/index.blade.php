<x-app-layout>
    <div>
        <div>
            <h2>読書記録一覧</h2>
            <div>
                <p>全{{ auth()->user()->books()->count() }}件</p>
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
    </div>
</x-app-layout>