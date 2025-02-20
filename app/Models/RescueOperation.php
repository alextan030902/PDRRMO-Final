<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RescueOperation extends Model
{
    use HasFactory;

    // Define the table name if it's not the plural form of the model
    protected $table = 'rescue_operations';

    // Define the fillable attributes (these are the fields that can be mass-assigned)
    protected $fillable = [
        'category',
        'description',
        'images',
        'content',
    ];

    // Cast the images column to an array when retrieving from the database
    protected $casts = [
        'images' => 'array',
    ];
}
