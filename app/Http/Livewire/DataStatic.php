<?php

namespace App\Http\Livewire;

use App\Models\Astuce;
use App\Models\Messenger;
use App\Models\StaticData;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DataStatic extends Component
{
    public $data = [
        'icon' => 'fas fa-database',
        'title' => 'Données Statiques',
        'subtitle' => 'Liste des données statiques'
    ];

    public $form = [
        'type' => '',
        'valeur' => '',
        'id' => null,
    ];

    public $etat = 'list';
    public $types;
    public $entreprises;
    public $astuce;
    public $staticDatas;

    protected $rules =[
        'form.type' => 'required',
        'form.valeur' => 'required',
    ];

    protected $messages = [
        'form.type.required' => 'Type requis.',
        'form.valeur.required' => 'Valeur requise.',
    ];

    protected $listeners = ['remove'];

    public function alertConfirm()
    {
        $this->dispatchBrowserEvent('swal:confirm', [
                'type' => 'warning',
                'message' => 'Êtes-vous sûr?',
                'text' => 'Vouliez-vous supprimer?'
            ]);
    }

    public function remove()
    {
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Entreprise!',
            'text' => 'Suppression avec succès.'
        ]);
    }

    public function removeSpace($value)
    {
        $tab = explode(' ', $value);

        return implode("_", $tab);
    }

    public function addNew($type)
    {
        $this->etat = 'add';
        $this->form["type"] = $type;
        $this->data['subtitle'] = 'Ajout donnée statique';
    }

    public function edit($id)
    {
        $this->etat = 'add';
        $this->data['subtitle'] = 'Edition donnée statique';

        $sd = StaticData::where('id', $id)->first();

        $this->form['id'] = $sd->id;
        $this->form['type'] = $sd->type;
        $this->form['valeur'] = $sd->valeur;
    }

    public function save()
    {
        $this->validate();

        if($this->form['id']){
            $sd = StaticData::where('id', $this->form['id'])->first();
            $sd->type = $this->form['type'];
            $sd->entreprise_id = Auth::user()->entreprise_id;
            $sd->valeur = $this->form['valeur'];

            $sd->save();
            $this->dispatchBrowserEvent('updateSuccessful');

            $this->astuce->addHistorique("Edition d'une donnée statique", "update");
        }else{

            StaticData::create([
                'type' => $this->form['type'],
                'valeur' => $this->form['valeur'],
                'entreprise_id' => Auth::user()->entreprise_id,
                'statut' => 1,
            ]);
            $this->dispatchBrowserEvent('addSuccessful');

            $this->astuce->addHistorique("Ajout d'une donnée statique", "add");
        }

        $this->retour();
    }

    public function retour()
    {
        $this->etat = 'list';
        $this->initForm();
    }

    public function countFonction($type)
    {
        return StaticData::where('type', $type)
                    ->where('entreprise_id', Auth::user()->entreprise_id)
                    ->count();
    }

    public function delete($id)
    {
        $sd = StaticData::where('id', $id)->first();
        $sd->delete();

        $this->astuce->addHistorique("Suppression d'une donnée statique", "Suppression");
        $this->dispatchBrowserEvent('staticDataDeleted');

    }


    public function changeStatus($id)
    {
        $ds = StaticData::where('id', $id)->first();

        $ds->statut = $ds->statut === 0 ? 1 : 0;

        $ds->save();

        $this->dispatchBrowserEvent('statutUpdated');

        $this->astuce->addHistorique("Edition de le statut d'une donnée statique", "update");
    }

    public function render()
    {
        $this->astuce = new Astuce();
        $data = [];
        $staticDatas = StaticData::all()->groupBy('type');
        foreach ($staticDatas as $key => $value) {
            $data[$key] = $value;
        }

        $this->types = StaticData::where('entreprise_id', Auth::user()->entreprise_id)->orderBy('type', 'ASC')->distinct()->get('type');

        return view('livewire.admin.data-static', [
        'datas' => $data

        ])->layout('layouts.app', [
            'title' => "Données statiques",
            "page" => "staticData",
            "icon" => "fa fa-database",
            "notification" => Messenger::where('recepteur_id', Auth()->user()->id)->where("seen", 1)->count(),
        ]);
    }

    public function mount(){
        if(!Auth::user()){
            return redirect(route('login'));
        }
    }

    protected function initForm()
    {
        $this->form['type'] = "";
        $this->form['valeur'] = "";
        $this->form['entreprise_id'] = null;
    }
}
