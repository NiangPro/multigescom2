<?php

namespace App\Http\Livewire;

use App\Models\Astuce;
use App\Models\Messenger;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class History extends Component
{
    public $historiques;
    public $astuce;

    public function render()
    {
        $this->astuce = new Astuce();

        if (Auth::user()->role === "Super Admin") {
            $this->historiques = $this->astuce->superAdminHistorique();
        }elseif (Auth::user()->role === "Admin"){
            $this->historiques = $this->astuce->adminHistorique();
        }else{
            $this->historiques = Auth::user()->historiques;
        }

        return view('livewire.history', [

            ])->layout('layouts.app', [
                'title' => "Historiques",
                "page" => "history",
                "icon" => "fa fa-history",
                "notification" => Messenger::where('recepteur_id', Auth()->user()->id)->where("seen", 1)->count(),

            ]);
        }

        public function mount(){
            if(!Auth::user()){
                return redirect(route('login'));
            }
        }
}
