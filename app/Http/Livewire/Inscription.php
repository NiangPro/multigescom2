<?php

namespace App\Http\Livewire;

use App\Models\Astuce;
use App\Models\Entreprise;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Support\Carbon;

class Inscription extends Component
{
    public $astuce;
    public $date_fermeture;
    public $form = [
        'id' => null,
        'prenom' => "",
        'nom' => "",
        'role' => "",
        'sexe' => "",
        'tel' => "",
        'fonction' => "",
        'email' => "",
        'profil' => "",
        'entreprise_id' => null,
        'password' => "",
        'password_confirmation' => "",
    ];

    public $form2 = [
        'nom' => '',
        'tel' => '',
        'adresse' => '',
        'email' => '',
        'sigle' => '',
        'statut' => '',
        'fermeture' => '',
    ];

    protected $rules = [
        'form.prenom' => 'required|string',
        'form.nom' => 'required|string',
        'form.tel' => ['required', 'min:9', 'max:9', 'regex:/^[33|70|75|76|77|78]+[0-9]{7}$/'],
        'form.sexe' => 'required|string',
        'form.entreprise_id' => 'nullable|string',
        'form.email' => ['required', 'email', 'unique:users,email'],
        'form.password' => 'required|string|min:6|confirmed',
        'form2.nom' => "required|string",
        'form2.tel' => ['required', 'min:9', 'max:9', 'regex:/^[33|70|75|76|77|78]+[0-9]{7}$/'],
        'form2.adresse' => "required|string",
        'form2.email' => "required|email",
        'form2.sigle' => 'required|string|max:3|unique:entreprises,sigle',
        'form2.fermeture' => 'required|date',
    ];

    protected $messages = [
        'form.nom.required' => 'Le nom est requis',
        'form.prenom.required' => 'Le nom est requis',
        'form.email.required' => "L'email est requis",
        'form.email.unique' => "L'email existe deja",
        'form.password.required' => "Le mot de passe est requis",
        'form.password.confirmed' => "Les deux mots de passe sont differents",
        'form.password.min' => "Minimum 6 caracteres",
        'form.sexe.max' => 'Maximum 3 caractères',
        'form.sexe.required' => 'Le sexe est requis',
        'form.tel.required' => 'Le telephone est requis',
        'form.tel.max' => 'Maximum 9 chiffres',
        'form.tel.min' => 'Minimum 9 chiffres',
        'form.tel.regex' => 'Le telephone est invalid',
        'form2.nom.required' => 'Le nom est requis',
        'form2.sigle.required' => 'Le sigle est requis',
        'form2.email.required' => 'L\'email est requis',
        'form2.email.email' => 'L\'email est invalid',
        'form2.sigle.max' => 'Maximum 3 caractères',
        'form2.sigle.unique' => 'Ce cigle existe dèjà',
        'form2.tel.required' => 'Le telephone est requis',
        'form2.tel.max' => 'Maximum 9 chiffres',
        'form2.tel.min' => 'Minimum 9 chiffres',
        'form2.tel.regex' => 'Le telephone est invalid',
        'form2.fermeture.required' => 'La date de fermeture est requise',
    ];

    public function mount()
    {
        // la date fermeture
        $date = Carbon::now();
        $date->addMonth();
        $this->date_fermeture = $date->toDateString();
    }

    public function inscrire(){
        $this->form['role']="Admin";
        if(empty($this->form['sexe'])){
            $this->dispatchBrowserEvent("sexEmpty");
        }
        // sigle
        $nombre = Entreprise::count()+1;
        $sigle = substr(ucfirst($this->form2['nom']), 0,2);
        $this->form2['sigle'] = $sigle.$nombre;

        $this->form2['fermeture']=$this->date_fermeture;

        $this->validate();

        // creation entreprise
        Entreprise::create([
            'nom' => ucfirst($this->form2['nom']) ,
            'sigle' => $this->form2['sigle'],
            'fermeture' => $this->form2['fermeture'],
            'tel' => $this->form2['tel'],
            'email' => $this->form2['email'],
            'adresse' => $this->form2['adresse'],
            'profil' => "company.png",
            'statut' => 1
        ]);

        $entreprise = Entreprise::where("sigle", $this->form2['sigle'])->first();
        $this->astuce->initStaticData();

        // creation admin
        $this->form['entreprise_id'] = $entreprise->id;

        if($this->form['entreprise_id'] === null){
            $this->dispatchBrowserEvent("adminNoCompany");
        }else{
            
            User::create([
                'nom'=>$this->form['nom'],
                'prenom'=>$this->form['prenom'],
                'role'=>$this->form['role'],
                'email'=>$this->form['email'],
                'tel'=>$this->form['tel'],
                'sexe'=>$this->form['sexe'],
                'profil' => $this->form['sexe'] === "Homme" ? "user-male.png" : "user-female.png",
                'entreprise_id'=>$this->form['entreprise_id'],
                'password'=>Hash::make($this->form['password']),
            ]);
        }
        $user = User::where("email", $this->form['email'])->first();
        
        $this->astuce->addHistoriqueExtern("Ajout d'une entreprise", "add", $user->id);
        $this->astuce->addHistoriqueExtern("Ajout ".$this->form['role'], "add", $user->id);
        $this->dispatchBrowserEvent("addSuccessful");
        return redirect(route('login'));
        $this->formInit();

    }

    protected function formInit()
    {
        $this->form['id'] = null;
        $this->form['prenom'] = "";
        $this->form['nom'] = "";
        $this->form['role'] = "";
        $this->form['sexe'] = "";
        $this->form['tel'] = "";
        $this->form['email'] = "";
        $this->form['profil'] = "";
        $this->form['entreprise_id'] = null;
        $this->form['password'] = "";
        $this->form['password_confirmation'] = "";
        $this->form2['nom'] = '';
        $this->form2['tel'] = '';
        $this->form2['adresse'] = '';
        $this->form2['sigle'] = '';
        $this->form2['fermeture'] = '';
    }

    public function render()
    {
        $this->mount();
        $this->astuce = new Astuce();
        return view('livewire.inscription')->layout('layouts.app');
    }
}
