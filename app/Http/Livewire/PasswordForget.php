<?php

namespace App\Http\Livewire;
// namespace App\Mail;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;

use Livewire\Component;

class PasswordForget extends Component
{
    public $trouve=false;
    public $idUser;
    public $code;
    public $trouveCode=false;
    public $form = [
        'email' => "",
        'code' => "",
    ];


    public $form2 = [
        'password' => "",
        'password_confirmation' => "",
    ];

    protected $rules = [
        'form.code' => ['required','string'],
        'form.email' => ['required', 'email', 'unique:users,email'],
        'form2.password' => 'required|string|min:6|confirmed',
    ];

    protected $messages = [
        'form.email.required' => "L'email est requis",
        // 'form.tel.required' => 'Le telephone est requis',
        'form2.password.required' => "Le mot de passe est requis",
        'form2.password.confirmed' => "Les deux mots de passe sont differents",
        'form2.password.min' => "Minimum 6 caracteres",
    ];

    protected function formInit()
    {
        $this->form['email'] = "";
        $this->form['code'] = "";
    }

    protected function form2Init()
    {
        $this->form['password'] = "";
        $this->form['password_confirmation'] = "";
        $this->idUser = null;
    }

    public function isExact(){
        $this->validate([
            'form.code' => 'required|string'
        ]);
        if($this->code== $this->form['code']){
            $this->dispatchBrowserEvent('accessCode');
            return  $this->trouve = true;
        }else{
            $this->dispatchBrowserEvent('errorCode');
        }
    }

    // envoyer un code par email
    //
    public function isExiste(){
        $this->validate([
            'form.email' => 'required|email'
        ]);
        $istrue  = false;
        $user = User::orderBy("id", "ASC")->get();
        foreach ($user as $key => $value) { 
            if(strtolower($value->email) == strtolower($this->form['email'])) {
                $istrue = true;
            }
        }
        return $istrue;
    }

    public function sendWelcomeEmail()
    {  
        if($this->isExiste()) {
            $this->code = mt_rand(1000, 9999);
            $title = 'Renitialisation du mot passe demander ; 
            veuiller saisir ce code sur l\'entré afin de pouvoir renitialiser votre mot de passe';
            $body = $this->code;

            Mail::to(strtolower($this->form['email']))->send(new TestMail($title, $body));
            $this->trouveCode = true;
            $this->dispatchBrowserEvent('sendCode');
        }else{
            $this->dispatchBrowserEvent('errorLogin');
        }
        return "Email sent successfully!";
    }

        
    public function editPassword(){
        if($this->trouve){
            $this->validate([
                'form2.password' => 'required|confirmed'
            ]);
            $user = User::where('email', $this->form['email'])->first();
            $user->password = Hash::make($this->form2['password']);

            $user->save();
            $this->dispatchBrowserEvent('passwordEditSuccessful');
            return redirect(route('login'));
            $this->form2Init();
            $this->formInit();
        }
    }

    public function render()
    {
        return view('livewire.password-forget')->layout('layouts.app');
    }
}
