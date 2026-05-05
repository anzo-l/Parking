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

    public function users()
    {
        return $this->hasMany(User::class, 'current_parking_space_id');
    }

    public function historique_attributions()
    {
        return $this->hasMany(HistoriqueAttributions::class);
    }
}
