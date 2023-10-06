<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BilPaymentModel extends Model
{
    use HasFactory;
    public static function getBilPayment()
    {
        $query = DB::select("select bp.* from bill_payment bp, school s where bp.school_id=s.id and bp.school_id = '" . request()->user()->school_id . "' order by bp.type desc");
        return $query;
    }
    public static function getYears()
    {
        $query = DB::table('years')->get();
        return $query;
    }
    public static function getMonths()
    {
        $query = DB::select("select * from months order by number asc");
        return $query;
    }
    public static function billPaymentById($params)
    {
        // dd($params);
        $query = DB::table('bill_payment')->where('id', $params)->first();
        return $query;
    }
    public static function getStudentByBill($params)
    {
        // dd($params);
        $query = DB::select("select p.*, u.nisn, u.full_name, bp.bill_name from payment p, users u, bill_payment bp 
        where p.user_id=u.id 
        and p.bilPayment_id=bp.id
        and p.class_id = '" . $params['class'] . "' 
        and p.major_id = '" . $params['major'] . "' 
        and p.bilPayment_id = '" . $params['bilPayment_id'] . "'
        group by p.user_id");
        return $query;
    }
    public static function UpdatePaymentByIdShow($params)
    {
        $getDetailPayment = DB::table('payment')->where('id', $params)->first();
        // dd($getDetailPayment);
        $query = DB::select("select p.*, u.nisn, u.full_name, bp.bill_name from payment p, users u, bill_payment bp 
        where p.user_id=u.id 
        and p.bilPayment_id=bp.id
        and p.user_id = '$getDetailPayment->user_id'
        and p.school_id = '$getDetailPayment->school_id'
        and p.type = '$getDetailPayment->type'
        AND p.bilPayment_id = '$getDetailPayment->bilPayment_id'");
        // dd($query);
        return $query;
    }
}
