<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrgChart extends Model
{
    use HasFactory;

    protected $table = 'org_charts';

    protected $fillable = [
        'org_chart_image',
    ];
}
