<?php

namespace App\Http\Livewire;

use App\Models\Astuce;
use App\Models\Entreprise;
use App\Models\Messenger;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Commercial extends Component
{
    use WithFileUploads, WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    public $etat = "list";
    public $title= "Liste des commerciaux";
    public $astuce;
    public $user;
    public $profil;
    public $idDeleting;
    protected $listeners = ['remove'];

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

    protected $rules = [
        'form.prenom' => 'required|string',
        'form.nom' => 'required|string',
        'form.tel' => ['required', 'min:9', 'max:9', 'regex:/^[33|70|75|76|77|78]+[0-9]{7}$/'],
        'form.sexe' => 'required|string',
        'form.email' => ['required', 'email', 'unique:users,email'],
        'form.password' => 'required|string|min:6|confirmed',
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
    ];

    public function changeEtat($etat){
        $this->etat = $etat;
        if($this->etat==='add'){
            $this->title = "Formulaire d'ajout commercial";
        }
        $this->formInit();
    }

    public function getCommercial($id)
    {
        $this->formInit();
        $this->user = User::where('id', $id)->first();

        $this->form['prenom'] = $this->user->prenom;
        $this->form['nom'] = $this->user->nom;
        $this->form['email'] = $this->user->email;
        $this->form['sexe'] = $this->user->sexe;
        $this->form['tel'] = $this->user->tel;
        $this->form['entreprise_id'] = $this->user->entreprise_id;
        $this->title = "Information utilisateur";
        $this->etat = "info";
    }

    public function editPassword(){
        if(isset($this->user->id) && $this->user->id !== null){
            $this->validate([
                'form.password' => 'required|confirmed'
            ]);

            $user = User::where('id', $this->user->id)->first();

            $user->password = Hash::make($this->form['password']);

            $user->save();

            $this->astuce->addHistorique("Changement de mot de passe d'un commercial", "update");

            $this->getCommercial($user->id);

            $this->dispatchBrowserEvent('passwordEditSuccessful');

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

            $this->astuce->addHistorique("Changement de l'image de profil d'un utilisateur", "update");

            $this->getCommercial($this->user->id);
            $this->dispatchBrowserEvent('profilEditSuccessful');
        }
    }



    public function delete($id)
    {
        $this->idDeleting = $id;
        $this->alertConfirm();
    }

    public function alertConfirm()
    {
        $this->dispatchBrowserEvent('swal:confirm', [
                'type' => 'warning',
                'message' => 'Êtes-vous sûr?',
                'text' => 'Vouliez-vous supprimer?'
            ]);
    }

    public function remove()
    {

        $user = User::where('id', $this->idDeleting)->first();
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'Commercial!',
                'text' => 'Suppression avec succès.'
            ]);

            $user->delete();
            return redirect()->to('/commerciaux');
            $this->etat= "list";

    }


    public function store()
    {
        if(isset($this->user->id) && $this->user->id !== null){
            $user = User::where('id', $this->user->id)->first();
            $this->validate([
                'form.email' => ["unique:users,email,$user->id"],
                'form.prenom' => 'required|string',
                'form.nom' => 'required|string',
                'form.tel' => ['required', 'min:9', 'max:9', 'regex:/^[33|70|75|76|77|78]+[0-9]{7}$/'],
                'form.sexe' => 'required|string',
            ]);

            $user->email = ucfirst($this->form['email']);
            $user->prenom = ucfirst($this->form['prenom']);
            $user->nom = $this->form['nom'];
            $user->tel = $this->form['tel'];
            $user->entreprise_id = Auth()->user()->entreprise_id;

            $user->save();
            $this->astuce->addHistorique("Mis à jour des informations d'un commercial", "update");

            $this->dispatchBrowserEvent("updateSuccessful");
            $this->getCommercial($user->id);

        }else{
            // Traitement ajout utilisateur
            $this->validate();

            if(empty($this->form['sexe'])){
                $this->dispatchBrowserEvent("sexEmpty");
            }

            $this->form['role']="Commercial";
            $this->form['fonction']="Commercial";
            $this->form['entreprise_id'] = Auth()->user()->entreprise_id;
            
            if($this->form['role'] === "Commercial" && $this->form['entreprise_id'] === null){
                $this->dispatchBrowserEvent("adminNoCompany");
            }else{
                
                User::create([
                    'nom'=>$this->form['nom'],
                    'prenom'=>$this->form['prenom'],
                    'role'=>$this->form['role'],
                    'email'=>$this->form['email'],
                    'tel'=>$this->form['tel'],
                    'fonction'=>$this->form['fonction'],
                    'sexe'=>$this->form['sexe'],
                    'profil' => $this->form['sexe'] === "Homme" ? "user-male.png" : "user-female.png",
                    'entreprise_id'=> $this->form['entreprise_id'],
                    'password'=>Hash::make($this->form['password']),
                ]);

                $this->astuce->addHistorique("Ajout d'un commercial".$this->form['role'], "add");

                $this->dispatchBrowserEvent("addSuccessful");
                $this->formInit();
                $this->etat="list";
            }

        }

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

        $this->user = null;

    }

    public function changeEvent($value){
        $this->user = User::where('id', $value)->first();
    }   

    public function exist(){
        if(isset($this->user->id) && $this->user->id !== null){
            $user = User::where('id', $this->user->id)->first();

            $user->role = "Commercial";

            $user->save();
            $this->astuce->addHistorique("Mis à jour des informations d'un utilisateur", "update");

            $this->dispatchBrowserEvent("updateSuccessful");
            $this->etat="list";
        }
    }

    public function render()
    {
        $this->astuce = new Astuce();
        
        return view('livewire.admin.commercial',[
            'entreprises' => Entreprise::orderBy('nom', 'ASC')->get(),
            'commerciaux' => $this->astuce->commercials(),
            'employes' => $this->astuce->employes(),
        ])->layout('layouts.app', [
            'title' => "Commerciaux",
            "page" => "commercial",
            "icon" => "fa fa-user-circle",
            "notification" => Messenger::where('recepteur_id', Auth()->user()->id)->where("seen", 1)->count(),
        ]);
    }

    public function mount(){
        if(!Auth::user()){
            return redirect(route('login'));
        }
        if (!Auth()->user()->isOpen()) {
            return redirect(route('home'));
        }
    }
}
