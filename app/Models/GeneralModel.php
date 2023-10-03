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
        $query = DB::select("select * from role where state = 'ON' and id != 160");
        return $query;
    }
}
