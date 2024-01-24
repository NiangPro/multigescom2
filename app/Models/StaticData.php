<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaticData extends Model
{
    use HasFactory;

    protected $table ="static_data";

    protected $fillable = [
        'entreprise_id',
        'type',
        'valeur',
        'statut',
    ];

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, "entreprise_id");
    }
}
