<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GeneralModel extends Model
{
    use HasFactory;
    public static function GetRole()
    {
        $query = DB::select("select * from role where id != 160");
        return $query;
    }
    public static function GetSchoolById($id)
    {
        $query = DB::table('school')->where('id', $id)->first();
        return $query;
    }
    public static function GetStudentByClassByMajor($request)
    {
        // dd($request);
        $query = DB::table('users')->where('class_id', $request['class'])->where('major_id', $request['major'])->where('state', 'ON')->get();
        return $query;
    }
    public static function getStudentByClassByMajorByIdFree($request)
    {
        // dd($request);

        $query = DB::select("select u.full_name, u.id  from users u where u.role = '160' 
         and u.class_id = '" . $request['class'] . "' 
         and u.major_id = '" . $request['major'] . "'
         and school_id = '" . request()->user()->school_id . "' 
         and u.id not in (select p.user_id  from payment p 
         where p.bilPayment_id = '" . $request['bilPayment_id'] . "' ) ORDER by u.full_name asc");
        return $query;
    }
    public static function getFullNameSearch($params)
    {
        // dd($params);
        $query = DB::select("select p.*, u.nisn, u.full_name, bp.bill_name from payment p, users u, bill_payment bp 
        where p.user_id=u.id 
        and p.bilPayment_id=bp.id
        and p.class_id = '" . $params['class'] . "' 
        and p.major_id = '" . $params['major'] . "' 
        and p.bilPayment_id = '" . $params['bilPayment_id'] . "'
        and u.full_name like '%" . $params['filterByName'] . "%' 
        group by p.user_id");
        return $query;
    }
}
