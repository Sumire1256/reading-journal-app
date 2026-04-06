<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Book $book;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->book = Book::factory()->create(['user_id' => $this->user->id]);
    }

    /**
     * A basic feature test example.
     */
    public function test_本の作成ができるか(): void
    {
        $genres = Genre::factory()->count(2)->create();

        $response = $this->actingAs($this->user)->post(route('books.store'), [
            'title' => 'テスト本',
            'author' => '著者',
            'memo' => 'メモ',
            'status' => 0,
            'genres' => $genres->pluck('id')->toArray(),
        ]);

        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseHas('books', ['title' => 'テスト本']);

    }

    public function test_一覧が表示されるか()
    {
        $response = $this->actingAs($this->user)->get(route('books.index'));

        $response->assertOk();
        $response->assertSee($this->book->title);
    }

    public function test_詳細が表示されるか()
    {
        $response = $this->actingAs($this->user)->get(route('books.show', $this->book));

        $response->assertOk();
        $response->assertSee($this->book->title);
    }

    public function test_更新ができるか()
    {
        $genres = Genre::factory()->count(2)->create();

        $response = $this->actingAs($this->user)->put(route('books.update', $this->book), [
            'title' => '更新後のタイトル',
            'author' => '更新後の著者',
            'memo' => '更新後のメモ',
            'status' => 2,
            'genres' => $genres->pluck('id')->toArray(),
        ]);

        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseHas('books', ['title' => '更新後のタイトル']);
    }

    public function test_削除ができるか()
    {
        $response = $this->actingAs($this->user)->delete(route('books.destroy', $this->book));

        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseMissing('books', ['id' => $this->book->id]);
    }

    public function test_自分の本のみ表示できるか()
    {
        $otherUser = User::factory()->create();
        $otherBook = Book::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($this->user)->get(route('books.index'));

        $response->assertSee($this->book->title);
        $response->assertDontSee(($otherBook->title));
    }

    public function test_タイトルが空白のときバリデーションエラー()
    {
        $genre = Genre::factory()->create();

        $response = $this->actingAs($this->user)->post(route('books.store'), [
            'title' => '',
            'author' => '著者名',
            'memo' => 'テスト',
            'status' => 1,
            'genres' => [$genre->id],
        ]);

        $response->assertSessionHasErrors(['title']);
    }

    public function test_タイトルが100字のとき作成できるか()
    {
        $genre = Genre::factory()->create();

        $response = $this->actingAs($this->user)->post(route('books.store'), [
            'title' => str_repeat('あ', 100),
            'author' => '著者名',
            'memo' => 'テスト',
            'status' => 1,
            'genres' => [$genre->id],
        ]);

        $response->assertRedirect(route('books.index'));
    }

    public function test_タイトルが101字のときバリデーションエラー()
    {
        $genre = Genre::factory()->create();

        $response = $this->actingAs($this->user)->post(route('books.store'), [
            'title' => str_repeat('あ', 101),
            'author' => '著者名',
            'memo' => 'テスト',
            'status' => 1,
            'genres' => [$genre->id],
        ]);

        $response->assertSessionHasErrors(['title']);
    }

    public function test_著者名が空白のときバリデーションエラー()
    {
        $genre = Genre::factory()->create();

        $response = $this->actingAs($this->user)->post(route('books.store'), [
            'title' => 'タイトル',
            'author' => '',
            'memo' => 'テスト',
            'status' => 1,
            'genres' => [$genre->id],
        ]);

        $response->assertSessionHasErrors(['author']);
    }

    public function test_著者名が100字のとき作成できるか()
    {
        $genre = Genre::factory()->create();

        $response = $this->actingAs($this->user)->post(route('books.store'), [
            'title' => 'タイトル',
            'author' => str_repeat('あ', 100),
            'memo' => 'テスト',
            'status' => 1,
            'genres' => [$genre->id],
        ]);

        $response->assertRedirect(route('books.index'));

    }

    public function test_著者名が101字のときバリデーションエラー()
    {
        $genre = Genre::factory()->create();

        $response = $this->actingAs($this->user)->post(route('books.store'), [
            'title' => 'タイトル',
            'author' => str_repeat('あ', 101),
            'memo' => 'テスト',
            'status' => 1,
            'genres' => [$genre->id],
        ]);

        $response->assertSessionHasErrors(['author']);
    }

    public function test_メモが空白でも作成できる()
    {
        $genre = Genre::factory()->create();

        $response = $this->actingAs($this->user)->post(route('books.store'), [
            'title' => 'タイトル',
            'author' => '著者名',
            'memo' => '',
            'status' => 1,
            'genres' => [$genre->id],
        ]);

        $response->assertRedirect(route('books.index'));
    }

    public function test_未ログインで一覧にアクセスするとログイン画面に移動()
    {
        $response = $this->get(route('books.index'));

        $response->assertRedirect(route('login'));
    }
}
