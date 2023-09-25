<?php

namespace App\Http\Controllers\Api;

use App\Models\StudentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = StudentModel::getStudents();
        // dd($data);
        return response()->json([
            'success' => true,
            'message' => 'Data Students',
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
        $data = [
            'nisn' => $request->nisn,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'class_id' => $request->class,
            'major_id' => $request->major,
            'date_ofbirth' => $request->date_ofbirth,
            'province_id' => request()->user()->province_id,
            'regency_id' => request()->user()->regency_id,
            'email_verified_at' => now(),
            'password' => Hash::make($request->password),
            'role' => 2,
            'image' => $getFileImage,
            'status' => 'ON',
            'remember_token' => base64_encode($request->email),
            'created_at' => now(),
        ];

        DB::table('users')->insert($data);
        return response()->json([
            'success' => true,
            'message' => 'Add Data Students Berhasil',
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
    public function edit(string $id)
    {
        $user = StudentModel::showUserById($id);
        return response()->json([
            'success' => true,
            'message' => 'Data Student',
            'data' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd($request->id);
        if ($request->file('file') && $request->password != null) {
            $getImage = DB::table('users')->where('id', $request->id)->first();
            $file_path = public_path() . '/storage/images/users/' . $getImage->image;
            File::delete($file_path);
            $image = $request->file('image');
            // dd($getImage->image);
            $filename = $image->getClientOriginalName();
            $image->move(public_path('storage/images/users'), $filename);
            $data = [
                'nisn' => $request->nisn,
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'class_id' => $request->class,
                'major_id' => $request->major,
                'date_ofbirth' => $request->date_ofbirth,
                'province_id' => request()->user()->province_id,
                'regency_id' => request()->user()->regency_id,
                'email_verified_at' => now(),
                'password' => Hash::make($request->password),
                'role' => 2,
                'status' => $request->status,
                'image' => $request->file('file')->getClientOriginalName(),
                'remember_token' => base64_encode($request->email),
                'updated_at' => now()
            ];
        } elseif ($request->file('file') != null) {
            $getImage = DB::table('users')->where('id', $request->id)->first();
            $file_path = public_path() . '/storage/images/users/' . $getImage->image;
            File::delete($file_path);
            $image = $request->file('image');
            // dd($getImage->image);
            $filename = $image->getClientOriginalName();
            $image->move(public_path('storage/images/users'), $filename);
            $data = [
                'nisn' => $request->nisn,
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'class_id' => $request->class,
                'major_id' => $request->major,
                'date_ofbirth' => $request->date_ofbirth,
                'province_id' => request()->user()->province_id,
                'regency_id' => request()->user()->regency_id,
                'email_verified_at' => now(),
                'role' => 2,
                'image' => $request->file('file')->getClientOriginalName(),
                'status' => $request->status,
                'remember_token' => base64_encode($request->email),
                'updated_at' => now()
            ];
        } elseif ($request->password != null) {
            $data = [
                'nisn' => $request->nisn,
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'class_id' => $request->class,
                'major_id' => $request->major,
                'date_ofbirth' => $request->date_ofbirth,
                'province_id' => request()->user()->province_id,
                'regency_id' => request()->user()->regency_id,
                'email_verified_at' => now(),
                'password' => Hash::make($request->password),
                'role' => 2,
                'status' => $request->status,
                'remember_token' => base64_encode($request->email),
                'updated_at' => now()
            ];
        } else {
            $data = [
                'nisn' => $request->nisn,
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'class_id' => $request->class,
                'major_id' => $request->major,
                'date_ofbirth' => $request->date_ofbirth,
                'province_id' => request()->user()->province_id,
                'regency_id' => request()->user()->regency_id,
                'email_verified_at' => now(),
                'role' => 2,
                'status' => $request->status,
                'remember_token' => base64_encode($request->email),
                'updated_at' => now()
            ];
        }

        // dd($data);
        DB::table('users')->where('id', $request->id)->update($data);
        return response()->json([
            'success' => true,
            'message' => 'Update Data Users Berhasil',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $getImage = DB::table('users')->where('id', $id)->first();
        // dd($getImage);
        $file_path = public_path() . '/storage/images/users/' . $getImage->image;
        File::delete($file_path);
        StudentModel::find($id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Delete Data Users Berhasil',
        ]);
    }
}
