<?php

namespace App\Http\Livewire;

use App\Models\Messenger;
use Livewire\Component;

class PayError extends Component
{
    public function render()
    {
        return view('livewire.pay-error')->layout('layouts.app', [
            'title' => "Renouvellement avec succès",
            "page" => "Abonnements",
            "icon" => "fa fa-money-bill",
            "notification" => Messenger::where('recepteur_id', Auth()->user()->id)->where("seen", 1)->count(),
        ]);
    }
}
