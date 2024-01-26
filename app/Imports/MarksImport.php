<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Mark;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MarksImport implements ToCollection, WithHeadingRow
{
    public function  __construct($subject_assign_id,$exam_id)
    {
        $this->subject_assign_id= $subject_assign_id;
        $this->exam_id= $exam_id;
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $rules = [
            // '*.student_code' => 'required',

        ];
        $validator = Validator::make($rows->toArray(), $rules);

        if ($validator->fails()) {
            dd("test+-+-");

        }


        foreach ($rows as $key=>$row){
            $mark = Mark::create([
                'subject_assign_id' => $this->subject_assign_id,
                'student_code' => $row['student_code'],
                'exam_id' => $this->exam_id,
                'theory_marks' => $row['theory_marks'],
                'mcq_marks' => $row['mcq_marks'],
                'practical_marks' => $row['practical_marks'],
                'ct_marks' => $row['ct_marks'],
                // 'total_marks' => $row['total_marks'],
                // 'pass_status' => $row['pass_status'],
                'uploaded_by' => auth()->user()->id,
            ]);

        }
    }
}
