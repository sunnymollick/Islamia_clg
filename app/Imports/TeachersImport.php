<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TeachersImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */


    public function collection(Collection $rows)
    {
        // dd($rows);
        // Validator::make($rows->toArray(), [

        //     '*.name' => 'required',
        //     '*.qualification' => 'required',
        //     '*.marital_status' => 'required',
        //     '*.date_of_birth' => 'required',
        //     '*.joining_date' => 'required',
        //     '*.gender' => 'required',
        //     '*.religion' => 'required',
        //     '*.address' => 'required',
        //     '*.designation' => 'required',
        //     '*.email' => 'required',
        //     '*.phone'=>'unique:teachers,phone | required'

        // ])->validate();

        $rules = [
            '*.name' => 'required',
            '*.qualification' => 'required',
            '*.marital_status' => 'required',
            '*.date_of_birth' => 'required',
            '*.joining_date' => 'required',
            '*.gender' => 'required',
            '*.religion' => 'required',
            '*.address' => 'required',
            '*.designation' => 'required',
            '*.email' => ['unique:teachers,email','required'],
            '*.phone'=>['unique:teachers,phone','required'],
        ];

        $validator = Validator::make($rows->toArray(), $rules);
        if ($validator->fails()) {
            dd("test");
            // return "test data";
            // return response()->json(['type' => 'error', 'message' => "Please Filled with Valid Data"]);
            // dd("test");
            // return response()->json([

            //     'type' => 'error',
            //     'message' => "<div class='alert alert-warning'>Error! File type is not valid</div>"
            // ]);
        }

        // dd($this->uploaded_by);
        foreach ($rows as $key=>$row)
        {

            $teacher = Teacher::create([
                'name' => $row['name'],
                'code'    => $row['code'],
                'qualification' => $row['qualification'],
                'marital_status' => $row['marital_status'],
                'dob' => $row['date_of_birth'],
                'doj' => $row['joining_date'],
                'gender' => $row['gender'],
                'religion' => $row['religion'],
                'blood_group' => $row['blood_group'],
                'address' => $row['address'],
                'phone' => $row['phone'],
                'email' => $row['email'],
                'password' => Hash::make(123456),
                'designation' => $row['designation'],
                'order' => $row['order'],
                'file_path' => $row['file_path'],
                'uploaded_by' => auth()->user()->id,

            ]);

        }
    }
}
