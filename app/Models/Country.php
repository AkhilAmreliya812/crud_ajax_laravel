<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['name'];

    /**
     * A country has many states.
     */
    public function states()
    {
        return $this->hasMany(State::class);
    }

    /**
     * A country has many students.
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public static function allCountries() {
        $countries = self::all();

        return $countries;
    }
}