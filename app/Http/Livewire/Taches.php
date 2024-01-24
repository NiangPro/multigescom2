<?php

namespace App\Http\Livewire;

use App\Models\Astuce;
use App\Models\Employe;
use App\Models\Messenger;
use App\Models\Tache;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Taches extends Component
{

    public $status="listTaches";
    public $astuce;
    public $staticData;
    public $current_tache;
    public $idDeleting;
    protected $listeners = ['remove'];

    public $form = [
        'titre' => '',
        'assignation' => '',
        'date_debut' => '',
        'date_fin' => '',
        'description' => '',
        'priorite' => '',
        'statut' => '',
        'entreprise_id' => '',
    ];

    protected $rules = [
        'form.titre' => 'required|string',
        'form.assignation' => 'required',
        'form.date_debut' => 'required|date',
        'form.date_fin' => 'required|date',
        'form.description' => 'required|string',
        'form.priorite' => 'required|string',
        'form.statut' => 'required|string',
    ];

    protected  $messages = [
        'form.titre.required' => 'Le titre est requis',
        'form.assignation.required' => 'L\'assignation est requise',
        'form.date_debut.required' => 'La date debut est requise',
        'form.date_fin.required' => 'La date debut est requise',
        'form.description.required' => 'La description est requise',
        'form.priorite.required' => 'La priorité est requise',
        'form.statut.required' => 'Le statut est requis',
    ];

    public function initForm(){
        $this->form['id']=null;
        $this->form['titre']='';
        $this->form['assignation']='';
        $this->form['date_debut']='';
        $this->form['date_fin']='';
        $this->form['description']='';
        $this->form['priorite']='';
        $this->form['statut']='';
    }

    public function getTache($id){
        $this->status="editTache";
        $this->initForm();

        $this->current_tache = Tache::where('id', $id)->first();
        $this->form['id'] = $this->current_tache->id;
        $this->form['titre'] = $this->current_tache->titre;
        $this->form['assignation']=$this->current_tache->assignation;
        $this->form['date_debut']=$this->current_tache->date_debut;
        $this->form['date_fin']=$this->current_tache->date_fin;
        $this->form['description']=$this->current_tache->description;
        $this->form['priorite']=$this->current_tache->priorite;
        $this->form['statut']=$this->current_tache->statut;
    }

    public function store(){
        $this->validate();

        if (isset($this->current_tache->id) && $this->current_tache->id!==null) {
            $tache = Tache::where('id', $this->current_tache->id)->first();

            $tache->titre = $this->form['titre'];
            $tache->assignation = $this->form['assignation'];
            $tache->date_debut = $this->form['date_debut'];
            $tache->date_fin = $this->form['date_fin'];
            $tache->description = $this->form['description'];
            $tache->priorite = $this->form['priorite'];
            $tache->statut = $this->form['statut'];

            $tache->save();
            $this->astuce->addHistorique("Mis à jour tache", "update");
            $this->dispatchBrowserEvent("addSuccessful");
            $this->status="listTaches";

            $this->initForm();
        }else{
            Tache::create([
                'titre' => $this->form['titre'],
                'assignation' => $this->form['assignation'],
                'date_debut' => $this->form['date_debut'],
                'date_fin' => $this->form['date_fin'],
                'description' => $this->form['description'],
                'priorite' => $this->form['priorite'],
                'statut' => $this->form['statut'],
                'entreprise_id' => Auth::user()->entreprise_id,
            ]);

            $this->astuce->addHistorique("Ajout tâche", "add");
            $this->dispatchBrowserEvent("addSuccessful");
            $this->status="listTaches";

            $this->initForm();
        }
    }

    public function changeEtat($etat){
        $this->status = $etat;
        $this->initForm();
    }

    public function delete($id){
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

    // delete reunion
    public function remove(){
        $tache = Tache::where("id", $this->idDeleting)->first();
        $tache->delete();

        $this->astuce->addHistorique('Suppression d\'une tache', "delete");
        /* Write Delete Logic */

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Tache',
            'text' => 'Suppression avec succéss!.'
        ]);
        return redirect()->to('/taches');
        $this->status="listTaches";
    }

    public function render()
    {
        $this->astuce = new Astuce();
        $this->staticData = $this->astuce->getStaticData("Priorité des tâches");

        return view('livewire.admin.taches',[
            "employes" => User::where('role', '!=', 'Super Admin')->where("entreprise_id", Auth()->user()->entreprise_id)->get(),
            "taches" => Tache::where('entreprise_id',Auth::user()->entreprise_id)->orderBy('id', 'DESC')->get(),
        ])->layout('layouts.app', [
            'title' => "Taches",
            "page" => "tache",
            "icon" => "fas fa-edit",
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
