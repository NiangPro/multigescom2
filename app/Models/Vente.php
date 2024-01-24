<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    use HasFactory;

    protected $table = "ventes";

    protected $fillable = [
        'date',
        'client_id',
        'employe_id',
        'description',
        'montant',
        'remise',
        'statut',
        'entreprise_id',
    ];

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, "entreprise_id");
    }

    public function employe()
    {
        return $this->belongsTo(User::class, "employe_id");
    }

    public function client()
    {
        return $this->belongsTo(Client::class, "client_id");
    }

    public function ventes_items()
    {
        return $this->hasMany(VenteItem::class);
    }
}
