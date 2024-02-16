<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class PasswordForget extends Component
{
    public $trouve=false;
    public $idUser;
    public $form = [
        'email' => "",
        'tel' => "",
    ];

    public $form2 = [
        'password' => "",
        'password_confirmation' => "",
    ];

    protected $rules = [
        'form.tel' => ['required', 'min:9', 'max:9', 'regex:/^[33|70|75|76|77|78]+[0-9]{7}$/'],
        'form.email' => ['required', 'email', 'unique:users,email'],
        'form2.password' => 'required|string|min:6|confirmed',
    ];

    protected $messages = [
        'form.email.required' => "L'email est requis",
        'form.tel.required' => 'Le telephone est requis',
        'form2.password.required' => "Le mot de passe est requis",
        'form2.password.confirmed' => "Les deux mots de passe sont differents",
        'form2.password.min' => "Minimum 6 caracteres",
    ];

    protected function formInit()
    {
        $this->form['tel'] = "";
        $this->form['email'] = "";
    }

    protected function form2Init()
    {
        $this->form['password'] = "";
        $this->form['password_confirmation'] = "";
        $this->idUser = null;
    }

    public function isExiste(){
        $user = User::orderBy("id", "ASC")->get();
        foreach ($user as $key => $value) {
            if($value->email == $this->form['email'] && $value->tel == $this->form['tel']) {
                $this->idUser = $value->id;
              return  $this->trouve = true;
            }else{
                $this->dispatchBrowserEvent('errorLogin');
            }
        }
        $this->formInit();
    }

    public function editPassword(){
        if($this->trouve){
            $this->validate([
                'form2.password' => 'required|confirmed'
            ]);
            $user = User::where('id', $this->idUser)->first();
            $user->password = Hash::make($this->form2['password']);

            $user->save();
            return redirect(route('login'));
            $this->dispatchBrowserEvent('passwordEditSuccessful');
            $this->form2Init();
        }
    }

    public function render()
    {
        return view('livewire.password-forget')->layout('layouts.app');
    }
}
