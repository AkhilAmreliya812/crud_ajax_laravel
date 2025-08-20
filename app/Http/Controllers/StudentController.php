<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // public function studentForm() {
    //     return view('home');
    // }

    public function getStudents() {
        $students = Student::allStudents();

       if($students->isNotEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Students retrieved successfully.',
                'data' => $students,
                'code' => 200
            ]);
        } else {
           return response()->json(['error' => 'No students found !']);
        }
    }

    public function addStudent(Request $request) {
       
        $student = Student::addStudent($request->all());

        if($student) {
            return response()->json([
                'status' => 'success',
                'message' => 'Student addes successfully.',
                'data' => $student,
                'code' => 201
            ]);
        } else {
            return response()->json(['error' => 'Student not addesd !']);
        }
    }

    public function deleteStudent(Request $request) {
        $student = Student::findStudentById($request->id);
        
        if($student) {
            $deletedStudent = Student::deleteStudent($request->id);
            if($deletedStudent) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Student deleted successfully.',
                    'data' => $deletedStudent,
                    'code' => 200
                ]);
            } else {
                return response()->json(['error' => 'Student not deleted !']);
            }
        }
    }

    public function findStudent(Request $request) {
        $student = Student::findStudentById($request->id);
       
        if($student) {
            return response()->json([
                'status' => 'success',
                'data' => $student
            ]);
        } else {
            return response()->json(['error' => 'Student not found !']);
        }
    }

    public function updateStudent(Request $request) {
        $student = Student::findStudentById($request->id);
        
        if($student) {
            $student->update($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Student updated successfully.',
                'data' => $student,
                'code' => 200
            ]);
        } else {
            return response()->json(['error' => 'Student not found !']);
        }
    }
}
