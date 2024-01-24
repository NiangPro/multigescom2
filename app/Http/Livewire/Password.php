<?php

namespace App\Http\Livewire;

use App\Models\Astuce;
use App\Models\Messenger;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Password extends Component
{
    public $astuce;

    public $form = [
        'current_password' => "",
        'password' => "",
        'password_confirmation' => "",
    ];

    protected $rules = [
        'form.current_password' => 'required',
        'form.password' => 'required|string|min:6|confirmed',
    ];

    protected $messages = [
        'form.current_password.required' => "Le mot de passe est requis",
        'form.password.required' => "Le mot de passe est requis",
        'form.password.min' => "Minimum 6 caracteres",
        'form.password.confirmed' => "Les deux mots de passe sont differents",
    ];

    public function editPassword(){
        $this->validate();

        if (Auth::check($this->form['current_password'], Auth::user()->password) == 0) {
            $user = User::where('id', Auth::user()->id)->first();

            $user->password = Hash::make($this->form['password']);

            $user->save();

            $this->astuce->addHistorique("Changement du mot de passe", "update");

            $this->dispatchBrowserEvent('passwordEditSuccessful');
            $this->init();
        } else {
            $this->dispatchBrowserEvent("passwordNotFound");
        }

    }

    public function render()
    {
        $this->astuce = new Astuce();

        return view('livewire.password')->layout('layouts.app', [
            'title' => "Mot de passe",
            "page" => "password",
            "icon" => "fa fa-lock",
            "notification" => Messenger::where('recepteur_id', Auth()->user()->id)->where("seen", 1)->count(),
        ]);
    }

    public function mount(){
        if(!Auth::user()){
            return redirect(route('login'));
        }
    }

    public function init()
    {
        $this->form['current_password'] = "";
        $this->form['password'] = "";
        $this->form['password_confirmation'] = "";
    }
}
