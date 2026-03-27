<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GymClass extends Model
{
    protected $fillable = ['nombre', 'instructor', 'capacidad_maxima', 'horario'];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
