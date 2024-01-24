<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    use HasFactory;

    protected $table = "depenses";

    protected $fillable = [
        'categorie',
        'mode_paiement',
        'description',
        'date',
        'montant',
        'entreprise_id'
    ];

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, "entreprise_id");
    }
}
