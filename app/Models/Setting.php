<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

class Setting extends Model
{
    use HasFactory;
    use BlameableTrait;

    protected $fillable = [
        'id',
        'type',
        'key',
        'value',
        'is_wysiwyg',
        'notes',
        'is_active'
    ];

    protected $casts = [
        'id' => 'integer',
        'is_wysiwyg' => 'integer',
        'is_active' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];
}
