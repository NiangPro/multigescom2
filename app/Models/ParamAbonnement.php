<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParamAbonnement extends Model
{
    use HasFactory;

    protected $table = "param_abonnements";

    protected $fillable = [
        "mensuel",
        "annuel",
    ];


}
