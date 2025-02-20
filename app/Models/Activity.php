<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description'];

    // Define the relationship to the ActivityImage model
    public function images()
    {
        return $this->hasMany(ActivityImage::class);
    }
}
