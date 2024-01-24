<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reunion extends Model
{
    use HasFactory;

    protected $table = "reunions";

    protected $fillable = [
        'titre',
        'description',
        'date',
        'entreprise_id'
    ];

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, "entreprise_id");
    }
}
