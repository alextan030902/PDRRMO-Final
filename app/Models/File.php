<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'files';

    // The attributes that are mass assignable.
    protected $fillable = [
        'name',
        'path',
        'extension',
        'size',
        'category',
        'date',
    ];

    // Optionally, you can define the date format if necessary
    protected $dateFormat = 'Y-m-d H:i:s';

    // If you are working with timestamps, you can define how the date columns should be handled
    protected $casts = [
        'date' => 'date',
    ];
}
