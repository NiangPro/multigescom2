<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devis extends Model
{
    use HasFactory;

    protected $table = "devis";

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

    public function devis_items()
    {
        return $this->hasMany(DevisItem::class);
    }
}
