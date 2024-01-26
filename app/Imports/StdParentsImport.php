<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\StdParent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class StdParentsImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $rules = [
            '*.student_code' => 'required',
            '*.name' => 'required',
            '*.date_of_birth' => 'required',
            '*.gender' => 'required',
            '*.religion' => 'required',
            '*.blood_group' => 'required',
            '*.address' => 'required',
            '*.email' => ['unique:std_parents,email','required'],
            '*.phone'=>['unique:std_parents,phone','required'],
        ];

        $validator = Validator::make($rows->toArray(), $rules);
        if ($validator->fails()) {
            dd("test");

        }

        foreach ($rows as $key=>$row)
        {

            $std_parent = StdParent::create([
                'student_code'    => $row['student_code'],
                'name' => $row['name'],
                'dob' => $row['date_of_birth'],
                'gender' => $row['gender'],
                'religion' => $row['religion'],
                'blood_group' => $row['blood_group'],
                'address' => $row['address'],
                'phone' => $row['phone'],
                'email' => $row['email'],
                'password' => Hash::make(123456),
                'file_path' => $row['file_path'],
                'uploaded_by' => auth()->user()->id,

            ]);
        }
    }
}
