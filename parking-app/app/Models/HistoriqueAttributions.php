<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriqueAttributions extends Model
{
    protected $fillable = ['user_id', 'parking_space_id', 'date_attribution'];
    protected $table = 'historique_attributions';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parking_space()
    {
        return $this->belongsTo(ParkingSpace::class);
    }
}
