<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Student;
use App\Models\Enroll;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Helper\CRMS;
use Exception;

class StudentsImport implements ToCollection, WithHeadingRow
{

    public function  __construct($identification_number,$section_id, $std_class_id, $has_optional)
    {
        $this->section_id= $section_id;
        $this->identification_number= $identification_number;
        $this->std_class_id = $std_class_id;
        $this->has_optional = $has_optional;
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {

        $rules = [
            '*.name' => 'required',
            // '*.date_of_birth' => 'required',
            // '*.gender' => 'required',
            // '*.religion' => 'required',
            // // '*.address' => 'required',
            // '*.year' => 'required',
            // // '*.email' => ['unique:students,email','required'],
            // '*.phone'=>['unique:students,phone','required'],
        ];

        $validator = Validator::make($rows->toArray(), $rules);
        if ($validator->fails()) {
            dd("Validation Failed");

        }

        // dd($rows);

        foreach ($rows as $key=>$row)
        {
            try {
                $student = new Student;
                $student->name = $row['name'];
                $student->fathers_name = $row['fathers_name'];
                $student->fathers_mobile = $row['fathers_mobile'];
                $student->mothers_name = $row['mothers_name'];
                $student->mothers_mobile = $row['mothers_mobile'];


                if ($row['std_code'] != '') {
                    $student->code = $row['std_code'];
                    $student->std_code = $row['std_code'];
                }
                if ($row['std_code'] == '') {

                    $student_code = CRMS::uniqueNumberConvertor($row['year'], $this->identification_number, $row['roll']);
                    $student->code = $student_code;
                    $student->std_code = $student_code;
                }

                $student->year = $row['year'];
                $student->dob = $row['date_of_birth'];
                $student->gender = $row['gender'];
                $student->religion = $row['religion'];
                $student->blood_group = $row['blood_group'];
                $student->present_address = $row['present_address'];
                $student->permanent_address = $row['permanent_address'];
                $student->phone = $row['phone'];
                $student->email = $row['email'];
                $student->password = Hash::make("123456");
                $student->file_path = $row['file_path'];
                $student->uploaded_by = auth()->user()->id;

                $student->save();

                $enroll = new Enroll;
                $enroll->student_code = $student->std_code;
                $enroll->student_id = $student->id;
                $enroll->class_id = $this->std_class_id;
                $enroll->section_id = $this->section_id;
                if ($this->has_optional == 1) {
                    $enroll->optional_subject_id = $row['optional_subject_id'];
                }
                $enroll->compulsory_1 = $row['compulsory_1'];
                $enroll->compulsory_2 = $row['compulsory_2'];
                $enroll->compulsory_3 = $row['compulsory_3'];

                $enroll->roll = $row['roll'];
                $enroll->date_added = date('Y-m-d');
                $enroll->year = config('running_session');
                $enroll->uploaded_by = auth()->user()->id;
                $enroll->save();

                // $student = Student::create([

                //     'std_code' => $row['std_code'],
                //     'name' => $row['name'],
                //     'fathers_name' => $row['fathers_name'],
                //     'fathers_mobile' => $row['fathers_mobile'],
                //     'mothers_name' => $row['mothers_name'],
                //     'mothers_mobile' => $row['mothers_mobile'],
                //     'present_address' => $row['present_address'],
                //     'permanent_address' => $row['permanent_address'],
                //     'dob' => $row['date_of_birth'],
                //     'gender' => $row['gender'],
                //     'religion' => $row['religion'],
                //     'blood_group' => $row['blood_group'],
                //     // 'address' => $row['address'],
                //     'phone' => $row['phone'],
                //     'email' => $row['email'],
                //     'year' => $row['year'],
                //     'password' => Hash::make(123456),
                //     'file_path' => $row['file_path'],
                //     'uploaded_by' => auth()->user()->id,

                // ]);


                // $enroll = Enroll::create([
                //     'student_code' => $student->code,
                //     'student_id' => $student->id,
                //     'class_id' => $this->std_class_id,
                //     'section_id' => $this->section_id,
                //     'optional_subject_id' => $row['optional_subject_id'],
                //     'roll' => $row['roll'],
                //     'year' => config('running_session'),
                //     'uploaded_by' => auth()->user()->id,
                // ]);

              }

              //catch exception
              catch(Exception $e) {
                dd($e);
              }

        }

    }
}
