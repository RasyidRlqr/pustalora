<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'image',
        'quantity',
        'available_quantity',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'available_quantity' => 'integer',
        ];
    }

    public function isAvailable()
    {
        return $this->available_quantity > 0;
    }

    public function getAvailableCopies()
    {
        return $this->available_quantity;
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}