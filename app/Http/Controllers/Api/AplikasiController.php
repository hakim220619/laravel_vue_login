<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AplikasiController extends Controller
{
    function index()
    {
        $data = DB::table('aplikasi')->first();
        return response()->json([
            'success' => true,
            'message' => 'Data Aplikasi',
            'data' => $data,
        ]);
    }
}
