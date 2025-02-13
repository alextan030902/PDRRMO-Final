<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pdrrmo extends Model
{
    // Specify the table name if it doesn't follow the plural naming convention
    protected $table = 'images';

    // Specify which fields are mass assignable
    protected $fillable = ['image_path', 'image_name'];
}
