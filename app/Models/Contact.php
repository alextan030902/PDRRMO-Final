<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    // Define the table name if it's different from the model name (optional)
    protected $table = 'contacts';

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'category',
        'district',
        'municipality',
        'focal_person',
        'contact_number',
        'email',
        'response_team',
    ];
}
