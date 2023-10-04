<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassModel extends Model
{
    use HasFactory;
    protected $table = 'class';

    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
    ];
    public static function CreateClass($request)
    {
        DB::table('class')->insert([
            'school_id' => $request['school_id'],
            'class_name' => $request['class_name'],
            'desc' => $request['desc'],
            'state' => $request['state'],
            'created_at' => now()
        ]);
    }
    public static function GetClassBySchool()
    {
        $query = DB::select("select ROW_NUMBER() OVER(ORDER BY id) as no, c.*, s.school_name from class c, school s where c.school_id=s.id and c.school_id = '" . request()->user()->school_id . "'");
        return $query;
    }
}
