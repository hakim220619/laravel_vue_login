<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\BilPaymentModel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\GeneralModel;

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
    public function billPaymentByIdByClass($id)
    {
        $data = BilPaymentModel::billPaymentByIdByClass($id);
        return response()->json([
            'success' => true,
            'message' => 'Data getNamePayment',
            'data' => $data,
        ]);
    }
    public function getbillPaymentById($id)
    {
        // dd($id);
        $data = BilPaymentModel::getbillPaymentById($id);
        // dd($data);
        return response()->json([
            'success' => true,
            'message' => 'Data getNamePayment',
            'data' => $data,
        ]);
    }
    public function UpdatePaymentByIdShow($id)
    {
        $data = BilPaymentModel::UpdatePaymentByIdShow($id);
        return response()->json([
            'success' => true,
            'message' => 'Data getNamePayment',
            'data' => $data,
        ]);
    }
    public function getStudentByBill(Request $request)
    {
        $data = BilPaymentModel::getStudentByBill($request->all());
        // dd($data);
        return response()->json([
            'success' => true,
            'message' => 'Data getNamePayment',
            'data' => $data,
        ]);
    }
    public function getBillPaymentByIdPaymentAll(Request $request)
    {
        $data = BilPaymentModel::getBillPaymentByIdPaymentAll($request->all());
        // dd($data);
        return response()->json([
            'success' => true,
            'message' => 'Data getNamePayment',
            'data' => $data,
        ]);
    }
    public function createPaymentByClass(Request $request)
    {
        ini_set('max_execution_time', 0);
        // DB::beginTransaction();
        try {
            $getUsers = GeneralModel::getStudentByClassByMajorByIdFree($request->all());
            // dd(count($getUsers));
            if (count($getUsers) == 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'All Users have done this bill Payment',
                    'data' => count($getUsers)
                ]);
            }
            for ($gu = 0; $gu < count($getUsers); $gu++) {
                for ($i = 0; $i < count($request->dataId); $i++) {
                    DB::table('payment')->insert([
                        'uid' => 'TRX' . rand(000, 999) . date('Hms'),
                        'school_id' => request()->user()->school_id,
                        'user_id' => $getUsers[$gu]->id,
                        'bilPayment_id' => $request->bilPayment_id,
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
            // DB::rollBack();
            return response()->json([
                'success' => true,
                'message' => ' Create Bill Payment Failed',
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
                'bilPayment_id' => $request->bilPayment_id,
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
    public function UpdatePaymentByIdByStudents(Request $request)
    {

        // dd(count($request->dataId));
        for ($i = 0; $i < count($request->dataId); $i++) {
            // dd($request->data[$i]);
            DB::table('payment')
                ->where('user_id', $request->user_id)
                ->where('bilPayment_id', $request->bilPayment_id)
                ->where('type', $request->type)
                ->where('month_id', $request->dataId[$i])
                ->update([
                    'amount' => $request->data[$i],
                    'updated_at' => now()
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

        $getUsers = GeneralModel::getStudentByClassByMajorByIdFree($request->all());
        if (count($getUsers) == 0) {
            return response()->json([
                'success' => true,
                'message' => 'Users have done this bill Payment',
                'data' => count($getUsers)
            ]);
        }
        for ($gu = 0; $gu < count($getUsers); $gu++) {
            DB::table('payment')->insert([
                'uid' => 'TRX' . rand(000, 999) . date('Hms'),
                'school_id' => request()->user()->school_id,
                'user_id' => $getUsers[$gu]->id,
                'bilPayment_id' => $request->bilPayment_id,
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
    public function updatePaymentByStudentsFree(Request $request)
    {
        DB::table('payment')
            ->where('id', $request->idPayment)
            ->update([
                'amount' => $request->amount,
                'updated_at' => now()
            ]);
        return response()->json([
            'success' => true,
            'message' => 'Update Bill Payment Successs',
            // 'data' => $data,
        ]);
    }
}
