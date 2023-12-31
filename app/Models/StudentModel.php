<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentModel extends Model
{
    protected $table = 'users';

    protected $primaryKey = 'id';
    protected $fillable = [
        'full_name',
        'uid',
        'nisn',
        'email',
        'phone',
        'password',
        'province_id',
        'regency_id',
        'class_id',
        'major_id',
        'school_id',
        'date_ofbirth',
        'address',
        'state',
        'image',
        'role',
        'created_at',
        'updated_at',

    ];
    public static function getStudents()
    {
        $data = DB::select("select u.*, c.class_name, m.major_name from users u, class c, major m where u.class_id=c.id and u.major_id=m.id and u.school_id = '" . request()->user()->school_id . "'");
        return $data;
    }
    public static function showUserById($id)
    {
        $data = DB::select("select u.*, c.class_name, m.major_name from users u, class c, major m where u.class_id=c.id and u.major_id=m.id and u.id = '$id'");
        return $data[0];
    }
}
