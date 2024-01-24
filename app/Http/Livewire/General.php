<?php

namespace App\Http\Livewire;

use App\Models\Astuce;
use App\Models\Entreprise;
use App\Models\Messenger;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class General extends Component
{
    use WithFileUploads;

    public $data = [
        'icon',
        'logo',
        'name'
    ];

    public $icon;
    public $astuce;
    public $logo;
    public $name;

    protected $messages = [
        'name.required' => 'Le nom est obligatoire',
        'name.max' => 'Maximum 18 caractéres',
        'icon.image' => 'Veuillez choisir une image',
        'icon.icon' => 'Veuillez choisir une image',
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
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Entreprise!',
            'text' => 'Suppression avec succès.'
        ]);
    }

    public function editConfig()
    {
        
        if (Auth::user()->role === "Super Admin") {

            if ($this->icon) {
                $this->validate([
                    'icon' => 'image'
                ]);
                $imageName = 'icon.jpg';

                $this->icon->storeAs('public/images', $imageName);
            }

        } 

            $this->validate([
                'name' => 'required|max:18'
            ]);

            $en = Entreprise::where('id', Auth::user()->entreprise_id)->first();
            $en->nom = $this->name;
            if ($this->logo) {
                $this->validate([
                    'logo' => 'image'
                ]);
                $imageName = 'company'.\md5($en->id).'.jpg';

                $this->logo->storeAs('public/images', $imageName);

                $en->profil = $imageName;

            }
            $en->save();
            $this->dispatchBrowserEvent("editSuccessfulAdmin");

        
        $this->init();
        $this->astuce->addHistorique("Mis à jour du système", "update");

    }

    public function render()
    {
        $this->astuce = new Astuce();

        return view('livewire.general')->layout('layouts.app', [
            'title' => "Configuration Générale",
            "page" => "general",
            "icon" => "fa fa-wrench",
            "notification" => Messenger::where('recepteur_id', Auth()->user()->id)->where("seen", 1)->count(),
        ]);
    }

    public function mount(){
        if(!Auth::user()){
            return redirect(route('login'));
        }

        $this->init();
    }

    public function init()
    {
        if (Auth::user()->role === 'Super Admin') {
            $this->data['icon'] =  config('app.icon');

        }
        $this->data['logo'] =  Auth::user()->entreprise->profil;
        $this->data['name'] =  Auth::user()->entreprise->nom;
        $this->name = $this->data['name'];
        $this->logo = null;
        $this->icon = null;
    }
}
