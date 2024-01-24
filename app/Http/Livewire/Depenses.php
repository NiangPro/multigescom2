<?php

namespace App\Http\Livewire;

use App\Models\Astuce;
use App\Models\Depense;
use App\Models\Messenger;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Depenses extends Component
{

    public $etat='list';
    public $astuce;
    public $categories;
    public $paiement;
    public $current_depense;
    public $idDeleting;
    protected $listeners = ['remove'];

    public $form = [
        'categorie' => '',      
        'mode_paiement' => '',
        'description' => '',
        'date' => '',
        'montant' => '',
        'entreprise_id' => '',
    ];

    protected $rules = [
        'form.categorie' => 'required|string',
        'form.mode_paiement' => 'required|string',
        'form.date' => 'required|date',
        'form.montant' => 'required',
    ];

    protected  $messages = [
        'form.categorie.required' => 'La categorie est requise',
        'form.mode_paiement.required' => 'Le mode de paiement est requis',
        'form.date.required' => 'La date est requise',
        'form.montant.required' => 'Le montant est requis',
    ];

    public function initForm(){
        $this->form['id']=null;
        $this->form['categorie']='';
        $this->form['mode_paiement']='';
        $this->form['description']='';
        $this->form['date']='';
        $this->form['montant']='';
    }


    public function getDepense($id){
        $this->etat="info";
        $this->initForm();

        $this->current_depense = Depense::where('id', $id)->first();
        $this->form['id'] = $this->current_depense->id;
        $this->form['categorie'] = $this->current_depense->categorie;
        $this->form['mode_paiement']=$this->current_depense->mode_paiement;
        $this->form['date']=$this->current_depense->date;
        $this->form['description']=$this->current_depense->description;
        $this->form['montant']=$this->current_depense->montant;
    }

    public function store(){
        $this->validate();

        if (isset($this->current_depense->id) && $this->current_depense->id!==null) {
            $depense = Depense::where('id', $this->current_depense->id)->first();

            $depense->categorie = $this->form['categorie'];
            $depense->mode_paiement = $this->form['mode_paiement'];
            $depense->date = $this->form['date'];
            $depense->description = $this->form['description'];
            $depense->montant = $this->form['montant'];

            $depense->save();
            $this->astuce->addHistorique("Mis à jour depense", "update");
            $this->dispatchBrowserEvent("addSuccessful");
            $this->etat="list";
        }else{
            Depense::create([
                'categorie' => $this->form['categorie'],
                'mode_paiement' => $this->form['mode_paiement'],
                'date' => $this->form['date'],
                'description' => $this->form['description'],
                'montant' => $this->form['montant'],
                'entreprise_id' => Auth::user()->entreprise_id,
            ]);

            $this->astuce->addHistorique("Ajout d'une depense", "add");
            $this->dispatchBrowserEvent("addSuccessful");
            $this->etat="list";
        }
        $this->initForm();
    }

    public function changeEtat($etat){
        $this->etat = $etat;
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
        $depense = Depense::where("id", $this->idDeleting)->first();
        $depense->delete();

        $this->astuce->addHistorique('Suppression d\'une depense', "delete");
        /* Write Delete Logic */

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Depense',
            'text' => 'Suppression avec succéss!.'
        ]);
        return redirect()->to('/depenses');
        $this->etat="list";
    }


    public function render()
    {
        $this->astuce = new Astuce();
        $this->categories = $this->astuce->getStaticData("Type de dépense");
        $this->paiements = $this->astuce->getStaticData("Mode de paiement");
        return view('livewire.comptable.depenses',[
            "depenses" => Depense::where('entreprise_id',Auth::user()->entreprise_id)->orderBy("id", 'DESC')->get(),
        ]
        )->layout('layouts.app', [
            'title' => "Les Dépenses",
            "page" => "depense",
            "icon" => "fas fa-balance-scale",
            "notification" => Messenger::where('recepteur_id', Auth()->user()->id)->where("seen", 1)->count(),
            
        ]);
    }

    public function mount(){
        if(!Auth::user()){
            return redirect(route('login'));
        }

        if(Auth::user()->isCommercial()){
            return redirect(route("home"));
        }

        if (!Auth()->user()->isOpen()) {
            return redirect(route('home'));
        }

    }
}
