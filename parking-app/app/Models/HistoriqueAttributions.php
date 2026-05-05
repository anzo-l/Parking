<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriqueAttributions extends Model
{
    protected $fillable = ['utilisateur_id', 'parking_space_id', 'date_debut', 'date_fin'];
    protected $table = 'historique_attributions';

    public function user()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    public function parking_space()
    {
        return $this->belongsTo(ParkingSpace::class);
    }
}
