<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\StudentModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        ini_set('max_execution_time', 0);
        // dd($row);
        $getIdClass = DB::table('class')->where('class_name', $row['kelas'])->where('school_id', request()->user()->school_id)->first();
        $getIdMajor = DB::table('major')->where('major_name', $row['jurusan'])->where('school_id', request()->user()->school_id)->first();
        // dd($getIdMajor);
        return new StudentModel([
            'uid' => 'STD' . rand(00000, 99999) . date('Hms'),
            'nisn' => $row['nisn'],
            'password' => Hash::make(12345678),
            'email' => $row['email_bila_ada'],
            'full_name' => Str::upper($row['nama_siswa']),
            'class_id' => $getIdClass->id,
            'major_id' => $getIdMajor->id,
            'phone' => $row['nomor_whatsapp'],
            'school_id' => request()->user()->school_id,
            'state' => "ON",
            'role' => 160,

        ]);
    }
}
