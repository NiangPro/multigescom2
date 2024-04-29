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

class Users extends Component
{
    use WithFileUploads, WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $title = "Liste des super administrateurs";
    public $etat = "admin";
    public $profil;
    public $back = [
        'title' => '',
        'etat' => '',
    ];
    public $astuce;
    public $user;
    public $idDeleting;
    public $role = "Super Admin";

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

    public $todoForm=[
        'id'=>null,
        'titre'=>'',
        'date'=>'',
        'statut'=>'',
        'user_id'=>null
    ];

    protected $rules = [
        'form.prenom' => 'required|string',
        'form.nom' => 'required|string',
        'form.role' => 'required|string',
        'form.tel' => ['required', 'min:9', 'max:9', 'regex:/^[33|70|75|76|77|78]+[0-9]{7}$/'],
        'form.sexe' => 'required|string',
        'form.entreprise_id' => 'nullable',
        'form.email' => ['required', 'email', 'unique:users,email'],
        'form.password' => 'required|string|min:6|confirmed',
    ];

    protected $messages = [
        'form.nom.required' => 'Le nom est requis',
        'form.prenom.required' => 'Le nom est requis',
        'form.entreprise_id.required' => 'Le champ entreprise est requis',
        'form.role.required' => 'Le role est requis',
        'form.email.required' => "L'email est requis",
        'form.email.unique' => "L'email existe deja",
        'form.password.required' => "Le mot de passe est requis",
        'form.password.confirmed' => "Les deux mots de passe sont differents",
        'form.password.min' => "Minimum 6 caracteres",
        'form.sexe.max' => 'Maximum 3 caractères',
        'form.tel.required' => 'Le telephone est requis',
        'form.tel.max' => 'Maximum 9 chiffres',
        'form.tel.min' => 'Minimum 9 chiffres',
        'form.tel.regex' => 'Le telephone est invalid',
        'todoForm.titre' => 'Le titre est requis',
        'todoForm.date' => 'La date est requise',
        'todoForm.statut' => 'Le statut est requis',
    ];

    protected $listeners = ['remove'];

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
        if ($user->role === "Admin"){
            $countAdmin = User::where("role", "Admin")->where("entreprise_id", $user->entreprise_id)->count();
            // dd($countAdmin);
        }else{
            $countAdmin = User::where("role", "Super Admin")->count();
        }

        if ($countAdmin <= 1) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Entreprise!',
                'text' => 'Impossible de supprimer tous les utilisateurs.'
            ]);
        }else{

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'Entreprise!',
                'text' => 'Suppression avec succès.'
            ]);

            $user->delete();
        }

    }

    public function superAdmin()
    {
        $this->title = "Liste des super administrateurs";
        $this->etat = "superAdmin";
        $this->formInit();

    }

    public function admin()
    {
        $this->title = "Liste des administrateurs";
        $this->etat = "admin";
        $this->formInit();

    }

    public function add()
    {
        $this->title = "Formulaire d'ajout administrateur ou super adminstrateur";
        $this->etat = "add";
        $this->formInit();
    }

    public function info($id)
    {
        $this->formInit();
        $this->user = User::where('id', $id)->first();

        $this->form['prenom'] = $this->user->prenom;
        $this->form['nom'] = $this->user->nom;
        $this->form['role'] = $this->user->role;
        $this->form['email'] = $this->user->email;
        $this->form['sexe'] = $this->user->sexe;
        $this->form['tel'] = $this->user->tel;
        $this->form['entreprise_id'] = $this->user->entreprise_id;

        $this->back['title'] = $this->title;
        $this->back['etat'] = $this->etat;
        $this->title = "Information utilisateur";
        $this->etat = "info";
    }

    public function back()
    {
        $this->title = $this->back['title'];
        $this->etat = $this->back['etat'];
    }

    public function editPassword(){
        if(isset($this->user->id) && $this->user->id !== null){
            $this->validate([
                'form.password' => 'required|confirmed'
            ]);

            $user = User::where('id', $this->user->id)->first();

            $user->password = Hash::make($this->form['password']);

            $user->save();

            $this->astuce->addHistorique("Changement de mot de passe d'un utilisateur", "update");

            $this->info($user->id);

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

            $this->info($this->user->id);
            $this->dispatchBrowserEvent('profilEditSuccessful');
        }
    }

    public function delete($id)
    {
        $this->idDeleting = $id;
        $this->alertConfirm();
    }

    public function changeEvent(){
        $this->role = $this->form['role'];
        // dd($this->role);
    }

    public function store()
    {
        
        if(isset($this->user->id) && $this->user->id !== null){
            $user = User::where('id', $this->user->id)->first();
            $this->validate([
                'form.email' => ["unique:users,email,$user->id"],
                'form.prenom' => 'required|string',
                'form.nom' => 'required|string',
                'form.entreprise_id' => 'required',
                'form.tel' => ['required', 'min:9', 'max:9', 'regex:/^[33|70|75|76|77|78]+[0-9]{7}$/'],
            ]);

            $user->email = $this->form['email'];
            $user->prenom = ucfirst($this->form['prenom']);
            $user->nom = ucfirst($this->form['nom']);
            $user->tel = $this->form['tel'];
            $user->entreprise_id = $this->form['entreprise_id'];

            $user->save();
            $this->astuce->addHistorique("Mis à jour des informations d'un utilisateur", "update");

            $this->dispatchBrowserEvent("updateSuccessful");
            $this->info($user->id);

        }else{
            // Traitement ajout utilisateur
            if($this->role =="Super Admin"){
                $this->form['entreprise_id'] = Auth()->user()->entreprise_id;
            }
            if($this->form["role"] == "Admin") {
                $this->validate(["form.entreprise_id" => "required"]);
            }

            $this->validate();

            if(empty($this->form['sexe'])){
                $this->dispatchBrowserEvent("sexEmpty");
            }
            
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

            $this->astuce->addHistorique("Ajout ".$this->form['role'], "add");
            $this->dispatchBrowserEvent("addSuccessful");
            return redirect()->to('/utilisateurs');
            $this->formInit();        
                
           

        }

    }

    public function render()
    {
        $this->astuce = new Astuce();

       return view('livewire.superAdmin.users',[
                'entreprises' => Entreprise::orderBy('nom', 'ASC')->get(),
                'superAdmins' => $this->astuce->superAdmins(),
                'admins' => $this->astuce->admins(),
            ])->layout('layouts.app',[
                'title' => 'Les Utilisateurs',
                "page" => "users",
                "icon" => "fa fa-users-cog",
                "notification" => Messenger::where('recepteur_id', Auth()->user()->id)->where("seen", 1)->count(),
            ]);
    }

    public function mount(){
        if(!Auth::user()){
            return redirect(route('login'));
        }

        if(!Auth::user()->isSuperAdmin()){
            return redirect(route("home"));
        }
        if (!Auth()->user()->isOpen()) {
            return redirect(route('home'));
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
}



