<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookPolicyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    private User $user;

    private Book $book;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->book = Book::factory()->create(['user_id' => $this->user->id]);
    }

    public function test_他人の本の詳細は見れない(): void
    {
        $otherUser = User::factory()->create();
        $otherBook = Book::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($this->user)->get(route('books.show', $otherBook));

        $response->assertForbidden();
    }

    public function test_他人の本を編集できない(): void
    {
        $otherUser = User::factory()->create();
        $otherBook = Book::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($this->user)->get(route('books.edit', $otherBook));

        $response->assertForbidden();
    }

    public function test_他人の本を削除できない(): void
    {
        $otherUser = User::factory()->create();
        $otherBook = Book::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($this->user)->delete(route('books.destroy', $otherBook));

        $response->assertForbidden();
    }
}
