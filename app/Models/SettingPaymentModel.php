<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingPaymentModel extends Model
{
    use HasFactory;
    protected $table = 'bill_payment';

    protected $primaryKey = 'id';
    protected $fillable = [
        'bill_name',
        'desc',
        'years',
        'type',
        'status',
        'created_at',

    ];
}
