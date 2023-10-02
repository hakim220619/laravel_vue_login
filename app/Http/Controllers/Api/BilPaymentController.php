<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\BilPaymentModel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BilPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data =  BilPaymentModel::getBilPayment();
        return response()->json([
            'success' => true,
            'message' => 'Data Bill Payment',
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        DB::table('bill_payment')->insert([
            'bill_name' => $request->bill_name,
            'desc' => $request->desc,
            'years' => $request->years,
            'type' => $request->type,
            'status' => 'ON',
            'created_at' => now(),
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Add Data Berhasil',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function getYears()
    {
        $data = BilPaymentModel::getYears();
        return response()->json([
            'success' => true,
            'message' => 'Data Years',
            'data' => $data,
        ]);
    }
    public function getMonths()
    {
        $data = BilPaymentModel::getMonths();
        return response()->json([
            'success' => true,
            'message' => 'Data Months',
            'data' => $data,
        ]);
    }
}
