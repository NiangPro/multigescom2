<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Astuce;
use App\Models\Messenger;

class Clients extends Component
{
    public $status="listClients";
    public $astuce;
    public $current_client;
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
        $this->form['nom']='';
        $this->form['adresse']='';
        $this->form['tel']='';
        $this->form['email']='';
        $this->form['country_id']=193;
    }

    public function changeEtat($etat){
        $this->status = $etat;
    }

    public function getClient($id){
        $this->status="editClient";
        $this->initForm();

        $this->current_client = Client::where('id', $id)->first();
        $this->form['id'] = $this->current_client->id;
        $this->form['nom'] = $this->current_client->nom;
        $this->form['adresse'] = $this->current_client->adresse;
        $this->form['tel'] = $this->current_client->tel;
        $this->form['email'] = $this->current_client->email;
        $this->form['country_id'] = $this->current_client->country_id;
    }

    public function store(){
        $this->validate();
        if(isset($this->current_client->id) && $this->current_client->id !== null){
            $client = Client::where("id", $this->current_client->id)->first();

            $client->nom = $this->form['nom'];
            $client->adresse = $this->form['adresse'];
            $client->tel = $this->form['tel'];
            $client->email = $this->form['email'];
            $client->country_id = $this->form['country_id'];

            $client->save();
            $this->astuce->addHistorique("Mis à jour client", "update");
            $this->dispatchBrowserEvent("addSuccessful");
            $this->status="listClients";

            $this->initForm();

        }else{
            Client::create([
                'nom' => $this->form['nom'],
                'adresse' => $this->form['adresse'],
                'tel' => $this->form['tel'],
                'email' => $this->form['email'],
                'country_id' => $this->form['country_id'],
                'entreprise_id' => Auth::user()->entreprise_id,
            ]);

            $this->astuce->addHistorique("Ajout d'un client", "add");
            $this->dispatchBrowserEvent("addSuccessful");
            $this->status="listClients";

            $this->initForm();
        }
    }

    public function deleteClient($id){
        $this->idDeleting = $id;
        $this->alertConfirm();
    }

    public function remove(){
        $client = Client::where('id', $this->idDeleting)->first();
        $client->delete();
        $this->astuce->addHistorique('Suppression d\'un client', "delete");
        /* Write Delete Logic */

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Client',
            'text' => 'Suppression avec succéss!.'
        ]);
        return redirect()->to('/clients');
        $this->status = "listClients";
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
        return view('livewire.commercial.clients',
        [
            "clients" => Client::where('entreprise_id',Auth::user()->entreprise_id)->orderBy('id', 'DESC')->get(),
            "country" => Country::orderBy('id', 'ASC')->get(),
        ])->layout('layouts.app', [
            'title' => "Clients",
            "page" => "client",
            "icon" => "fa fa-users",
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
