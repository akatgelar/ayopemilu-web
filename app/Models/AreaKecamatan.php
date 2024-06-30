<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;


class AreaKecamatan extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    use Blameable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'area_kecamatan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'kemendagri_provinsi_kode',
        'kemendagri_kota_kode',
        'kemendagri_kecamatan_kode',
        'kemendagri_provinsi_nama',
        'kemendagri_kota_nama',
        'kemendagri_kecamatan_nama',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];




}
