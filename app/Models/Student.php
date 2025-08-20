<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['name','email','phone','address'];

    public static function addStudent($data) {
        $student = self::create($data);
        
        return $student;
    }

    public static function allStudents() {
        $students = self::all();

        return $students;
    }
    public static function findStudentById($id) {
        $student = self::find($id);

        if($student) {
            return $student;
        } else {
            return null;
        }
    }

    public static function deleteStudent($id) {
        self::where('id', $id)->delete();
        return true;
    }

    public static function updateStudent($id,$data) {
        $student = self::find($id);
        
        if($student) {
            $student->update($data);
            return $student;
        } else {
            return null;
        }
    }

}
