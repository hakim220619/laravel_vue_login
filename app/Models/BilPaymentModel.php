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
}
