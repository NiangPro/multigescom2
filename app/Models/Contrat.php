<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    use HasFactory;

    protected $table = "contrats";

    protected $fillable = [
        'titre',
        'fichier',
        'employe_id'
    ];

    public function employe()
    {
        return $this->belongsTo(User::class, "employe_id");
    }
}
