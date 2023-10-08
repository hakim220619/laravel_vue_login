<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentModel extends Model
{
    use HasFactory;
    public static function getPaymentByStudent()
    {
        $query = DB::select("SELECT  p.id, SUM(p.amount) - (SELECT sum(p.amount) from payment p WHERE p.state = 'LUNAS') as total, 
        (SELECT IF(COUNT(p.state) = 12, 'LUNAS', 'BELUM LUNAS') from payment p where p.state = 'LUNAS') as state,
        bp.id, bp.bill_name, p.years FROM payment p, bill_payment bp, users u 
        WHERE p.bilPayment_id = bp.id 
        AND p.user_id = u.id 
        AND p.type = 'BULANAN'
        AND p.user_id = '" . request()->user()->id . "'
        GROUP BY p.bilPayment_id ");
        return $query;
    }
    public static function getBillMonthByIdByStudents($id)
    {
        $query = DB::select("SELECT p.id, p.user_id, p.years, p.amount ,p.type, p.state ,bp.bill_name, m.month 
        from payment p, users u, bill_payment bp, months m 
        WHERE p.user_id = u.id 
        AND p.bilPayment_id = bp.id 
        AND p.month_id = m.id 
        AND p.type = 'BULANAN'
        AND p.bilPayment_id = '$id'
        AND p.user_id = '" . request()->user()->id . "'");
        return $query;
    }
}
