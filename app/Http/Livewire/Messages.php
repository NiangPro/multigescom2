<?php

namespace App\Http\Livewire;

use App\Models\Astuce;
use App\Models\Messenger;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Messages extends Component
{
    public $idUser=null;
    public $current_user;
    public $astuce;
    public $recent_message;
    public $current_message = null;
    public $trouve = false;

    public $form =[
        'emetteur_id' => '',
        'recepteur_id' => '',
        'text' => '',
        'seen' => '',
        'statut' => ''
    ];

    protected $rules = [
        'form.text' => 'required|string',
    ];

    protected $messages = [
        'form.text.required' => 'Le text est requis'
    ];

    public function initForm(){
        $this->form['text']='';
    }

    public function store(){
        $this->validate();
        if(isset($this->current_user->id) && $this->current_user->id !== null){
            Messenger::create([
                'emetteur_id' => Auth::user()->id,
                'recepteur_id' => $this->current_user->id,
                'text'=> $this->form['text']
            ]);

            $this->astuce->addHistorique("Ajout Message", "add");
            $this->recent_message = $this->astuce->getLastedUsersDiscussions();

        $this->selectedMessages($this->current_user->id);

            $this->initForm();
            $this->trouve = false;
        }
    }

    public function seenMessage(){
        $messages = Messenger::where('recepteur_id', Auth::user()->id)->where('seen', 1)->get();
        if($messages != null){
            foreach ($messages as $message) {
                $message->seen = 0;
                $message->save();
            }
        }
        
    }

    public function selectedMessages($idReceved){
        $this->current_message = Messenger::where('recepteur_id', $idReceved)->Where('emetteur_id', Auth::user()->id)
            ->orWhere('emetteur_id', $idReceved)->Where('recepteur_id', Auth::user()->id)->orderBy('created_at', 'ASC')->get();
        // dd($this->current_message);
    }

    public function changeEvent(){
        $this->current_user = User::where('id', $this->idUser)->first();
        $this->selectedMessages($this->idUser);

        if($this->current_message == null){
            $this->current_message = null;
            // $this->idUser = null;
        }
        $this->trouve = false;
            foreach ($this->recent_message as $message) {
                // dd($message);
                if($message["recepteur_id"] == $this->current_user->id || $message["emetteur_id"] == $this->current_user->id){
                    $this->trouve = true;
                }
            }
    }

    public function selectEvent($idReceved){
        $this->current_user = User::where('id', $idReceved)->first();
        $this->selectedMessages($idReceved);
        foreach ($this->recent_message as $message) {
            if($message["recepteur_id"] === $idReceved || 
                $message["emetteur_id"] === $idReceved){
                $this->trouve = true;
            }else{
                $this->trouve = false;
            }
        }
    }

    public function render()
    {
        $this->astuce = new Astuce();
        $this->recent_message = $this->astuce->getLastedUsersDiscussions();
        $this->seenMessage();

        if(session('id_admin')){
            $this->idUser = (session('id_admin'));
            $this->current_user = User::where('id', $this->idUser)->first();
            $this->trouve = false;
            $this->selectedMessages($this->idUser);
        }
        
        return view('livewire.messages',[
            'users' => (Auth()->user()->role == "Super Admin") ? User::where('role', 'Super Admin')->orWhere('role', 'Admin')->where('id', '!=' ,Auth::user()->id)->get() : User::where('entreprise_id', Auth::user()->entreprise_id)->where('id', '!=' ,Auth::user()->id)->get(),
            ])->layout('layouts.app', [
            'title' => "Les Messages",
            "page" => "message",
            "icon" => "fa fa-envelope-open",
            "notification" => Messenger::where('recepteur_id', Auth()->user()->id)->where("seen", 1)->count(),
        ]);

    }

    public function mount(){
        if(!Auth::user()){
            return redirect(route('login'));
        }
    }
}
