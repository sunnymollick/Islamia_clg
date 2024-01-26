<?php

namespace App\Helper;

use App\Models\Service;
use App\Models\SubjectAssign;
use DB;

class CRMS
{

    public static function uniqueNumberConvertor1111($id, $digit)
    {
        return str_pad($id, $digit, "0", STR_PAD_LEFT);
    }

    public static function uniqueNumberConvertor($year,$identification_number,$roll)
    {
        return $year.$identification_number.str_pad($roll, 3, "0", STR_PAD_LEFT);
    }


    /**
     * @param $section_id
     * @param $subject_id
     * @param $exam_id
     * @return mixed
     */
    public static function getSubjectMarks($section_id, $subject_id, $exam_id)
   {
    //   dd('cls-'.$section_id.'_sec-'.$subject_id,'exm-',$exam_id);
      $subject_assign=SubjectAssign::where('subject_id',$subject_id)->where('section_id',$section_id)->first();

      DB::statement(DB::raw("set @exam_id=$exam_id, @subject_assign=$subject_assign->id"));

      $data = DB::select("SELECT st.name AS student_name,st.code AS student_code,el.roll AS roll,mk.theory_marks AS theory_marks,mk.mcq_marks AS mcq_marks,mk.practical_marks AS practical_marks,mk.ct_marks AS ct_marks,mk.total_marks AS total_marks

                            from marks AS mk
                            LEFT JOIN enrolls AS el ON el.student_code=mk.student_code
                            LEFT JOIN students AS st on st.code=el.student_code
                            WHERE mk.subject_assign_id=@subject_assign AND mk.exam_id=@exam_id
                            ORDER BY el.roll asc");


    //   DB::statement(DB::raw("set @exam_id=$exam_id, @section_id=$section_id, @subject_id=$subject_id"));

    //   $data = DB::select("SELECT st.name AS student_name,st.code AS student_code,el.roll AS roll,mk.theory_marks AS theory_marks,mk.mcq_marks AS mcq_marks,mk.practical_marks AS practical_marks,mk.ct_marks AS ct_marks,mk.total_marks AS total_marks,sec.name AS section_name,cls.name AS class_name,exm.name AS exam_name
    //     FROM enrolls AS el
    //     LEFT JOIN marks AS mk ON mk.student_code=el.student_code AND mk.exam_id=@exam_id
    //     LEFT JOIN sections AS sec ON sec.id=el.section_id AND sec.id=@section_id
    //     LEFT JOIN std_classes AS cls ON cls.id=sec.std_class_id
    //     LEFT JOIN exams AS exm ON exm.std_class_id=cls.id
    //     LEFT JOIN subject_assigns AS sa ON sa.section_id=sec.id AND sa.subject_id=@subject_id
    //     LEFT JOIN students AS st ON st.code=el.student_code
    //     WHERE el.section_id=@section_id
    //     ORDER BY el.roll asc");

      return $data;
   }


}
