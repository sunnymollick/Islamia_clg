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
use App\Models\AttendanceStudent;
use Maatwebsite\Excel\Concerns\ToModel;
use DB;

class AttendanceStudentImport implements ToCollection, WithHeadingRow
{

    public function  __construct($class_id, $section_id)
    {
        $this->class_id = $class_id;
        $this->section_id = $section_id;
        // $this->attendance_date = $attendance_date;
    }
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {

        $rules = [
            '*.student_code' => 'required',
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
            dd("test");
        }


        foreach ($rows as $key => $row) {
            try {

                DB::table('attendance_students')
                ->updateOrInsert(
                    [
                        // 'attendance_date' => $this->attendance_date,
                        'attendance_date' => $row['attendance_date'],
                        'student_code' => $row['student_code'],
                        'class_id' => $this->class_id,
                        'section_id' => $this->section_id,
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

                // $AttendanceStudent = new AttendanceStudent();
                // $AttendanceStudent->attendance_date = $this->attendance_date;
                // $AttendanceStudent->student_code = $row['student_code'];
                // $AttendanceStudent->class_id = $this->class_id;
                // $AttendanceStudent->section_id = $this->section_id;
                // $AttendanceStudent->year = config('running_session');
                // $AttendanceStudent->in_time = $row['in_time'];
                // $AttendanceStudent->out_time = $row['out_time'];
                // $AttendanceStudent->late = $row['late'];
                // $AttendanceStudent->status = $row['status'];
                // $AttendanceStudent->remarks = $row['remarks'];
                // $AttendanceStudent->save();

            }

            //catch exception
            catch (Exception $e) {
                dd($e);
            }
        }
    }
}
