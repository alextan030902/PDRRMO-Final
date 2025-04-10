<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';  // Define table name

    // Allow mass assignment on these columns
    protected $fillable = [
        'user_name',
        'action',
        'model',
        'model_id',
        'changes',
    ];

    // Automatically cast 'changes' as an array
    protected $casts = [
        'changes' => 'array',
    ];

    // Relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
