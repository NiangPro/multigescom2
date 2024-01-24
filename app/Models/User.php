<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'prenom',
        'nom',
        'entreprise_id',
        'sexe',
        'profil',
        'fonction',
        'country_id',
        'tel',
        'role',
        'adresse',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function messages()
    {
        return $this->hasMany(Messenger::class, "recepteur_id" || "emetteur_id");
    }

    public function todolists()
    {
        return $this->hasMany(Todolist::class);
    }

    public function contrats()
    {
        return $this->hasMany(Contrat::class);
    }

    public function taches()
    {
        return $this->hasMany(Tache::class);
    }

    public function propects()
    {
        return $this->hasMany(Prospect::class);
    }

    public function pays()
    {
        return $this->belongsTo(Country::class, "country_id");
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, "entreprise_id");
    }

    public function historiques()
    {
        return $this->hasMany(Historique::class);
    }

    public function isSuperAdmin()
    {
        return Auth::user()->role === "Super Admin";
    }

    public function isAdmin()
    {
        return Auth::user()->role === "Admin";
    }

    public function isComptable()
    {
        return Auth::user()->role === "Comptable";
    }

    public function isCommercial()
    {
        return Auth::user()->role === "Commercial";
    }

    public function isOpen()
    {
        if($this->isSuperAdmin()){
            return true;
        }else{
            if($this->entreprise->statut === 1){
                return true;
            }
            return false;
        }
    }
}
