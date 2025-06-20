<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Atribut yang bisa diisi
    protected $fillable = [
        'name',           // Nama role (contoh: Admin, User, etc.)
        'description',    // Deskripsi role
        'daftar_akses',   // Daftar akses yang dimiliki oleh role (misalnya akses ke halaman)
        'proses_izin',    // Proses izin terkait dengan role
        'use_pin',        // Apakah role menggunakan PIN untuk autentikasi
        'action_list',    // Daftar tindakan (actions) yang bisa dilakukan oleh role
    ];

    // Menambahkan cast untuk memastikan tipe data yang tepat
    // protected $casts = [
    //     'daftar_akses' => 'array',   // Menyimpan daftar akses sebagai array
    //     'action_list'  => 'array',   // Menyimpan daftar action sebagai array
    // ];

    // Relasi Many-to-Many ke model User
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');
    }
}
