<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ['name', 'country_id'];

    /**
     * A state belongs to a country.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * A state has many cities.
     */
    public function cities()
    {
        return $this->hasMany(City::class);
    }

    /**
     * A state has many students.
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public static function allStates($countryId) {
        $states = self::where('country_id', $countryId)->get();
        if($states->isNotEmpty()) {
            return $states;
        } else {
            return null;
        }
    }
}