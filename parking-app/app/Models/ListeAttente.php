<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListeAttente extends Model
{
    protected $fillable = ['user_id', 'position', 'date_inscription'];
    protected $table = 'liste_attentes';

    protected function casts(): array
    {
        return [
            'date_inscription' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
