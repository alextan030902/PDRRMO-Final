<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarouselImage extends Model
{
    use HasFactory;

    protected $table = 'carousel_images';

    // Explicitly cast image_paths to array
    protected $casts = [
        'image_paths' => 'array',
    ];

    protected $fillable = [
        'image_paths',
    ];
}
