<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->all());
        $user = User::all();
        return response()->json([
            'success' => true,
            'message' => 'Data Users',
            'data' => $user,
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
        DB::table('users')->insert(['full_name' => $request->full_name,
            'email' => $request->email,
            'nisn' => $request->nisn,
            'provinsi_id' => $request->phone,
            'kabupaten_id' => $request->phone,
            'kelas_id' => $request->kelas_id,
            'jurusan_id' => $request->jurusan_id,
            'date_ofbirth' => $request->date_ofbirth,
            'address' => $request->address,
            'status' => $request->status,
            'image' => $request->image,
            'role' => $request->role,
            'password' =>  Hash::make($request->password),
            'created_at' => now()
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Add Data Users Berhasil',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        return response()->json([
            'success' => true,
            'message' => 'Data Users',
            'data' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        dd($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // dd($id);
        DB::table('users')->where('id', $id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Delete Data Users Berhasil',
        ]);
    }
    function getClass()
    {
        $class = DB::table('class')->select('id', 'class_name')->get();
        return response()->json([
            'success' => true,
            'message' => 'Data Users',
            'data' => $class,
        ]);
    }
    function getMajor()
    {
        $class = DB::table('major')->select('id', 'major_name')->get();
        return response()->json([
            'success' => true,
            'message' => 'Data Users',
            'data' => $class,
        ]);
    }
}
