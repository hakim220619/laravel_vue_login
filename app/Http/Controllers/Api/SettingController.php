<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SettingPaymentModel;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = SettingPaymentModel::all();
        return response()->json([
            'success' => true,
            'message' => 'Data Setting Payment',
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
    public function edit($id)
    {
        $data = SettingPaymentModel::find($id);
        return response()->json([
            'success' => true,
            'message' => 'Data Bill Payment',
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd($request->all());
        $data = [
            'bill_name' => $request->bill_name,
            'desc' => $request->desc,
            'status' => $request->status,
            'updated_at' => now()
        ];


        // dd($request->id);
        DB::table('bill_payment')->where('id', $request->id)->update($data);
        return response()->json([
            'success' => true,
            'message' => 'Update Data Berhasil',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::table('bill_payment')->where('id', $id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Delete Data Berhasil',
        ]);
    }

   
}
