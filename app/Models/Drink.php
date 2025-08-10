<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drink extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'price_tall',
        'price_grande',
        'price_venti',
    ];

    protected function casts():array
    {
        return [
            'price_tall' => 'decimal:2',
            'price_grande' => 'decimal:2',
            'price_venti' => 'decimal:2',
        ];
    }

    public function getPriceBySize(string $size): ?float
    {
        return match($size) {
            'tall' => $this->price_tall,
            'grande' => $this->price_grande,
            'venti' => $this->price_venti,
            default => null,
        };
    }

    public function getAvailableSizes(): array
    {
        $sizes = [];
        if ($this->tall_price) $sizes[] = 'tall';
        if ($this->grande_price) $sizes[] = 'grande';
        if ($this->venti_price) $sizes[] = 'venti';
        return $sizes;
    }
}
