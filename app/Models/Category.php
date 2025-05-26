<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;  // <-- Agrega esta línea
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;  // <-- Y esta línea

    protected $fillable = ['name', 'slug', 'description', 'priority']; // agrega los campos que definiste en migración

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
