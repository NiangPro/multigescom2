<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historique extends Model
{
    use HasFactory;

    protected $table = "historiques";

    protected $fillable = [
        'description',
        'type',
        'date',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
