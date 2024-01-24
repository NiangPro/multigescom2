<?php

namespace App\Http\Livewire;

use App\Models\Astuce;
use App\Models\Contrat;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Country;
use App\Models\Employe;
use App\Models\Messenger;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Employes extends Component
{
    use WithFileUploads, WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $etat = "list";
    public $statut= "info";
    public $staticData;
    public $astuce;
    public $current_employe;
    public $profil;
    public $file_name;
    public $typeDeleted;
    public $contrats;
    public $document;
    protected $listeners = ['remove'];

    public $form = [
        'prenom' => '',
        'nom' => '',
        'email' => '',
        'tel' => '',
        'fonction' => '',
        'adresse' => '',
        'sexe' => '',
        'pays' => '',
        'id' => null,
    ];

    public $contratForm = [
        'id'=> null,
        'titre'=> '',
        'fichier'=> '',
        'employe_id'=> '',
    ];

    protected $rules = [
        'form.prenom' => 'required|string',
        'form.nom' => 'required|string',
        'form.email' => 'required|string',
        'form.tel' => ['required', 'min:9', 'max:9', 'regex:/^[33|70|75|76|77|78]+[0-9]{7}$/'],
        'form.fonction' => 'required|string',
        'form.adresse' => 'required|string',
        'form.sexe' => 'required|string',
        'form.pays' => 'required|string',
    ];

    protected  $messages = [
        'form.prenom.required' => 'Le prenom est requis',
        'form.nom.required' => 'Le nom est requis',
        'form.email.required' => 'le mail est requis',
        'form.tel.required' => 'Le telephone est requis',
        'form.tel.regex' => 'Le n° de telephone est invalide',
        'form.tel.min' => 'Le n° de telephone doit avoir au minimum 9 chiffres',
        'form.tel.max' => 'Le n° de telephone doit avoir au maximum 9 chiffres',
        'form.fonction.required' => 'La fonction est requise',
        'form.adresse.required' => 'L\'adresse est requis',
        'form.sexe.required' => 'Le sexe est requis',
        'form.pays.required' => 'Le pays est requis',
        'contratForm.fichier.required' => 'Le fichier est requis',
        'contratForm.titre.required' => 'Le titre est requis',
        'contratForm.fichier.file' => 'Selectionner un ficher pdf',
    ];

    public function changeEtat(){

        if($this->etat === 'list'){
            $this->etat = "add";
            $this->initForm();
        }else {
            $this->etat = "list";
        }
        $this->initForm();
    }

    public function changeStatut($statut){
        $this->statut = $statut;
        $this->contrats = Contrat::where('employe_id', $this->current_employe->id)->get();
    }

    public function deleteDocument($id){
        $this->document = Contrat::where('id', $id)->first();
        $this->alertConfirm();
        $this->typeDeleted = "document";
    }

    public function removeDocument(){

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Contrat!',
            'text' => 'Suppression avec succès.'
        ]);

        $doc =  Contrat::where('id', $this->document->id)->first();
        $this->astuce->addHistorique('Suppression d\'un document ('.$this->document->titre.')', "delete");
        $doc->delete();

    }

    public function addDocument(){
        if(isset($this->current_employe->id) && $this->current_employe->id !== null){
            $this->validate([
                'contratForm.titre'=>'required',
                'contratForm.fichier'=>'required|file',
            ]);

            $fileName = 'contrat_'.uniqid().'.pdf';

            $this->contratForm['fichier']->storeAs('public/contrats', $fileName);

            Contrat::create([
                'titre' => $this->contratForm['titre'],
                'fichier' => $fileName,
                'employe_id' => $this->current_employe->id,
            ]);

            $this->astuce->addHistorique("Ajout document", "add");
            $this->dispatchBrowserEvent("addSuccessful");
            $this->initContratForm();

            $this->getEmploye($this->current_employe->id);
            $this->changeStatut("list");

        }
    }

    public function initContratForm(){
        $this->contratForm['titre']='';
        $this->contratForm['fichier']='';
        $this->contratForm['employe_id']='';

    }


    public function delete($id)
    {
        $this->current_employe = User::where('id', $id)->first();
        $this->typeDeleted = "employe";
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
        if ($this->typeDeleted === "employe"){
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'Entreprise!',
                'text' => 'Suppression avec succès.'
            ]);

            $employe = User::where('id', $this->current_employe->id)->first();
            $this->astuce->addHistorique('Suppression d\'un employé ('.$this->current_employe->prenom.' '.$this->current_employe->nom.')', "delete");
            $employe->delete();
            return redirect()->to('/employes');
        }else{
            $this->removeDocument();
        }
    }

    public function download($contrat_id){
        $contrat = Contrat::where('id', $contrat_id)->first();
        return response()->download('storage/contrats/'.$contrat->fichier);
    }

    public function getEmploye($id){
        $this->etat="info";
        $this->initForm();

        $this->current_employe = User::where('id', $id)->first();
        $this->form['id'] = $this->current_employe->id;
        $this->form['prenom'] = $this->current_employe->prenom;
        $this->form['nom'] = $this->current_employe->nom;
        $this->form['email'] = $this->current_employe->email;
        $this->form['tel'] = $this->current_employe->tel;
        $this->form['fonction'] = $this->current_employe->fonction;
        $this->form['adresse'] = $this->current_employe->adresse;
        $this->form['sexe'] = $this->current_employe->sexe;
        $this->form['pays'] = $this->current_employe->pays;

    }

    public function deleteEmploye($id){
        $employe = User::where("id", $id)->first();
        $employe->delete();

        $this->astuce->addHistorique('Suppression d\'un employé', "delete");
        $this->dispatchBrowserEvent('deleteSuccessful');
        $this->etat="list";
    }

    public function initForm(){
        $this->form['id']=null;
        $this->form['prenom']='';
        $this->form['nom']='';
        $this->form['email']='';
        $this->form['tel']='';
        $this->form['fonction']='';
        $this->form['adresse']='';
        $this->form['sexe']='';
        $this->form['pays']='';
    }

    public function editProfil()
    {
        if ($this->profil) {
            $this->validate([
                'profil' => 'image'
            ]);
            $imageName = 'employe'.\md5($this->current_employe->id).'.jpg';

            $this->profil->storeAs('public/images', $imageName);

            $employe = User::where('id', $this->current_employe->id)->first();

            $employe->profil = $imageName;
            $employe->save();

            $this->astuce->addHistorique('Changement de logo d\'un employé', "update");

            $this->profil = "";
            $this->dispatchBrowserEvent('profilEditSuccessful');
            $this->getEmploye($this->current_employe->id);
        }
    }


    public function store(){

        $this->validate();

        if(isset($this->current_employe->id) && $this->current_employe->id !== null){
            $employe = User::where("id", $this->current_employe->id)->first();


            $employe->prenom = $this->form['prenom'];
            $employe->nom = $this->form['nom'];
            $employe->email = $this->form['email'];
            $employe->tel = $this->form['tel'];
            $employe->fonction = $this->form['fonction'];
            $employe->adresse = $this->form['adresse'];
            $employe->sexe = $this->form['sexe'];
            $employe->pays = $this->form['pays'];

            $employe->save();
            $this->astuce->addHistorique("Mis à jour employé", "update");
            $this->dispatchBrowserEvent("updateSuccessful");
            $this->initForm();
        }else{

            User::create([
                'prenom' => $this->form['prenom'],
                'nom' => $this->form['nom'],
                'email' => $this->form['email'],
                'tel' => $this->form['tel'],
                'adresse' => $this->form['adresse'],
                'role' => "Employe",
                'pays' => $this->form['pays'],
                'password' => Hash::make("admin@1"),
                'fonction' => $this->form['fonction'],
                'entreprise_id' => Auth::user()->entreprise_id,
                'sexe' => $this->form['sexe'],
                'profil' => $this->form['sexe'] === 'Homme' ? 'user-male.png' : 'user-female.png',

            ]);

            $this->astuce->addHistorique("Ajout employé", "add");
            $this->dispatchBrowserEvent("addSuccessful");
            $this->etat="list";

            $this->initForm();
        }
    }

    public function render()
    {
        $this->astuce = new Astuce();
        $this->staticData = $this->astuce->getStaticData("Type de fonction");

        // $val = "path\ggh\ggh";

        // dd(\str_replace("\\", "/", $val));


        return view('livewire.admin.employes', [
            "country" => Country::orderBy('nom_fr', 'ASC')->get(),
            "employes" => User::where('entreprise_id', Auth::user()->entreprise_id)->orderBy('id', 'DESC')->paginate(6)

            ])->layout('layouts.app', [
                'title' => "Employés",
                "page" => "employe",
                "icon" => "fas fa-user-friends",
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
