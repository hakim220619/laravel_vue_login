<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'role',
        'state',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function getUsers()
    {
        $query = DB::select("select ROW_NUMBER() OVER(ORDER BY id) as no, u.*, IF( role = 150 , 'Super Admin', IF(role = 170 , 'Admin Sekolah', '') ) AS role_name from users u where u.role != 160");
        return $query;
    }
    public static function showUserById($id)
    {
        $query = DB::select("SELECT u.*, IF( role = 150 , 'Super Admin', IF(role = 170 , 'Admin Sekolah', '') ) AS role_name, p.nama as province_name, r.nama as regency_name from users u, province p, regency r where u.province_id=p.id and u.regency_id=r.id and u.id = '$id'");
        return $query[0];
    }
}
