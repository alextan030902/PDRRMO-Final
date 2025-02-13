<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarouselImage extends Model
{
    use HasFactory;

    // Define the table associated with the model (optional if it's following Laravel's conventions)
    protected $table = 'carousel_images';

    // Define the fillable attributes
    protected $fillable = [
        'image_path_1',
        'image_path_2',
        'image_path_3',
    ];

    // Optionally, if you're working with timestamps, you can set them explicitly:
    public $timestamps = true;
}
