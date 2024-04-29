<?php

namespace App\Http\Livewire;

use App\Models\Astuce;
use App\Models\Client;
use App\Models\Country;
use App\Models\Messenger;
use App\Models\Prospect;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Prospects extends Component
{
    public $status = "listProspects";
    public $staticData;
    public $astuce;
    public $current_prospect;
    public $idDeleting;
    protected $listeners = ['remove'];

    public $form = [
        'nom' => '',
        'email' => '',
        'tel' => '',
        'source' => '',
        'assignation' => '',
        'country_id' => '',
        'adresse' => '',
        'entreprise_id' => '',
    ];

    protected $rules = [
        'form.nom' => 'required|string',
        'form.email' => 'required|string',
        'form.tel' => ['required', 'min:9', 'max:9', 'regex:/^[33|70|75|76|77|78]+[0-9]{7}$/'],
        'form.source' => 'required|string',
        'form.assignation' => 'required',
        'form.country_id' => 'required',
        'form.adresse' => 'required|string',
    ];

    protected  $messages = [
        'form.nom.required' => 'Le nom est requis',
        'form.email.required' => 'le mail est requis',
        'form.tel.required' => 'Le telephone est requis',
        'form.tel.regex' => 'Le n° de telephone est invalide',
        'form.tel.min' => 'Le n° de telephone doit avoir au minimum 9 chiffres',
        'form.tel.max' => 'Le n° de telephone doit avoir au maximum 9 chiffres',
        'form.source.required' => 'La source est requise',
        'form.assignation.required' => 'L\'assignation est requise',
        'form.country_id.required' => 'Le pays est requis',
        'form.adresse.required' => 'L\'adresse est requis',
    ];

    public function initForm(){
        $this->form['id']=null;
        $this->form['nom']='';
        $this->form['email']='';
        $this->form['tel']='';
        $this->form['source']='';
        $this->form['assignation']='';
        $this->form['country_id']='';
        $this->form['adresse']='';
    }

    public function changeEtat($etat){
        $this->status = $etat;
        $this->initForm();
    }

    public function getProspect($id){
        $this->status="editProspect";
        $this->initForm();

        $this->current_prospect = Prospect::where('id', $id)->first();
        $this->form['id'] = $this->current_prospect->id;
        $this->form['nom'] = $this->current_prospect->nom;
        $this->form['email'] = $this->current_prospect->email;
        $this->form['tel'] = $this->current_prospect->tel;
        $this->form['source'] = $this->current_prospect->source;
        $this->form['assignation'] = $this->current_prospect->assignation;
        $this->form['country_id'] = $this->current_prospect->country_id;
        $this->form['adresse'] = $this->current_prospect->adresse;
    }

    public function store(){
        $this->validate();
        if (isset($this->form['id']) && $this->form['id']!==null) {
            $prospect = Prospect::where("id", $this->current_prospect->id)->first();

            $prospect->nom = $this->form['nom'];
            $prospect->email = $this->form['email'];
            $prospect->tel = $this->form['tel'];
            $prospect->source = $this->form['source'];
            $prospect->assignation = $this->form['assignation'];
            $prospect->country_id = $this->form['country_id'];
            $prospect->adresse = $this->form['adresse'];

            $prospect->save();
            $this->astuce->addHistorique("Mis à jour prospect", "update");
            $this->dispatchBrowserEvent("addSuccessful");
            $this->status="listProspects";

            $this->initForm();

        }else{
            Prospect::create([
                'nom' => $this->form['nom'],
                'email' => $this->form['email'],
                'tel' => $this->form['tel'],
                'source' => $this->form['source'],
                'assignation' => $this->form['assignation'],
                'country_id' => $this->form['country_id'],
                'adresse' => $this->form['adresse'],
                'entreprise_id' => Auth::user()->entreprise_id,
            ]);

            $this->astuce->addHistorique("Ajout prospect", "add");
            $this->dispatchBrowserEvent("addSuccessful");
            $this->status="listProspects";

            $this->initForm();
        }

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
        $prospect = Prospect::where("id", $this->idDeleting->id)->first();
        $prospect->delete();

        $this->astuce->addHistorique('Suppression d\'un prospect', "delete");
        /* Write Delete Logic */

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Prospect',
            'text' => 'Suppression avec succéss!.'
        ]);
        $this->status="listProspects";
    }

    public function approve($id){
        $this->initForm();

        $prospect = Prospect::where('id', $id)->first();

        Client::create([
            'nom' => $prospect->nom,
            'adresse' => $prospect->adresse,
            'tel' => $prospect->tel,
            'email' => $prospect->email,
            'country_id' => $prospect->country_id,
            'entreprise_id' => $prospect->entreprise_id,
        ]);

        $this->astuce->addHistorique("changement prospect vers client", "add");
        $this->dispatchBrowserEvent("approveSuccessful");
        $prospect->delete();

    }

    public function render()
    {
        $this->astuce = new Astuce();
        $this->staticData = $this->astuce->getStaticData("Source du prospect");

        return view('livewire.commercial.prospects',[
            "country" => Country::orderBy('nom_fr', 'ASC')->get(),
            "prospects" => Prospect::where('entreprise_id',Auth::user()->entreprise_id)->orderBy('id', 'DESC')->get(),
            "employes" => User::where('entreprise_id',Auth::user()->entreprise_id)->where('role', '!=', 'Super Admin')->get(),
        ])->layout('layouts.app', [
            'title' => "Prospects",
            "page" => "prospect",
            "icon" => "fa fa-tty",
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
