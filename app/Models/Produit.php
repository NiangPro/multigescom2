<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $table = "produits";

    protected $fillable=[
        'nom',
        'description',
        'type',
        'tarif',
        'image_produit',
        'taxe',
        'entreprise_id'
    ];

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, "entreprise_id");
    }
}
