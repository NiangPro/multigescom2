<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenteItem extends Model
{
    use HasFactory;

    protected $table = "vente_items";

    protected $fillable = [
        'nom',
        'description',
        'montant',
        'taxe',
        'quantite',
        'vente_id',
    ];

    public function ventes()
    {
        return $this->belongsTo(Vente::class, "vente_id");
    }
}
