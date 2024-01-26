<?php

namespace App\Imports;

use App\Models\AttendanceTeacher;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Student;
use App\Models\Enroll;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Helper\CRMS;
use Exception;
use App\Models\AttendanceStudent;
use Maatwebsite\Excel\Concerns\ToModel;
use DB;

class TeacherImport implements ToCollection, WithHeadingRow
{

    public function  __construct()
    {
    }
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {

        // dd($rows);

        $rules = [
            '*.teacher_code' => 'required',
        ];

        $validator = Validator::make($rows->toArray(), $rules);
        if ($validator->fails()) {
            dd("validation Failed");
        }


        foreach ($rows as $key => $row) {
            try {

                DB::table('attendance_teachers')
                    ->updateOrInsert(
                        [
                            // 'attendance_date' => $this->attendance_date,
                            'attendance_date' => $row['attendance_date'],
                            'teacher_id' => $row['teacher_code'],
                        ],
                        [
                            'in_time' => $row['in_time'],
                            'out_time' => $row['out_time'],
                            'late' => $row['late'],
                            'status' => $row['status'],
                            'remarks' => $row['remarks'],
                            'year' => config('running_session'),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );


            }

            //catch exception
            catch (Exception $e) {
                dd($e);
            }
        }
    }
}
