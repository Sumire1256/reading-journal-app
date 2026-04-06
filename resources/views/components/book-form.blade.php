@props(['book' => null, 'genres' => []])

<div>
    {{-- title --}}
    <div>
        <label for="title">タイトル</label>
        <input type="text" name="title" id="title" value="{{ old('title', $book?->title) }}">
        @error('title')
            <p>{{ $message }}</p>
        @enderror
    </div>
    {{-- author --}}
    <div>
        <label for="author">著者</label>
        <input type="text" name="author" id="author" value="{{ old('author', $book?->author) }}">
        @error('author')
            <p>{{ $message }}</p>
        @enderror
    </div>
    {{-- memo --}}
    <div>
        <label for="memo">メモ</label>
        <textarea name="memo" id="memo">{{ old('memo', $book?->memo) }}</textarea>
    </div>
    {{-- status --}}
    <div>
        <label>ステータス</label>
        <select name="status">
            <option value="0" {{ old('status', $book?->status) == 0 ? 'selected' : '' }}>未読</option>
            <option value="1"{{ old('status', $book?->status) == 1 ? 'selected' : '' }}>読書中</option>
            <option value="2"{{ old('status', $book?->status) == 2 ? 'selected' : '' }}>読了</option>
        </select>
        @error('status')
            <p>{{ $message }}</p>
        @enderror
    </div>
    {{-- genre --}}
    <div>
        <label>ジャンル</label>
        @foreach ($genres as $genre)
            <label>
                <input type="checkbox" name="genres[]" value="{{ $genre->id }}" {{ in_array($genre->id, old('genres', $book?->genres->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}>
                {{ $genre->name }}
            </label>
        @endforeach
        @error('genres')
            <p>{{ $message }}</p>
        @enderror
    </div>
</div>