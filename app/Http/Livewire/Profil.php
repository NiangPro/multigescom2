<?php

namespace App\Http\Livewire;

use App\Models\Astuce;
use App\Models\Entreprise;
use App\Models\Messenger;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profil extends Component
{
    use WithFileUploads;

    public $user;
    public $astuce;
    public $profil;
    public $etat = "info";

    public $form = [
        'id' => null,
        'prenom' => "",
        'nom' => "",
        'role' => "",
        'sexe' => "",
        'tel' => "",
        'email' => "",
        'profil' => "",
        'entreprise_id' => null,
        'password' => "",
        'password_confirmation' => "",
    ];

    protected $rules = [
        'form.prenom' => 'required|string',
        'form.nom' => 'required|string',
        'form.role' => 'required|string',
        'form.tel' => ['required', 'min:9', 'max:9', 'regex:/^[33|70|75|76|77|78]+[0-9]{7}$/'],
        'form.sexe' => 'required|string',
        'form.entreprise_id' => 'nullable|string',
        'form.email' => ['required', 'email', 'unique:users,email'],
        'form.password' => 'required|string|min:6|confirmed',
    ];

    protected $messages = [
        'form.nom.required' => 'Le nom est requis',
        'form.prenom.required' => 'Le nom est requis',
        'form.role.required' => 'Le role est requis',
        'form.email.required' => "L'email est requis",
        'form.email.unique' => "L'email existe deja",
        'form.password.required' => "Le mot de passe est requis",
        'form.password.confirmed' => "Les deux mots de passe sont differents",
        'form.sexe.max' => 'Maximum 3 caractères',
        'form.tel.required' => 'Le telephone est requis',
        'form.tel.max' => 'Maximum 9 chiffres',
        'form.tel.min' => 'Minimum 9 chiffres',
        'form.tel.regex' => 'Le telephone est invalid',
    ];

    public function store()
    {
        if(isset($this->user->id) && $this->user->id !== null){
            $user = User::where('id', $this->user->id)->first();
            $this->validate([
                'form.email' => ["unique:users,email,$user->id"],
                'form.prenom' => 'required|string',
                'form.nom' => 'required|string',
                'form.tel' => ['required', 'min:9', 'max:9', 'regex:/^[33|70|75|76|77|78]+[0-9]{7}$/'],
                'form.entreprise_id' => 'nullable|string',
            ]);

            $user->email = ucfirst($this->form['email']);
            $user->prenom = ucfirst($this->form['prenom']);
            $user->nom = $this->form['nom'];
            $user->tel = $this->form['tel'];
            $user->entreprise_id = $this->form['entreprise_id'];

            $user->save();
            $this->astuce->addHistorique("Mis à jour du profil", "update");

            $this->mount();
            $this->dispatchBrowserEvent("updateSuccessful");

        }
    }


    public function editProfil()
    {
        if ($this->profil) {
            $this->validate([
                'profil' => 'image'
            ]);
            $imageName = 'user'.\md5($this->user->id).'.jpg';

            $this->profil->storeAs('public/images', $imageName);

            $user = User::where('id', $this->user->id)->first();

            $user->profil = $imageName;
            $user->save();

            $this->profil = "";

            $this->astuce->addHistorique("Mis à jour de l'image de profil", "update");

            $this->dispatchBrowserEvent('profilEditSuccessful');
            $this->mount();
        }
    }

    public function render()
    {
        $this->astuce = new Astuce();

        return view('livewire.profil', [
            'entreprises' => Entreprise::orderBy('nom', 'ASC')->get()
        ])->layout('layouts.app', [
            'title' => "Mon Profil",
            "page" => "profil",
            "icon" => "fa fa-user-circle",
            "notification" => Messenger::where('recepteur_id', Auth()->user()->id)->where("seen", 1)->count(),

        ]);
    }

    public function mount(){
        if(!Auth::user()){
            return redirect(route('login'));
        }

        $this->user = Auth::user();

        $this->form['prenom'] = $this->user->prenom;
        $this->form['nom'] = $this->user->nom;
        $this->form['role'] = $this->user->role;
        $this->form['email'] = $this->user->email;
        $this->form['sexe'] = $this->user->sexe;
        $this->form['tel'] = $this->user->tel;
        $this->form['entreprise_id'] = $this->user->entreprise_id;

    }
}
