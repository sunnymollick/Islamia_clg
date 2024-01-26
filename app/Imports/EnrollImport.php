<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Enroll;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EnrollImport implements ToCollection, WithHeadingRow
{
    public function  __construct($section_id)
    {
        $this->section_id= $section_id;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $rules = [
            '*.student_code' => 'required',
            '*.optional_subject_id' => 'required',
            '*.roll' => 'required',
        ];
        $validator = Validator::make($rows->toArray(), $rules);

        if ($validator->fails()) {
            dd("test");

        }


        foreach ($rows as $key=>$row){
            $enroll = Enroll::create([

                'student_code' => $row['student_code'],
                'section_id' => $this->section_id,
                'optional_subject_id' => $row['optional_subject_id'],
                'roll' => $row['roll'],
                'uploaded_by' => auth()->user()->id,
            ]);

        }
    }
}
