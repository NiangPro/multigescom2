<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    use HasFactory;

    protected $table = "taches";

    protected $fillable = [
        'titre',
        'assignation',
        'date_debut',
        'date_fin',
        'description',
        'priorite',
        'statut',
        'entreprise_id'
    ];

    public function employe()
    {
        return $this->belongsTo(User::class, "assignation");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, "entreprise_id");
    }

}
