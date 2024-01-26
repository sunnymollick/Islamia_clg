<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Type\Integer;

class CustomersImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function  __construct($id)
    {
        $this->id= $id;
    }
    public function collection(Collection $rows)
    {
        foreach ($rows as $key=>$row)
        {
            // dd($this->id);
            if($key>0){
                $student = Student::create([
                    'name' => $row[0],
                    'email'    => $row[11],
                    'dob' => $row[4],

                ]);
            }
        }

    }
}
