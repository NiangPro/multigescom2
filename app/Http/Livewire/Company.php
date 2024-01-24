<?php

namespace App\Http\Livewire;

use App\Models\Astuce;
use App\Models\Entreprise;
use App\Models\Messenger;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Company extends Component
{
    use WithFileUploads, WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['remove'];

    public $title;
    public $astuce;
    public $etat;
    public $profil;
    public $idDeleting;
    public $entreprise;

    public $form = [
        'nom' => '',
        'tel' => '',
        'adresse' => '',
        'email' => '',
        'sigle' => '',
        'statut' => '',
        'fermeture' => '',
    ];

    protected $rules = [
        'form.nom' => "required|string",
        'form.tel' => ['required', 'min:9', 'max:9', 'regex:/^[33|70|75|76|77|78]+[0-9]{7}$/'],
        'form.adresse' => "required|string",
        'form.email' => "required|email",
        'form.sigle' => 'required|string|max:3|unique:entreprises,sigle',
        'form.fermeture' => 'required|date',
    ];

    protected $messages = [
        'form.nom.required' => 'Le nom est requis',
        'form.sigle.required' => 'Le sigle est requis',
        'form.email.required' => 'L\'email est requis',
        'form.email.email' => 'L\'email est invalid',
        'form.sigle.max' => 'Maximum 3 caractères',
        'form.sigle.unique' => 'Ce cigle existe dèjà',
        'form.tel.required' => 'Le telephone est requis',
        'form.tel.max' => 'Maximum 9 chiffres',
        'form.tel.min' => 'Minimum 9 chiffres',
        'form.tel.regex' => 'Le telephone est invalid',
        'form.fermeture.required' => 'La date de fermeture est requise',
    ];

    public function userMessage($id_user){
        session()->put('id_admin', $id_user);
        return redirect()->to('/messages');
    }

    public function add()
    {
        $this->init();

        $this->etat = "add";
        $this->title = "Ajout Entreprise";
    }

    public function getId($id)
    {
        $this->idDeleting = $id;
        $this->alertConfirm();
        // dd($this->idDeleting);
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
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Entreprise!',
            'text' => 'Suppression avec succès.'
        ]);

        $company = Entreprise::where('id', $this->idDeleting)->first();
        $company->delete();
        $this->astuce->addHistorique('Suppression d\'une entreprise', "delete");

        $this->dispatchBrowserEvent('deleteSuccessful');
    }

    public function editProfil()
    {
        if ($this->profil) {
            $this->validate([
                'profil' => 'image'
            ]);
            $imageName = 'company'.\md5($this->entreprise->id).'.jpg';

            $this->profil->storeAs('public/images', $imageName);

            $company = Entreprise::where('id', $this->entreprise->id)->first();

            $company->profil = $imageName;
            $company->save();


            $this->astuce->addHistorique('Changement de logo d\'une entreprise', "update");

            $this->profil = "";
            $this->info($company->id);
            $this->dispatchBrowserEvent('profilEditSuccessful');
        }
    }

    public function closeOrOpen($id)
    {
        $company = Entreprise::where('id', $id)->first();

        if ($company->statut === 1) {
            $company->statut = 0;

            $this->astuce->addHistorique('Fermeture d\'une entreprise', "update");

            $this->dispatchBrowserEvent('closeSuccessful');
        } else {
            $company->statut = 1;
            $this->astuce->addHistorique('Ouverture d\'une entreprise', "update");

            $this->dispatchBrowserEvent('openSuccessful');
        }

        $company->save();

    }

    public function info($id)
    {
        $this->init();

        $this->etat = "info";
        $this->title = "Information Entreprise";

        $this->entreprise = Entreprise::where('id', $id)->first();

        $this->form['nom'] = $this->entreprise->nom;
        $this->form['tel'] = $this->entreprise->tel;
        $this->form['adresse'] = $this->entreprise->adresse;
        $this->form['sigle'] = $this->entreprise->sigle;
        $this->form['email'] = $this->entreprise->email;
        $this->form['statut'] = $this->entreprise->statut;
        $this->form['fermeture'] = $this->entreprise->fermeture;
    }

    public function store()
    {
        if(isset($this->entreprise->id) && $this->entreprise->id !== null){
            $company = Entreprise::where('id', $this->entreprise->id)->first();
            $this->validate([
                'form.nom' => "required|string",
                'form.tel' => ['required', 'min:9', 'max:9', 'regex:/^[33|70|75|76|77|78]+[0-9]{7}$/'],
                'form.adresse' => "required|string",
                'form.email' => "required|email",
                'form.sigle' => "required|string|max:3|unique:entreprises,sigle,$company->id",
                'form.fermeture' => 'required|date',
            ]);

            $company->nom = ucfirst($this->form['nom']) ;
            $company->sigle = ucfirst($this->form['sigle']);
            $company->fermeture = $this->form['fermeture'];
            $company->tel = $this->form['tel'];
            $company->adresse = $this->form['adresse'];
            $company->email = $this->form['email'];

            $company->save();

            $this->astuce->addHistorique("Mis à jour d'une entreprise", "update");
            $this->dispatchBrowserEvent('updateSuccessful');
            $this->info($company->id);

        }else{
            $this->validate();

            Entreprise::create([
                'nom' => ucfirst($this->form['nom']) ,
                'sigle' => ucfirst($this->form['sigle']),
                'fermeture' => $this->form['fermeture'],
                'tel' => $this->form['tel'],
                'email' => $this->form['email'],
                'adresse' => $this->form['adresse'],
                'profil' => "company.png",
                'statut' => 1
            ]);

            $this->astuce->initStaticData();

            $this->astuce->addHistorique("Ajout d'une entreprise", "add");

            $this->dispatchBrowserEvent('addSuccessful');
            $this->init();
            return redirect()->to('/entreprises');

        }
    }

    public function render()
    {
        $this->astuce = new Astuce();
        return view('livewire.superAdmin.company', [
            'companies' => Entreprise::orderBy('nom', 'ASC')->paginate(8)
        ])->layout('layouts.app', [
            'title' => "Les Entreprises",
            "page" => "entreprise",
            "icon" => "fas fa-th-large",
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

        $this->init();
    }

    public function init()
    {

        $this->etat = "list";
        $this->title = "Listes des Entreprises";

        $this->form['nom'] = '';
        $this->form['tel'] = '';
        $this->form['adresse'] = '';
        $this->form['sigle'] = '';
        $this->form['statut'] = '';
        $this->form['fermeture'] = '';

        $this->profil = "";
    }
}
