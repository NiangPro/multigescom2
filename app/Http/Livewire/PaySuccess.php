<?php

namespace App\Http\Livewire;

use App\Models\Astuce;
use App\Models\Entreprise;
use App\Models\Messenger;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class PaySuccess extends Component
{
    public $astuce;
    public function activer(){
        redirect(route("home"));
    }

    public function render()
    {
        

        return view('livewire.pay-success')->layout('layouts.app', [
            'title' => "Renouvellement avec succès",
            "page" => "Abonnements",
            "icon" => "fa fa-money-bill",
            "notification" => Messenger::where('recepteur_id', Auth()->user()->id)->where("seen", 1)->count(),
        ]);
    }

    public function mount(){
        $this->astuce = new Astuce();
        if (Session::has('type')){
            $nombre = Session::get("nombre");
            $type = Session::get("type");

            $date = Carbon::now();
            if ($type == "mois") {
                $date->addMonths($nombre);
            }else{
                $date->addYears($nombre);
            }

            $ent = Entreprise::where("id", Auth()->user()->entreprise->id)->first();

            $ent->statut = 1;
            $ent->fermeture = $date;

            $ent->save();
            $this->astuce->addHistorique("Renouvellement d'abonnement", "add");

        }else{
            return redirect(route("home"));
        }
        
    }
}
