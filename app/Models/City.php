<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name', 'state_id'];

    /**
     * A city belongs to a state.
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * A city has many students.
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public static function allCities($stateId) {
        $cities = self::where('state_id', $stateId)->get();
        
        if($cities->isNotEmpty()) {
            return $cities;
        } else {
            return null;
        }
    }
}