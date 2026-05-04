<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingSpace extends Model
{
    protected $fillable = ['numero_place', 'disponible', 'type_place'];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
