<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller  {

    public function getStudents() {
        $students = Student::allStudents();
        if($students) {
            return response()->json([
                'status' => 'success',
                'data' => $students,
            ]);
        } else {
            return response()->json(['error' => 'No students found !']);
        }
    }

    public function home() {
        $students = Student::allStudents();
        $countries = Country::allCountries();
        return view('home', ['students' => $students,'countries' => $countries]);
    }


    public function getStates(Request $request) {
        $states = State::allStates($request->country_id);
        return response()->json([
            'status' => 'success',
            'data' => $states,
        ]);
    }
    public function getCities(Request $request) {
        $cities = City::allCities($request->state_id);
        return response()->json([
            'status' => 'success',
            'data' => $cities,
        ]);
    }

    public function addStudent(Request $request) {
        $student = Student::addStudent($request->all());

        if($student) {
            return response()->json([
                'status' => 'success',
                'data' => $student,
            ]);
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