<?php

namespace App\Http\Livewire;

use App\Models\Astuce;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $astuce;
    public $form = [
        "email" => "",
        "password" => "",
    ];

    protected $rules = [
        "form.email" => "required|email",
        "form.password" => "required",
    ];

    public function mount()
    {
        if(Auth::check()){
            return redirect(route('home'));
        }
    }

    public function connecter()
    {
        $this->validate();

        if(Auth::attempt(['email' => $this->form['email'], 'password' => $this->form['password']]))
        {
            return redirect(route('home'));
        }else{
            $this->dispatchBrowserEvent('errorLogin');
        }

    }
    public function render()
    {
            $this->astuce = new Astuce();
            $this->astuce->initCountries();
            $this->astuce->createFirstSuperAdmin();
            $this->astuce->createEntrepriseDemo();
            return view('livewire.login1'
            )->layout('layouts.app');

    }
}
