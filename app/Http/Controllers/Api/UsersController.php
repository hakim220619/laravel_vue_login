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
        DB::table('users')->insert([
            'uid' => 'ADS' . rand(00000, 99999) . date('Hms'),
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'province_id' => $request->province_id,
            'regency_id' => $request->regency_id,
            'school_id' => $request->school_id,
            'date_ofbirth' => $request->date_ofbirth,
            'email_verified_at' => now(),
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'image' => $getFileImage,
            'state' => 'ON',
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
        // dd($request->all());
        if ($request->file('file') && $request->password != null) {
            $getImage = DB::table('users')->where('id', $request->id)->first();
            $file_path = public_path() . '/storage/images/users/' . $getImage->image;
            File::delete($file_path);
            $image = $request->file('image');
            // dd($getImage->image);
            $filename = $image->getClientOriginalName();
            $image->move(public_path('storage/images/users'), $filename);
            $data = [
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'date_ofbirth' => $request->date_ofbirth,
                'email_verified_at' => now(),
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'state' => $request->status,
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

                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'date_ofbirth' => $request->date_ofbirth,
                'email_verified_at' => now(),
                'role' => $request->role,
                'image' => $request->file('file')->getClientOriginalName(),
                'state' => $request->status,
                'remember_token' => base64_encode($request->email),
                'updated_at' => now()
            ];
        } elseif ($request->password != null) {
            $data = [
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'date_ofbirth' => $request->date_ofbirth,
                'email_verified_at' => now(),
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'state' => $request->status,
                'remember_token' => base64_encode($request->email),
                'updated_at' => now()
            ];
        } elseif ($request->province_id && $request->regency_id != null) {
            $data = [
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'date_ofbirth' => $request->date_ofbirth,
                'province_id' => $request->province_id,
                'regency_id' => $request->regency_id,
                'email_verified_at' => now(),
                'role' => $request->role,
                'state' => $request->status,
                'remember_token' => base64_encode($request->email),
                'updated_at' => now()
            ];
        } else {
            $data = [
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'date_ofbirth' => $request->date_ofbirth,
                'email_verified_at' => now(),
                'role' => $request->role,
                'state' => $request->status,
                'remember_token' => base64_encode($request->email),
                'updated_at' => now()
            ];
        }

        // dd($request->id);
        DB::table('users')->where('id', $request->id)->update($data);
        return response()->json([
            'success' => true,
            'message' => 'Update Data Users Berhasil',
        ]);
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
        $class = DB::table('class')->select('id', 'class_name')->where('school_id', request()->user()->school_id)->get();
        return response()->json([
            'success' => true,
            'message' => 'Data Class',
            'data' => $class,
        ]);
    }
    function getMajor()
    {
        $class = DB::table('major')->select('id', 'major_name')->where('school_id', request()->user()->school_id)->get();
        return response()->json([
            'success' => true,
            'message' => 'Data Major',
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
    function getSchool($id)
    {
        // dd($id);
        $data = DB::table('school')->select('id', 'name')->where('regency_id', $id)->get();
        return response()->json([
            'success' => true,
            'message' => 'Data School',
            'data' => $data,
        ]);
    }
}
