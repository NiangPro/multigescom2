<?php

namespace App\Http\Livewire;

use App\Models\Astuce;
use App\Models\Client;
use App\Models\DevisItem;
use App\Models\Devis as ModelsDevis;
use App\Models\Messenger;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Devis extends Component
{
    public $etat="list";
    public $astuce;
    public $current_devis;
    public $idDeleting;
    protected $listeners = ['remove'];
    public $currentStep = 1;
    public $description;
    public $tab_product = [];
    public $i = 1;
    public $taxes;
    public $idItem=0;
    public $total=0;
    public $staticData;
    public $idprod = null;
    public $remise=0;

    public $form = [
        'date' => '',
        'client_id' => null,
        'employe_id' => null,
        'description' => '',
        'montant' => '',
        'remise' => '',
        'statut' => '',
        'entreprise_id' => null,
    ];

    protected $rules = [
        'form.date' => 'required|string',
        'form.client_id' => 'required',
        'form.statut' => 'required|string',
    ];

    protected  $messages = [
        'form.date.required' => 'La date est requis',
        'form.client_id.required' => 'Le client est requis',
        'form.statut.required' => 'le statut est requis',
    ];

    public function initForm(){
        $this->form['date']='';
        $this->form['client_id']= null;
        $this->form['employe_id']= null;
        $this->form['description']='';
        $this->form['montant']='';
        $this->form['remise']='';
        $this->form['statut']='';
    }

    public function emptyDevisItem($tab){
        foreach ($tab as $product) {
            if(empty($product['montant']) && empty($product['description'])
             && $product['montant'] <= 1000 && $product['quantite'] === 0 ){
                return false;
            }else{
                return true;
            }
        }
    }

    public function store(){

        $this->validate();

        if($this->emptyDevisItem($this->tab_product)){
            $devis = ModelsDevis::create([
                'client_id' => $this->form['client_id'],
                'employe_id' => $this->form['employe_id'] ?:null,
                'description' => $this->form['description'],
                'montant' => $this->total,
                'remise' => $this->remise,
                'date' => $this->form['date'],
                'statut' => $this->form['statut'],
                'entreprise_id' => Auth::user()->entreprise_id,
            ]);

            foreach ($this->tab_product as $key => $value) {
                DevisItem::create([
                    'nom' => $this->tab_product[$key]['nom'],
                    'description' => $this->description,
                    'montant' => $this->tab_product[$key]['montant'],
                    'taxe' => $this->tab_product[$key]['taxe'],
                    'quantite' => $this->tab_product[$key]['quantite'],
                    'devis_id' => $devis->id,
                ]);
            }

            $this->astuce->addHistorique("Ajout d'un devis ".$devis->id, "add");

            $this->dispatchBrowserEvent("addSuccessful");
            $this->initForm();
            $this->initTabProduct();
            $this->etat="list";
        }else{
            $this->dispatchBrowserEvent("valueEmpty");
        }
    }

    public function addItem()
    {
        $index = count($this->tab_product)-1;
        if($this->tab_product[$index]['nom']==="" && 
            $this->tab_product[$index]['description']==="" &&
            $this->tab_product[$index]['tarif']===0 && 
            $this->tab_product[$index]['quantite']=== 0){
                $this->dispatchBrowserEvent("elementEmpty");
        }else{
                $this->tab_product[] = [
                    'nom'=>"",
                    'description'=>"",
                    'tarif' =>0,
                    'quantite'=>0,
                    'taxe'=>0,
                    'montant'=>0,
                ];
        }
    }

    public function removeItem($i)
    {
        $taille = count($this->tab_product)-1;

        if($taille > 0){
            unset($this->tab_product[$i]);
            $this->tab_product=array_values($this->tab_product);
        }else{
            $this->dispatchBrowserEvent("produitEmpty");
        }
    }

    public function firstStepSubmit()
    {
        if($this->validate()){
            $this->currentStep = 2;
        }
    }

    public function back($step)
    {
        $this->currentStep = $step;
    }

    public function changeEtat($etat){
        $this->etat = $etat;
    }

    public function changeEvent(){
        if(!empty($this->idprod) &&  $this->idprod!== null){

            array_pop($this->tab_product);
            $product = Produit::where("id", $this->idprod)->first();
            $this->description = $product->description;

            $this->tab_product[] = [
                'nom'=> $product->nom,
                'description'=> $product->description,
                'tarif' => $product->tarif,
                'quantite'=> 1,
                'taxe'=> $product->taxe,
                'montant'=> $this->montanthT($product->tarif,1,$product->taxe)
            ];

            $this->idprod = null;
        }
    }

    public function montanthT($tarif, $qt , $tva){
        return ($tarif*$qt*(1+$tva/100));
    }

    public function calculMontant($key){
        $this->tab_product[$key]['montant'] = $this->montanthT(
            $this->tab_product[$key]['tarif'],
            $this->tab_product[$key]['quantite'],
            $this->tab_product[$key]['taxe']
        ) ;
    }

    public function getDevis($id){
        $this->current_devis = ModelsDevis::where("id", $id)->first();
        $this->etat = "info";
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
        $tache = DevisItem::where("id", $this->idDeleting)->first();
        $tache->delete();

        $this->astuce->addHistorique('Suppression d\'un dévis', "delete");
        /* Write Delete Logic */

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Dévis',
            'text' => 'Suppression avec succéss!.'
        ]);
        return redirect()->to('/devis');
        $this->etat="list";
    }

    public function render()
    {
        $this->astuce = new Astuce();
        $sous_total = 0;

        foreach ($this->tab_product as $product) {
            if($product['montant'] && $product['quantite']){
                $sous_total += $product['montant']*(1 + ($product['taxe']/100));
                $this->total = $sous_total*(1 - $this->remise/100);
            }
        }

        $this->staticData = $this->astuce->getStaticData("Statut des devis");

        return view('livewire.comptable.devis',[
            'sous_total' => $sous_total,
            'total' => $this->total,
            'devisItem' => ModelsDevis::where("entreprise_id", Auth::user()->entreprise_id)->OrderBy('id', 'DESC')->get(),
            'all_product' => Produit::where('entreprise_id', Auth::user()->entreprise_id)->OrderBy('id', 'DESC')->get(),
            'clients' => Client::where('entreprise_id', Auth::user()->entreprise_id)->orderBy('id', 'DESC')->get(),
            'employes' => User::where('entreprise_id', Auth::user()->entreprise_id)->orderBy('id', 'DESC')->get(),
        ])->layout('layouts.app', [
            'title' => "Les Devis",
            "page" => "devis",
            "icon" => "fas fa-file-invoice",
            "notification" => Messenger::where('recepteur_id', Auth()->user()->id)->where("seen", 1)->count(),        
        ]);
    }

    public function initTabProduct(){
        $this->tab_product[] = [
            'nom'=>"",
            'description'=>"",
            'tarif' =>0,
            'quantite'=>0,
            'taxe'=>0,
            'montant'=>0,
        ];
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

        $this->initTabProduct();

    }
}
