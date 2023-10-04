<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GeneralModel;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    function GetRole()  {
        $data = GeneralModel::GetRole();
        return response()->json([
            'success' => true,
            'message' => 'Data Role',
            'data' => $data,
        ]);
    }
    function getSchoolById($id)
    {
        $data = GeneralModel::GetSchoolById($id);
        return response()->json([
            'success' => true,
            'message' => 'Data Role',
            'data' => $data,
        ]);
    }
}
