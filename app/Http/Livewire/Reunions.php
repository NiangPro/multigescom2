<?php

namespace App\Http\Livewire;

use App\Models\Astuce;
use App\Models\Messenger;
use App\Models\Reunion;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Reunions extends Component
{
    public $status = "listReunions";
    public $current_meet;
    public $astuce;
    public $idDeleting;
    protected $listeners = ['remove'];
    public $events ;

    public $form = [
        'titre' => '',
        'date' => '',
        'description' => '',
        'entreprise_id' => '',
    ];

    protected $rules = [
        'form.titre' => 'required|string',
        'form.date' => 'required|date',
        'form.description' => 'required|string',
    ];

    protected $messages = [
        'form.titre.required' => 'Le nom est requis',
        'form.date.required' => 'La date est requis',
        'form.description.required' => 'la description est requise',
    ];

    public function changeEtat($etat){
        $this->status = $etat;
        $this->initForm();

        if($etat === "listReunions"){
            return redirect()->to('/reunions');
        }
    }

    public function initForm(){
        $this->form['id']=null;
        $this->form['titre']='';
        $this->form['description']='';
        $this->form['date']='';
    }

    public function getReunion($id){
        $this->status="editReunion";
        $this->initForm();

        $this->current_meet = Reunion::where('id', $id)->first();
        $this->form['id'] = $this->current_meet->id;
        $this->form['titre'] = $this->current_meet->titre;
        $this->form['description'] = $this->current_meet->description;
        $this->form['date'] = $this->current_meet->date;
    }

    // add end edit reunion
    public function store(){
        $this->validate();
        if (isset($this->current_meet->id) && $this->current_meet!== null) {
            $reunion = Reunion::where("id", $this->current_meet->id)->first();

            $reunion->titre = $this->form['titre'];
            $reunion->description = $this->form['description'];
            $reunion->date = $this->form['date'];

            $reunion->save();
            $this->astuce->addHistorique("Mis à jour reunin", "update");
            $this->dispatchBrowserEvent("addSuccessful");
            $this->status="listReunions";

            $this->initForm();
        }else{
            Reunion::create([
                'titre' => $this->form['titre'],
                'description' => $this->form['description'],
                'date' => $this->form['date'],
                'entreprise_id' => Auth::user()->entreprise_id,
            ]);

            $this->astuce->addHistorique("Ajout reunion", "add");
            $this->dispatchBrowserEvent("addSuccessful");
            return redirect()->to('/reunions');
            $this->status="listReunions";

            $this->initForm();
        }

    }

    public function delete($id){
        $this->idDeleting = $id;
        $this->alertConfirm();
    }

    public function alertConfirm()
    {
        $this->dispatchBrowserEvent('swal:confirm', [
            'type' => 'warning',
            'message' => 'Êtes-vous sûr?',
            'text' => 'Vouliez-vous supprimer?'
        ]);
    }

    // delete reunion
    public function remove(){
        $reunion = Reunion::where("id", $this->idDeleting->id)->first();
        $reunion->delete();

        $this->astuce->addHistorique('Suppression d\'une reunion', "delete");
        /* Write Delete Logic */

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Reunion',
            'text' => 'Suppression avec succéss!.'
        ]);

        $this->status="listReunions";
    }

    // calendrier


    // fin calendrier

    public function render()
    {
        $this->events = json_encode(Reunion::select("id", "date","description as title")->get());
        $this->astuce = new Astuce();
        return view('livewire.commercial.reunions',
            [
                "reunions" => Reunion::where('entreprise_id',Auth::user()->entreprise_id)->orderBy('id', 'DESC')->get(),
                // "events" => $this->astuce->getReunions()
            ]
        )->layout('layouts.app', [
            'title' => "Réunions",
            "page" => "reunion",
            "icon" => "fa fa-handshake",
            "notification" => Messenger::where('recepteur_id', Auth()->user()->id)->where("seen", 1)->count(),
        ]);
    }

    public function mount(){
        if(!Auth::user()){
            return redirect(route('login'));
        }
        if (!Auth()->user()->isOpen()) {
            return redirect(route('home'));
        }

    }
}
