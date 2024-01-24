<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = "clients";

    protected $fillable =[
        'nom',
        'adresse',
        'tel',
        'email',
        'country_id',
        'entreprise_id'
    ];

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, "entreprise_id");
    }

    public function pays()
    {
        return $this->belongsTo(Country::class, "country_id");
    }
}
