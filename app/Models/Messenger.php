<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messenger extends Model
{
    use HasFactory;

    protected $table = "messengers";

    protected $fillable = [
        "emetteur_id",
        "recepteur_id",
        "text",
        "seen",
        "statut"
    ];

    public function emetteur()
    {
        return $this->belongsTo(User::class, "emetteur_id");
    }

    public function recepteur()
    {
        return $this->belongsTo(User::class, "recepteur_id");
    }
}
