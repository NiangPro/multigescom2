<?php

namespace App\Http\Livewire;



use App\Models\Astuce;
use App\Models\Entreprise;
use App\Models\Historique;
use App\Models\Messenger;
use App\Models\ParamAbonnement;
use App\Models\PayTech;
use App\Models\Todolist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Home extends Component
{
    use WithFileUploads, WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $astuce;
    public $allClients;
    public $todo = "list";
    public $current_todo;
    public $pageName;
    public $etat = "ventes";
    public $allVentes;
    public $allDepenses;
    public $allPropsects;
    public $allFournisseurs;
    public $depenses;
    public $ventes;
    public $today;
    public $dayclose;
    public $dayleft = 30;
    public $print;
    public $idDeleting;
    public $paytech;
    public $renew;
    public $total = 0;
    public $abmt;

    public $formAbmt =[
        "type" => "mois",
        "nombre" => 1,
    ];

    public $dataSuperAdmin = [
        'nbreEntreprise',
        'nbreSuperAdmin',
        'nbreAdmin',
    ];

    public $dataAdmin = [
        'nbreVente',
        'nbreDevis',
        'nbreClient',
        'nbreProduit',
    ];

    public $dataCommercial = [
        'nbreProspect',
        'nbreFournisseur',
    ];

    public $dataComptable = [
        'venteMonth',
        'depenseMonth',
        'totalVente',
    ];

    public $dataEmploye = [
        'nbreTache',
        'nbreReunion',
        'nbreHistorique',
    ];


    public $todoForm = [
        'id'=>null,
        'titre'=>'',
        'date'=>'',
        'statut'=>'',
        'user_id'=>null
    ];

    protected $rules = [
        'todoForm.titre' => 'required|string',
        'todoForm.date' => 'required|string',
        'todoForm.statut' => 'required|string',
    ];

    protected $messages = [
        'todoForm.titre' => 'Le titre est requis',
        'todoForm.date' => 'La date est requise',
        'todoForm.statut' => 'Le statut est requis',
    ];

    protected $listeners = ['remove'];

    public function changeEtat($etat){
        $this->etat =  $etat;
    }

    public function lunchRenew()
    {
        $this->renew = 1;
    }

    public function resetRenew()
    {
        $this->renew = 0;
    }

    public function formadd()
    {
        $this->todo = "add";
    }

    function backTodoAdmin()
    {
        $this->todo = $this->etat == "add"? "list":"add";
    }

    public function backTodo()
    {
        $this->todo = $this->etat == "add"? "list":"add";

    }

    public function changeAbmt()
    {
        if ($this->formAbmt["type"] == "mois") {
            $this->total = $this->abmt->mensuel * $this->formAbmt['nombre'];
        }else{
            $this->total = $this->abmt->annuel * $this->formAbmt['nombre'];
        }
    }

    public function payer(){
        $response = $this->paytech->send($this->total, uniqid());

        if (isset($response["success"])) {
            
            Session::flash("type", $this->formAbmt["type"]);
            Session::flash("nombre", $this->formAbmt['nombre']);
            
            return redirect()->away($response["redirect_url"]);
        }

        if (isset($response["errors"])) {
            $this->dispatchBrowserEvent('display-errors', [
                'errors' => $response["errors"],
            ]);
        }
    }

    public function getTodo($id){
        $this->todoFormInit();
        $this->current_todo = Todolist::where('id', $id)->first();

        $this->todoForm['titre']=$this->current_todo->titre;
        $this->todoForm['date']=$this->current_todo->date;
        $this->todoForm['statut']=$this->current_todo->statut;
        $this->todoForm['user_id']=$this->current_todo->user_id;
        $this->todo = "add";
    }

    public function addTodo(){
        $this->validate();
        if(isset($this->current_todo->id) && $this->current_todo->id!==null){
            $this->current_todo->titre = $this->todoForm['titre'];
            $this->current_todo->date = $this->todoForm['date'];
            $this->current_todo->statut = $this->todoForm['statut'];

            $this->current_todo->save();

            $this->astuce->addHistorique("Mis à jour des informations à faire", "update");

            $this->dispatchBrowserEvent("updateSuccessful");
            $this->getTodo($this->current_todo->id);

            $this->todo = "list";
        }else{
            Todolist::create([
                'titre' => $this->todoForm['titre'],
                'date' => $this->todoForm['date'],
                'statut' => $this->todoForm['statut'],
                'user_id'=> Auth()->user()->id,
            ]);

            $this->astuce->addHistorique("Ajout à faire ->".$this->todoForm['titre'], "add");

            $this->dispatchBrowserEvent("addSuccessful");
            $this->todoFormInit();

            $this->todo = "list";
        }
    }

    public function delete($id)
    {
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

    public function remove()
    {

        $todolist = Todolist::where('id', $this->idDeleting)->first();
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'A faire!',
                'text' => 'Suppression avec succès.'
            ]);

            $todolist->delete();
            $this->todo= "list";

    }

    public function todoFormInit(){
        $this->todoForm['id']=null;
        $this->todoForm['titre']='';
        $this->todoForm['date']='';
        $this->todoForm['statut']='';
        $this->todoForm['user_id']=null;
    }


    public function render()
    {
        $this->astuce = new Astuce();
        $this->paytech = new PayTech();
      
        

        $this->dataSuperAdmin['nbreEntreprise'] = count($this->astuce->entreprises());
        $this->dataSuperAdmin['nbreSuperAdmin'] = count($this->astuce->superAdmins());
        $this->dataSuperAdmin['nbreAdmin'] = count($this->astuce->admins());

        // dataCountAdmin
        $this->dataAdmin['nbreVente'] = count($this->astuce->ventes());
        $this->dataAdmin['nbreDevis'] = count($this->astuce->devis());
        $this->dataAdmin['nbreClient'] = count($this->astuce->clients());
        $this->dataAdmin['nbreProduit'] = count($this->astuce->produits());
        $this->allVentes = $this->astuce->getVentes();
        $this->allDepenses = $this->astuce->getDepenses();

        // data Dashboard commercial
        $this->dataCommercial['nbreProspect'] = count($this->astuce->prospects());
        $this->dataCommercial['nbreFournisseur'] = count($this->astuce->fournisseurs());
        $this->allClients = $this->astuce->getClient();
        $this->allFournisseurs = $this->astuce->getFournisseur();

        // data Dashboard comptable
        $this->dataComptable['venteMonth'] = $this->astuce->getVenteByCurrentMonth();
        $this->dataComptable['depenseMonth'] = $this->astuce->getDepenseByCurrentMonth();
        $this->dataComptable['totalVente'] = $this->astuce->getTotalVente();
        $this->depenses = $this->astuce->getDepenses();
        $this->ventes = $this->astuce->getVentes();

        // data Dashboard employe
        $this->dataEmploye['nbreTache'] = count($this->astuce->taches());
        $this->dataEmploye['nbreReunion'] = count($this->astuce->reunions());
        $this->dataEmploye['nbreHistorique'] = count($this->astuce->historiques());

        // $hitory = Historique::orderBy('id', 'DESC')->where('user_id', Auth()->user()->id)->get();
        // dd($hitory);

        return view('livewire.home.'.$this->pageName, [
            'todolists' => Todolist::orderBy('id', 'DESC')->where('user_id', Auth()->user()->id)->paginate(5),
            'historiques' => Historique::orderBy('id', 'DESC')->where('user_id', Auth()->user()->id)->limit(3)->get()
        ])->layout('layouts.app', [
            'title' => "Tableau de bord",
            "page" => "home",
            "icon" => "fas fa-fire",
            "notification" => Messenger::where('recepteur_id', Auth()->user()->id)->where("seen", 1)->count(),
        ]);
    }

    public function mount(){
        
        if(!Auth::user()){
            return redirect(route('login'));
        }

        $this->astuce = new Astuce();
        if (Auth::user()->role === "Super Admin") {
            $this->astuce->initCountries();
            $this->pageName = "home";
        }elseif(Auth::user()->role === "Commercial"){
            $this->pageName = "home-commercial";

        }elseif(Auth::user()->role === "Admin"){
            $this->pageName = "home-admin";

        }elseif(Auth::user()->role === "Comptable"){
            $this->pageName = "home-comptable";

        }else{
            $this->pageName = "home-employe";
        }

        $this->abmt = ParamAbonnement::first();

        $this->total = $this->abmt->mensuel;

        if(isset(Auth::user()->entreprise_id) && Auth::user()->entreprise_id !== null){
            if(Auth::user()->isAdmin()){
                $this->today = Auth::user()->entreprise->fermeture;
                $this->dayclose = Auth::user()->entreprise->fermeture;

                $this->today = strtotime($this->today) - 86400*5;
                $this->today = date("d-m-Y",$this->today);

                $this->dayclose = strtotime($this->dayclose) + 86400*10;
                $this->dayclose = date("d-m-Y",$this->dayclose);

                if( date('Y-m-d') >= date('Y-m-d', strtotime($this->today)) && date('Y-m-d', strtotime(Auth::user()->entreprise->fermeture)) >= date('Y-m-d') ){
                    $this->print = "before";
                }elseif( date('Y-m-d') >= date('Y-m-d', strtotime(Auth::user()->entreprise->fermeture)) &&  date('Y-m-d', strtotime($this->dayclose))> date('Y-m-d') ){
                    $this->dayleft = intval(date('d',strtotime($this->dayclose))) - intval(date('d'));
                    $this->print = "after";
                }


                if(date('Y-m-d', strtotime($this->dayclose))<= date('Y-m-d')){
                    $en = Entreprise::where("id", Auth::user()->entreprise_id)->first();
                    
                    $en->statut = 0;
                        $en->save();
                    
                }
            }
        }

    }
}
