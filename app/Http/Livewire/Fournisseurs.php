<?php

namespace App\Http\Livewire;

use App\Models\Astuce;
use App\Models\Country;
use App\Models\Fournisseur;
use App\Models\Messenger;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Fournisseurs extends Component
{
    public $status = "listFournisseurs";
    public $astuce;
    public $current_fournisseur;
    public $idDeleting;
    protected $listeners = ['remove'];

    public $form = [
        'nom' => '',
        'adresse' => '',
        'tel' => '',
        'email' => '',
        'country_id' => 193,
        'entreprise_id' => '',
    ];

    protected $rules = [
        'form.nom' => 'required|string',
        'form.adresse' => 'required|string',
        'form.tel' => ['required', 'min:9', 'max:9', 'regex:/^[33|70|75|76|77|78]+[0-9]{7}$/'],
        'form.email' => 'required|string',
        'form.country_id' => 'required',
    ];

    protected  $messages = [
        'form.nom.required' => 'Le nom est requis',
        'form.adresse.required' => 'L\'adresse est requis',
        'form.tel.required' => 'Le telephone est requis',
        'form.tel.regex' => 'Le n° de telephone est invalide',
        'form.tel.min' => 'Le n° de telephone doit avoir au minimum 9 chiffres',
        'form.tel.max' => 'Le n° de telephone doit avoir au maximum 9 chiffres',
        'form.email.required' => 'le mail est requis',
        'form.country_id.required' => 'Le pays est requis',
    ];

    public function initForm(){
        $this->form['id']=null;
        $this->form['nom']='';
        $this->form['adresse']='';
        $this->form['tel']='';
        $this->form['email']='';
        $this->form['country_id']=193;
    }

    public function changeEtat($etat){
        $this->status = $etat;
        $this->initForm();
    }

    public function getFournisseur($id){
        $this->status="editFournisseur";
        $this->initForm();

        $this->current_fournisseur = Fournisseur::where('id', $id)->first();
        $this->form['id'] = $this->current_fournisseur->id;
        $this->form['nom'] = $this->current_fournisseur->nom;
        $this->form['adresse'] = $this->current_fournisseur->adresse;
        $this->form['tel'] = $this->current_fournisseur->tel;
        $this->form['email'] = $this->current_fournisseur->email;
        $this->form['country_id'] = $this->current_fournisseur->country_id;
    }

    public function store(){
        $this->validate();
        if(isset($this->form['id']) && $this->form['id'] !== null){
            $fournisseur = Fournisseur::where("id", $this->current_fournisseur->id)->first();

            $fournisseur->nom = $this->form['nom'];
            $fournisseur->adresse = $this->form['adresse'];
            $fournisseur->tel = $this->form['tel'];
            $fournisseur->email = $this->form['email'];
            $fournisseur->country_id = $this->form['country_id'];

            $fournisseur->save();
            $this->astuce->addHistorique("Mis à jour fournisseur", "update");
            $this->dispatchBrowserEvent("addSuccessful");
            $this->status="listFournisseurs";

            $this->initForm();

        }else{
            Fournisseur::create([
                'nom' => $this->form['nom'],
                'adresse' => $this->form['adresse'],
                'tel' => $this->form['tel'],
                'email' => $this->form['email'],
                'country_id' => $this->form['country_id'],
                'entreprise_id' => Auth::user()->entreprise_id,
            ]);
    
            $this->astuce->addHistorique("Ajout fournisseur", "add");
            $this->dispatchBrowserEvent("addSuccessful");
            $this->status="listFournisseurs";
    
            $this->initForm();
        }
    }

    public function delete($id){
        $this->idDeleting = $id;
        $this->alertConfirm();
    }

    public function remove(){
        $fournisseur = Fournisseur::where('id', $this->idDeleting)->first();
        $fournisseur->delete();
        $this->astuce->addHistorique('Suppression d\'un fournisseur', "delete");
        /* Write Delete Logic */

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Fournisseur',
            'text' => 'Suppression avec succéss!.'
        ]);
        return redirect()->to('/fournisseurs');
        $this->status="listFournisseurs";
    }

    public function alertConfirm()
    {
        $this->dispatchBrowserEvent('swal:confirm', [
            'type' => 'warning',
            'message' => 'Êtes-vous sûr?',
            'text' => 'Vouliez-vous supprimer?'
        ]);
    }

    public function render()
    {
        $this->astuce = new Astuce();
        return view('livewire.fournisseurs' ,[
            "fournisseurs" => Fournisseur::where('entreprise_id',Auth::user()->entreprise_id)->orderBy('id', 'DESC')->get(),
            "country" => Country::orderBy('id', 'ASC')->get(),
        ])->layout('layouts.app', [
            'title' => "Fournisseurs",
            "page" => "fournisseur",
            "icon" => "fas fa-street-view",
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
