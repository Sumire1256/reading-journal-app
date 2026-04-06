<x-app-layout>
    <div>
        <form action="{{ route('books.update') }}" method="POST">
            @csrf
            @method('PUT')
            <x-book-form :book="$book" :genres="$genres" />
            <button type="submit">更新する</button>
        </form>
    </div>
</x-app-layout>