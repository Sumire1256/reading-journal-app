<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'author',
        'memo',
        'status',
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            1 => '読書中',
            2 => '読了',
            default => '未読'
        };
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
