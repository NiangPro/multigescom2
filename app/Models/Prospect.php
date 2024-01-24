<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prospect extends Model
{
    use HasFactory;

    protected $table = "prospects";

    protected $fillable = [
        'nom',
        'email',
        'tel',
        'source',
        'assignation',
        'country_id',
        'adresse',
        'entreprise_id'
    ];

    public function pays()
    {
        return $this->belongsTo(Country::class, "country_id");
    }

    public function employe()
    {
        return $this->belongsTo(User::class, "assignation");
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, "entreprise_id");
    }
}
