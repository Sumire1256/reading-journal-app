<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::where('user_id', auth()->id());
        if ($request->filled('title')) {
            $query->where('title', 'like', '%', $request->title, '%');
        }
        if ($request->filled('author')) {
            $query->where('author', 'like', '%', $request->author, '%');
        }
        if ($request->filled('genre')) {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->where('genres.id', $request->genre);
            });
        }

        $books = $query->latest()->paginate(5);
        $genres = Genre::all();
        $count = $books->total();

        return view('books.index', compact('books', 'genres', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genres = Genre::all();

        return view('books.create', compact('genres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        $validated = $request->validated();
        $book = auth()->user()->books()->create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'memo' => $validated['memo'] ?? null,
            'status' => $validated['status'],
        ]);
        $book->genres()->sync($validated['genres']);

        return redirect()->route('books.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $this->authorize('view', $book);
        $genres = $book->genres;

        return view('books.show', compact('genres', 'book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $this->authorize('update', $book);
        $genres = Genre::all();

        return view('books.edit', compact('genres', 'book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, Book $book)
    {
        $this->authorize('update', $book);
        $validated = $request->validated();
        $book->update([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'memo' => $validated['memo'] ?? null,
            'status' => $validated['status'],
        ]);
        $book->genres()->sync($validated['genres']);

        return redirect()->route('books.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $this->authorize('delete', $book);
        $book->delete();

        return redirect()->route('books.index');
    }
}
