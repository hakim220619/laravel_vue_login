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
            'school_id' => request()->user()->school_id,
            'state' => 'ON',
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
    public function billPaymentById($id)
    {
        $data = BilPaymentModel::billPaymentById($id);
        return response()->json([
            'success' => true,
            'message' => 'Data getNamePayment',
            'data' => $data,
        ]);
    }
    public function createPaymentByClass(Request $request)
    {
        ini_set('max_execution_time', 0);
        DB::beginTransaction();
        try {
            // Queries
            DB::commit(); // Commit 1
            $getUsers = DB::table('users')->where('school_id', request()->user()->school_id)->where('class_id', $request->class)->where('major_id', $request->major)->get();
            // dd($getUsers);
            for ($gu = 0; $gu < count($getUsers); $gu++) {
                for ($i = 0; $i < count($request->dataId); $i++) {
                    DB::table('payment')->insert([
                        'uid' => 'TRX' . rand(000, 999) . date('Hms'),
                        'school_id' => request()->user()->school_id,
                        'user_id' => $getUsers[$gu]->id,
                        'bilPayment_id' => $request->billPayment_id,
                        'class_id' => $request->class,
                        'major_id' => $request->major,
                        'month_id' => $request->dataId[$i],
                        'years' => $request->years,
                        'type' => $request->type,
                        'amount' => $request->data[$i],
                        'state' => "PENDING",
                        'created_at' => now()
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Create Bill Payment Successs',
                'data' => count($getUsers)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => true,
                'message' => 'Create Bill Payment Failed',
                'data' => 0
            ]);
        }
    }
    public function createPaymentByStudents(Request $request)
    {

        // dd($getUsers[$gu]->id);
        for ($i = 0; $i < count($request->dataId); $i++) {
            DB::table('payment')->insert([
                'uid' => 'TRX' . rand(000, 999) . date('Hms'),
                'school_id' => request()->user()->school_id,
                'user_id' => $request->user_id,
                'bilPayment_id' => $request->billPayment_id,
                'class_id' => $request->class,
                'major_id' => $request->major,
                'month_id' => $request->dataId[$i],
                'years' => $request->years,
                'type' => $request->type,
                'amount' => $request->data[$i],
                'state' => "PENDING",
                'created_at' => now()
            ]);
        }


        return response()->json([
            'success' => true,
            'message' => 'Create Bill Payment Successs',
            // 'data' => $data,
        ]);
    }
    public function createPaymentByClassFree(Request $request)
    {

        $getUsers = DB::table('users')->where('school_id', request()->user()->school_id)->where('class_id', $request->class)->where('major_id', $request->major)->get();
        // dd($getUsers);
        for ($gu = 0; $gu < count($getUsers); $gu++) {
            // dd($getUsers[$gu]->id);

            DB::table('payment')->insert([
                'uid' => 'TRX' . rand(000, 999) . date('Hms'),
                'school_id' => request()->user()->school_id,
                'user_id' => $getUsers[$gu]->id,
                'bilPayment_id' => $request->billPayment_id,
                'class_id' => $request->class,
                'major_id' => $request->major,
                'years' => $request->years,
                'type' => $request->type,
                'amount' => $request->amount,
                'state' => "PENDING",
                'created_at' => now()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Create Bill Payment Successs',
            // 'data' => $data,
        ]);
    }
    public function createPaymentByStudentsFree(Request $request)
    {



        DB::table('payment')->insert([
            'uid' => 'TRX' . rand(000, 999) . date('Hms'),
            'school_id' => request()->user()->school_id,
            'user_id' => $request->user_id,
            'bilPayment_id' => $request->billPayment_id,
            'class_id' => $request->class,
            'major_id' => $request->major,
            'years' => $request->years,
            'type' => $request->type,
            'amount' => $request->amount,
            'state' => "PENDING",
            'created_at' => now()
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Create Bill Payment Successs',
            // 'data' => $data,
        ]);
    }
}
