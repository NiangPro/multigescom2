<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Cgu extends Component
{
    public $param;
    public function render()
    {
        return view('livewire.cgu')->layout('layouts.cgu',["param" => $this->param]);
    }

    public function mount()
    {
        if(Auth::check()){
            return redirect(route('home'));
        }

        $this->param = User::where("role", "Super Admin")->first();

    }
}
