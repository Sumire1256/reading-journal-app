<x-app-layout>
    <div>
        <form action="{{ route('books.store') }}" method="POST">
            @csrf
            <x-book-form :genres="$genres" />
            <button type="submit">記録する</button>
        </form>
    </div>
</x-app-layout>