<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevisItem extends Model
{
    use HasFactory;

    protected $table = "devis_items";

    protected $fillable = [
        'nom',
        'description',
        'montant',
        'taxe',
        'quantite',
        'devis_id',
    ];

    public function devis()
    {
        return $this->belongsTo(Devis::class, "devis_id");
    }
}
