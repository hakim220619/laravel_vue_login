<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MajorModel extends Model
{
    use HasFactory;
    protected $table = 'major';

    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
    ];
    public static function GetMajorBySchool()
    {
        $query = DB::select("select m.*, s.school_name from major m, school s where m.school_id=s.id and m.school_id = '" . request()->user()->school_id . "' and m.state = 'ON'");
        return $query;
    }

    public static function CreteMajor($request)
    {
        DB::table('major')->insert([
            'school_id' => $request['school_id'],
            'major_name' => $request['major_name'],
            'state' => $request['state'],
            'created_at' => now()
        ]);
    }
}
