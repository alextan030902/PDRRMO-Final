<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternalFile extends Model
{
    // Specify the correct table name
    protected $table = 'internal_files'; // Make sure this matches the table name in the database

    // Specify the fillable columns (optional, but a good practice)
    protected $fillable = ['title', 'description', 'file_path'];
}
