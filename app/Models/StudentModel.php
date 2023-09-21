<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentModel extends Model
{
    protected $table = 'users';

    protected $primaryKey = 'id';
    protected $fillable = [
        'full_name',
        'nisn',
        'email',
        'phone',
        'province_id',
        'regency_id',
        'class_id',
        'major_id',
        'date_ofbirth',
        'address',
        'status',
        'image',
        'role',
        'created_at',
        'updated_at',
        'password',
    ];
}
