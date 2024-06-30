<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'fingerprint',
        'method',
        'fullurl',
        'path',
        'user_agent',
        'os',
        'os_version',
        'browser',
        'browser_version',
        'device',
        'is_desktop',
        'is_mobile',
        'is_tablet',
        'ip',
        'country_code',
        'country_name',
        'region_code',
        'region_name',
        'city_code',
        'city_name',
        'zip_code',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'id' => 'integer',
        'is_desktop' => 'integer',
        'is_mobile' => 'integer',
        'is_tablet' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];
}
