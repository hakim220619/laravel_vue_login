<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd($request->all());
        $data = User::getUsers();
        return response()->json([
            'success' => true,
            'message' => 'Data Users',
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
        $getFileImage = '';
        if ($request->file('file') != null) {
            $image = $request->file('file');
            // dd($getImage->image);
            $filename = $image->getClientOriginalName();
            $image->move(public_path('storage/images/users'), $filename);
            $getFileImage .= $request->file('file')->getClientOriginalName();
        } else {
            $getFileImage .= null;
        }
        DB::table('users')->insert(['full_name' => $request->full_name,

            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'province_id' => $request->province_id,
            'regency_id' => $request->regency_id,
            'date_ofbirth' => $request->date_ofbirth,
            'email_verified_at' => now(),
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'image' => $getFileImage,
            'status' => 'ON',
            'remember_token' => base64_encode($request->email),
            'created_at' => now(),
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
        $user = User::showUserById($id);
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
        $getImage = DB::table('users')->where('id', $id)->first();
        $file_path = public_path() . '/storage/images/users/' . $getImage->image;
        File::delete($file_path);
        User::find($id)->delete();
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
    function getProvince()
    {
        $data = DB::table('province')->select('id', 'nama')->get();
        return response()->json([
            'success' => true,
            'message' => 'Data Province',
            'data' => $data,
        ]);
    }
    function getRegency($id)
    {
        // dd($id);
        $data = DB::table('regency')->select('id', 'nama')->where('province_id', $id)->get();
        return response()->json([
            'success' => true,
            'message' => 'Data Regency',
            'data' => $data,
        ]);
    }
}
