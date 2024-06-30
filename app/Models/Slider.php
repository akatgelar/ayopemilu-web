<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

class Slider extends Model
{
    use HasFactory;
    use BlameableTrait;

    protected $fillable = [
        'id',
        'name',
        'description',
        'image',
        'link',
        'notes',
        'is_active'
    ];

    protected $casts = [
        'id' => 'integer',
        'is_active' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];
}
