<?php

namespace App\Http\Livewire;

use App\Models\Messenger;
use App\Models\ParamAbonnement;
use Livewire\Component;

class Abonnement extends Component
{
    
    public $form = [
        "mensuel" => 0,
        "annuel" => 0,
    ]; 

    public function editParam(){
        $pa = ParamAbonnement::first();

        $pa->mensuel = $this->form["mensuel"];
        $pa->annuel = $this->form["annuel"];

        $pa->save();

        $this->dispatchBrowserEvent('editSuccessful');
    }

    public function render()
    {

        return view('livewire.superAdmin.abonnement')->layout('layouts.app', [
            'title' => "Les Paramètres de l'abonnement",
            "page" => "Abonnements",
            "icon" => "fa fa-money-bill",
            "notification" => Messenger::where('recepteur_id', Auth()->user()->id)->where("seen", 1)->count(),
        ]);
    }

    public function mount()
    {
        $pa = ParamAbonnement::first();
        $this->form["mensuel"] = $pa->mensuel;
        $this->form["annuel"] = $pa->annuel;
    }
}
