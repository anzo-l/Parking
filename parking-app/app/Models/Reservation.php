<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['user_id', 'parking_space_id', 'date_debut', 'date_fin', 'statut'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parking_space()
    {
        return $this->belongsTo(ParkingSpace::class);
    }
}
