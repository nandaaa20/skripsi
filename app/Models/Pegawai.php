<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';

    protected $fillable = [
        'user_id',
        'nip',
        'nama_lengkap',
        'jabatan',
        'departemen',
        'jenis_kelamin',
        'tanggal_lahir',
        'no_telepon',
        'alamat',
        'tanggal_masuk',
        'status_kepegawaian',
        'kuota_cuti',
        'sisa_cuti',
    ];

    // Agar tidak ada overwrite mass assignment
    protected $guarded = ['id'];

    // Event Model: Otomatis bersihkan cache dashboard jika data berubah  
    protected static function booted()
    {
        static::created(function () {
            Cache::forget('dashboard.total_pegawai');
            Cache::forget('dashboard.pegawai_aktif');
            Cache::forget('dashboard.pegawai_nonaktif');
            Cache::forget('dashboard.pegawai_kontrak');
        });

        static::updated(function ($pegawai) {
            if ($pegawai->isDirty('status_kepegawaian')) {
                Cache::forget('dashboard.total_pegawai');
                Cache::forget('dashboard.pegawai_aktif');
                Cache::forget('dashboard.pegawai_nonaktif');
                Cache::forget('dashboard.pegawai_kontrak');
            }
        });

        static::deleted(function () {
            Cache::forget('dashboard.total_pegawai');
            Cache::forget('dashboard.pegawai_aktif');
            Cache::forget('dashboard.pegawai_nonaktif');
            Cache::forget('dashboard.pegawai_kontrak');
        });
    }

    // RELATIONSHIPS

    public function cuti()
    {
        return $this->hasMany(\App\Models\Cuti::class);
    }

    public function kehadiran()
    {
        return $this->hasMany(\App\Models\Kehadiran::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    // SCOPE: Pegawai Aktif
    public function scopeAktif($query)
    {
        return $query->where('status_kepegawaian', 'aktif');
    }

    // SCOPE: Pegawai Kontrak
    public function scopeKontrak($query)
    {
        return $query->where('status_kepegawaian', 'kontrak');
    }

    // SCOPE: Pegawai Nonaktif
    public function scopeNonAktif($query)
    {
        return $query->where('status_kepegawaian', 'nonaktif');
    }
}
