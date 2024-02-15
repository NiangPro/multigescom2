<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PasswordForget extends Component
{
    public $trouve=false;
    public $form = [
        'email' => "",
        'tel' => "",
    ];

    protected $rules = [
        'form.tel' => ['required', 'min:9', 'max:9', 'regex:/^[33|70|75|76|77|78]+[0-9]{7}$/'],
        'form.email' => ['required', 'email', 'unique:users,email'],
    ];

    protected $messages = [
        'form.email.required' => "L'email est requis",
        'form.tel.required' => 'Le telephone est requis',
    ];

    public function isExiste(){
        if(Auth::attempt(['email' => $this->form['email'], 'tel' => $this->form['tel']])){
            $trouve=true;
        }else{
            $trouve=false;
        }
    }

    public function render()
    {
        return view('livewire.password-forget')->layout('layouts.app');
    }
}
