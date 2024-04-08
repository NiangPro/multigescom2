<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Astuce;
use App\Models\Messenger;
use App\Models\Produit;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Produits extends Component
{   
    use WithFileUploads, WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['remove'];

    public $status = "listProduct";
    public $tva;
    public $astuce;
    public $current_produit;
    public $idDeleting;
    public $image_produit;

    public $form = [
        'nom' => '',
        'description' => '',
        'type' => '',
        'tarif' => '',
        'taxe' => 0,
        'entreprise_id' => '',
    ];

    protected $rules = [
        'form.nom' => 'required|string',
        'form.description' => 'string',
        'form.type' => 'required|string',
        'form.tarif' => 'required',
        'form.taxe' => 'required',
    ];

    protected $messages = [
        'form.nom.required' => 'Le nom est requis',
        'form.description.required' => 'La description est requise',
        'form.type.required' => 'Le type est requis',
        'form.tarif.required' => 'Le tarif est requis',
        'form.taxe.required' => 'La taxe est requise',
    ];

    public function getProduct($id){
        $this->status="editProduct";
        $this->initForm();

        $this->current_produit = Produit::where('id', $id)->first();
        $this->form['id'] = $this->current_produit->id;
        $this->form['nom'] = $this->current_produit->nom;
        $this->form['description'] = $this->current_produit->description;
        $this->form['type'] = $this->current_produit->type;
        $this->form['tarif'] = $this->current_produit->tarif;
        $this->form['taxe'] = $this->current_produit->taxe;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */

    public function deleteProduct($id){
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

        $produit = Produit::where('id', $this->idDeleting)->first();
        $produit->delete();
        $this->astuce->addHistorique('Suppression d\'un produit/service', "delete");
        /* Write Delete Logic */
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Produit/Service',
            'text' => 'Suppression avec succéss!.'
        ]);
        return redirect()->to('/produits');
        $this->status = "listProduct";
    }

    public function store(){
        $this->validate();
        if(empty($this->form['type'])){
            $this->dispatchBrowserEvent("typeEmpty");
        }
        
        if(isset($this->current_produit->id) && $this->current_produit->id !== null){
            $produit = Produit::where("id", $this->current_produit->id)->first();

            $produit->nom = $this->form['nom'];
            $produit->description = $this->form['description'];
            $produit->type = $this->form['type'];
            $produit->tarif = $this->form['tarif'];
            $produit->taxe = $this->form['taxe'];

            $produit->save();
            $this->astuce->addHistorique("Mis à jour produit ou service", "update");
            $this->dispatchBrowserEvent("updateSuccessful");
            return redirect()->to('/produits');
            $this->status =  "listProduct";
            $this->initForm();

        }else{

            Produit::create([
                'nom' => $this->form['nom'],
                'description' => $this->form['description'],
                'type' => $this->form['type'],
                'image_produit' => $this->form['type'] === "Produit" ? 'produit.png' : 'service.png',
                'tarif' => $this->form['tarif'],
                'taxe' => $this->form['taxe'],
                'entreprise_id' => Auth::user()->entreprise_id,
            ]);
        
                $this->astuce->addHistorique("Ajout produit", "add");
                $this->dispatchBrowserEvent("addSuccessful");
                return redirect()->to('/produits');
                $this->status =  "listProduct";
                $this->initForm();
        }
    }

    public function editImage()
    {
        if ($this->image_produit) {
            $this->validate([
                'image_produit' => 'image'
            ]);
            $imageName = 'produit'.\md5($this->current_produit->id).'.jpg';

            $this->image_produit->storeAs('public/images', $imageName);

            $produit = Produit::where('id', $this->current_produit->id)->first();

            $produit->image_produit = $imageName;
            $produit->save();

            $this->astuce->addHistorique('Changement image d\'un produit/service', "update");

            $this->image_produit = "";
            $this->dispatchBrowserEvent('imageEditSuccessful');
            $this->getProduct($this->current_produit->id);
        }
    }


    public function initForm(){
        $this->form['id']=null;
        $this->form['nom']='';
        $this->form['description']='';
        $this->form['type']='';
        $this->form['tarif']='';
        $this->form['taxe']= 0;
    }

    public function changeEtat($etat){
        $this->status = $etat;
        $this->initForm();
    }

    public function render()
    {
        $this->astuce = new Astuce();
        $this->tva = $this->astuce->getStaticData("TVA");

        return view('livewire.commercial.produits', [
            "produits" => Produit::where('entreprise_id', Auth()->user()->entreprise_id)->orderBy('id','DESC')->paginate(6),
        ])->layout('layouts.app',[
            'title' => 'Produits & Services',
            "page" => "produit",
            "icon" => "fab fa-product-hunt",
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
