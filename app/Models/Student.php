<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'address', 'country', 'state', 'city'];

    /**
     * A student belongs to a country.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * A student belongs to a state.
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * A student belongs to a city.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public static function addStudent($data) {
        $student = self::create($data);
        
        return $student;
    }

    public static function allStudents() {
        $students = Student::select([
            'students.id',
            'students.name',
            'students.email',
            'students.phone',
            'students.address',
            'countries.name AS country_name',
            'states.name AS state_name',
            'cities.name AS city_name'
        ])
        ->join('countries', 'students.country', '=', 'countries.id')
        ->join('states', 'students.state', '=', 'states.id')
        ->join('cities', 'students.city', '=', 'cities.id')
        ->orderBy('students.id', 'asc')
        ->get();

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
