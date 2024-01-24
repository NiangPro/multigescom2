<?php

namespace App\Models;

use App\Http\Livewire\Reunions;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Astuce extends Model
{
    use HasFactory;

    public function createEntrepriseDemo()
    {
        $entreprise = Entreprise::where("nom", "Demo")->first();

        if(!$entreprise){
            Entreprise::create([
                'nom' =>'Demo',
                'sigle' =>'DM',
                'tel' =>'777777777',
                'email' =>'demo@gmail.com',
                'adresse' =>'Senegal',
                'statut' =>1,
                'fermeture' =>'2045-12-03',
                'profil' =>'company.png',
            ]);

            $entreprise = Entreprise::where("nom", "Demo")->first();
            $this->initStaticData();

            User::create([
                'nom'=>'Demo',
                'prenom'=>'Demo',
                'role'=>'Admin',
                'email'=>'demo@gmail.com',
                'tel'=>'788888888',
                'sexe'=>'Femme',
                'profil' => "user-female.png",
                'entreprise_id'=>$entreprise->id,
                'password'=>'$2y$10$/0sIDpuFUIn7EnnM.8RhTuHW4z5Yd4k/pduWLp5QZnPjbwb2qvM8a',//demo@1
            ]);
        }
    }

    public function taches(){
        return Tache::orderBy('id', 'DESC')->get();
    }

    public function historiques(){
        return Historique::orderBy('id', 'DESC')->get();
    }

    public function reunions(){
        return Reunion::orderBy('id', 'DESC')->get();
    }

    // vente du mois actuel
    public function getTotalVente(){
        $som = 0;
        $ventes = Vente::where('entreprise_id', Auth()->user()->entreprise_id)->select([
            DB::raw("DATE_FORMAT(date, '%Y') as year"),
            DB::raw("count('*') as nombre")])->groupBy('year')->get();

            foreach ($ventes as $vente) {
                if (intval(date("Y")) === intval($vente->year)) {
                    $som = $vente['nombre'];
                }
            }
            return $som ;
    }

    // vente du mois actuel
    public function getVenteByCurrentMonth(){
        $som = 0;
        $ventes = Vente::where('entreprise_id', Auth()->user()->entreprise_id)->select([
            DB::raw("DATE_FORMAT(date, '%m') as month"),
            DB::raw("DATE_FORMAT(date, '%Y') as year"),
            DB::raw("count('*') as nombre")])->groupBy('month')->groupBy('year')->get();

            foreach ($ventes as $vente) {
                if (intval(date("m")) === intval($vente->month)) {
                    $som = $vente['nombre'];
                }
            }
            return $som ;
    }

    // depense du mois actuel
    public function getDepenseByCurrentMonth(){
        $som = 0;
        $depenses = Depense::where('entreprise_id', Auth()->user()->entreprise_id)->select([
            DB::raw("DATE_FORMAT(date, '%m') as month"),
            DB::raw("DATE_FORMAT(date, '%Y') as year"),
            DB::raw("count('*') as nombre")])->groupBy('month')->groupBy('year')->get();

            foreach ($depenses as $vente) {
                if (intval(date("m")) === intval($vente->month)) {
                    $som = $vente['nombre'];
                }
            }
            return $som ;
    }

    // les fournisseurs de l'année par mois
    public function getFournisseur(){
        $data = [];
        $fournisseurs = Fournisseur::where('entreprise_id', Auth()->user()->entreprise_id)->select([
            DB::raw("DATE_FORMAT(created_at, '%m') as month"),
            DB::raw("DATE_FORMAT(created_at, '%Y') as year"),
            DB::raw("count('*') as nombre")])->groupBy('month')->groupBy('year')->get();

            for($i=1; $i<=intval(date("m")); $i++){
                $som = 0;
                foreach ($fournisseurs as $r) {
                    if($i==$r['month']){
                        $som= $r['nombre'];
                        break;
                    }
                }
                $data[] = $som;
            }
        return json_encode($data);
    }

    // les clients de l'année par mois
    public function getClient(){
        $data = [];
        $clients = Client::where('entreprise_id', Auth()->user()->entreprise_id)->select([
            DB::raw("DATE_FORMAT(created_at, '%m') as month"),
            DB::raw("DATE_FORMAT(created_at, '%Y') as year"),
            DB::raw("count('*') as nombre")])->groupBy('month')->groupBy('year')->get();

            for($i=1; $i<=intval(date("m")); $i++){
                $som = 0;
                foreach ($clients as $r) {
                    if($i==$r['month']){
                        $som= $r['nombre'];
                        break;
                    }
                }
                $data[] = $som;
            }
        return json_encode($data);
    }

    public function fournisseurs(){
        return Fournisseur::orderBy('id', 'DESC')->get();
    }

    public function prospects(){
        return Prospect::orderBy('id', 'DESC')->get();
    }

    public function ventes(){
        return Vente::where('entreprise_id', Auth()->user()->entreprise_id)->orderBy('id', 'DESC')->get();
    }

    public function clients(){
        return Client::where('entreprise_id', Auth()->user()->entreprise_id)->orderBy('id', 'DESC')->get();
    }

    public function devis(){
        return Devis::where('entreprise_id', Auth()->user()->entreprise_id)->orderBy('id', 'DESC')->get();
    }

    public function produits(){
        return Produit::where('entreprise_id', Auth()->user()->entreprise_id)->orderBy('id', 'DESC')->get();
    }

    public function getLastedUsersDiscussions()
    {
        $data = [];
        $messages = Messenger::where("emetteur_id", Auth::user()->id)->orWhere("recepteur_id", Auth::user()->id)->orderBy("created_at", "DESC")->get();

        foreach($messages as $m){
            $trouve = false;
            foreach($data as $d){
                if(($d['recepteur_id'] === $m->recepteur_id && $d['emetteur_id'] === $m->emetteur_id)  || ($d['emetteur_id'] === $m->recepteur_id && $d['recepteur_id'] === $m->emetteur_id)){
                    $trouve = true;
                    break;
                }
            }

            if($trouve === false){
                $data[] = $m;
            }
        }

        return ($data);
    }

    public function getStaticData($type)
    {
        return StaticData::where("type", $type)
            ->where("entreprise_id", Auth::user()->entreprise_id)
            ->where("statut", 1)
            ->get();
    }

    public function addHistorique($description, $type)
    {
        Historique::create([
            'description' => $description,
            'type' => $type,
            'user_id' => Auth::user()->id,
            'date' => new DateTime(),
        ]);
    }

    public function searchByDate($type, $start, $end){
        $val=0;
        if($type == 'Depense'){
            $tab = Depense::where('entreprise_id', Auth()->user()->entreprise_id)->where('date', '>=', $start)->where('date', '<=', $end)
                ->select([
                    DB::raw("SUM(montant) as amount"),
                    DB::raw("DATE_FORMAT(date, '%m') as month"),
                    DB::raw("DATE_FORMAT(date, '%Y') as year"),])
                ->groupBy('month')->groupBy('year')->get();
                if(!empty($tab)){
                    foreach ($tab as $r) {
                        $val= $r['amount'];
                    }
                }
        }elseif($type ==='Vente'){
            $tab = Vente::where('entreprise_id', Auth()->user()->entreprise_id)->where('date', '>=', $start)->where('date', '<=', $end)
                ->select([DB::raw("SUM(montant) as amount"),
                DB::raw("DATE_FORMAT(date, '%m') as month"),
                DB::raw("DATE_FORMAT(date, '%Y') as year"),])->groupBy('month')->groupBy('year')->get();
                if(!empty($tab)){
                    foreach ($tab as $r) {
                        $val= $r['amount'];
                    }
                }
        }
        return $val;
    }

    public function sumSale()
    {


        $ventes = Vente::select(DB::raw('distinct Sum(montant) as somme, Month(date) as mois'))
            ->groupBy(DB::raw("Month(date)"))->orderBy(DB::raw("MONTH(date)"), "ASC")
            ->get();

        $som = 0;

        $moisActuel = intval(date('m'));

        foreach ($ventes as $vente) {
            if ($moisActuel === $vente->mois) {
                $som = $vente->somme;
                break;
            }
        }
        return $som;
    }

    public function sumDepense()
    {
        $Depenses = Depense::select(DB::raw('distinct Sum(montant) as somme, Month(date) as mois'))
            ->groupBy(DB::raw("Month(date)"))->orderBy(DB::raw("MONTH(date)"), "ASC")->get();

        $som = 0;

        $moisActuel = intval(date('m'));

        foreach ($Depenses as $exp) {
            if ($moisActuel === $exp->mois) {
                $som = $exp->somme;
                break;
            }
        }
        return $som;
    }

    public function saleByMonth()
    {
        $ventes = Vente::select(DB::raw('distinct Sum(total_amount) as somme, Month(date) as mois'))
        ->groupBy(DB::raw("Month(date)"))->orderBy(DB::raw("MONTH(date)"), "ASC")->get();


        $data = [];


        $moisActuel = intval(date('m'));

        for ($i = 1; $i <= $moisActuel; $i++) {
            $som = 0;
            foreach ($ventes as $vente) {
                if ($i === $vente->mois) {
                    $som = $vente->somme;
                    break;
                }
            }
            $data[] = $som;
        }

        // for ($i = 12 - $moisActuel; $i <= 12; $i++) {
        //     $data[] = 0;
        // }

        return json_encode($data);
    }

    public function DepenseByMonth()
    {
        $Depenses = Depense::select(DB::raw('distinct Sum(montant) as somme, Month(date) as mois'))
        ->groupBy(DB::raw("Month(date)"))->orderBy(DB::raw("MONTH(date)"), "ASC")->get();

        $data = [];


        $moisActuel = intval(date('m'));

        for ($i = 1; $i <= $moisActuel; $i++) {
            $som = 0;
            foreach ($Depenses as $exp) {
                if ($i === $exp->mois) {
                    $som = $exp->somme;
                    break;
                }
            }
            $data[] = $som;
        }

        return json_encode($data);
    }

    public function getReunions()
    {
        $data = [];

        $reunions = Reunion::all();
        foreach ($reunions as $r) {
            if ($r->entreprise_id === Auth()->user()->entreprise_id) {

                array_push($data, [
                    'id' => $r->id,
                    'title' => $r->title,
                    'start' => $r->date,
                    'end' => null
                ]);
            }

        }
        return json_encode($data);
    }

    public function getDepenses()
    {
        $data = [];
        // $i=1;
        $depenses = Depense::where('entreprise_id', Auth()->user()->entreprise_id)->select([
            DB::raw("DATE_FORMAT(date, '%m') as month"),
            DB::raw("DATE_FORMAT(date, '%Y') as year"),
            DB::raw("SUM(montant) as amount")])->groupBy('month')->groupBy('year')->get();
            // dd(intval(date("m")));
            for($i=1; $i<=intval(date("m")); $i++){
                $som = 0;
                foreach ($depenses as $r) {
                    // dd("moi=".$r['month']."  i=".$i);
                    if($i==$r['month']){
                        $som= $r['amount'];
                        break;
                    }
                }
                $data[] = $som;
            }

        return json_encode($data);
    }

    public function getDepensesMonth()
    {
        $data = 0;
        // $i=1;
        $depenses = Depense::where('entreprise_id', Auth()->user()->entreprise_id)->select([
            DB::raw("DATE_FORMAT(date, '%m') as month"),
            DB::raw("DATE_FORMAT(date, '%Y') as year"),
            DB::raw("SUM(montant) as amount")])->groupBy('month')->groupBy('year')->get();

                foreach ($depenses as $r) {
                    if(intval(date("m")) == $r['month']){
                        $data = $r['amount'];
                        break;
                    }
                }
                // dd($data);

            return json_encode($data);
    }

    public function getVentes(){
        $data = [];
        $ventes = Vente::where('entreprise_id', Auth()->user()->entreprise_id)->select([
            DB::raw("DATE_FORMAT(date, '%m') as month"),
            DB::raw("DATE_FORMAT(date, '%Y') as year"),
            DB::raw("SUM(montant) as amount")])->groupBy('month')->groupBy('year')->get();

            for($i=1; $i<=intval(date("m")); $i++){
                $som = 0;
                foreach ($ventes as $r) {
                    if($i==$r['month']){
                        $som= $r['amount'];
                        break;
                    }
                }
                $data[] = $som;
            }
        return json_encode($data);
    }

    public function getVentesMonth()
    {
        $data = 0;
        // $i=1;
        $ventes = Vente::where('entreprise_id', Auth()->user()->entreprise_id)->select([
            DB::raw("DATE_FORMAT(date, '%m') as month"),
            DB::raw("DATE_FORMAT(date, '%Y') as year"),
            DB::raw("SUM(montant) as amount")])->groupBy('month')->groupBy('year')->get();

                foreach ($ventes as $r) {
                    if(intval(date("m")) == $r['month']){
                        $data = $r['amount'];
                    break;
                }

            }
        return json_encode($data);
    }

    public function createFirstSuperAdmin()
    {
        $countUser = User::count();

        if($countUser < 1){
            Entreprise::create([
                'nom' =>'SuperAdmin',
                'sigle' =>'SAM',
                'tel' =>'777777777',
                'email' =>'demo@gmail.com',
                'adresse' =>'Senegal',
                'statut' =>1,
                'fermeture' =>'3045-12-03',
                'profil' =>'company.png',
            ]);

            $entreprise = Entreprise::where("nom", "SuperAdmin")->first();

            User::create([
                'nom'=>"Niang",
                'prenom'=>"Bassirou",
                'role'=>"Super Admin",
                'email'=>"NiangProgrammeur@gmail.com",
                'tel'=>"783123657",
                'sexe'=>"Homme",
                'profil' => "user-male.png",
                'entreprise_id'=>$entreprise->id,
                'password'=>'$2y$10$rAVZ/DGGDV5KooV1NqJ48Om35GkkYcqFd/lAkehgzA3.D5A5YcrtC',
            ]);
        }
    }

    public function superAdmins()
    {
        return User::where('role', 'Super Admin')->orderBy('prenom', 'ASC')->paginate(8);
    }

    public function admins()
    {
        return User::where('role', 'Admin')->orderBy('id', 'DESC')->paginate(8);
    }

    public function commercials()
    {
        return User::where('role', 'Commercial')->where('entreprise_id', Auth()->user()->entreprise_id)->orderBy('id', 'DESC')->paginate(3);
    }

    public function comptables()
    {
        return User::where('role', 'Comptable')->where('entreprise_id', Auth()->user()->entreprise_id)->orderBy('id', 'DESC')->paginate(3);
    }

    public function entreprises()
    {
        return Entreprise::orderBy('nom', 'ASC')->get();
    }

    public function employes()
    {
        return User::where('role', "Employe")->where('entreprise_id', Auth()->user()->entreprise_id)->orderBy("Prenom", "ASC")->get();
    }

    public function superAdminHistorique()
    {
        $data = [];

        $users = User::orderBy('prenom', 'DESC')->get();

        foreach ($users as $user) {
            if ($user->role === "Super Admin") {
                foreach ($user->historiques as $histo) {
                    $data[] = $histo;
                }
            }
        }

        return $data;
    }

    public function adminHistorique()
    {
        $data = [];

        $users = User::orderBy('prenom', 'DESC')->get();

        foreach ($users as $user) {
            if ($user->role !== "Super Admin" && $user->entreprise_id === Auth::user()->entreprise_id) {
                foreach ($user->historiques as $histo) {
                    $data[] = $histo;
                }
            }
        }

        return $data;
    }


    public function initStaticData()
    {
        $tab =[
            ['Type de fonction', 'Community Manager'],
            ['Type de dépense', 'Facture Sen eau'],
            ['Type de dépense', 'Facture Senelec'],
            ['Source du prospect', 'Réseaux sociaux'],
            ['Source du prospect', 'Courriers et appels'],
            ['Source du prospect', 'Site Web'],
            ['Source du prospect', 'Visite bureau'],
            ['Source du prospect', 'Autres'],
            ['Statut du prospect', 'Nouveau'],
            ['Statut du prospect', 'Proposition'],
            ['Statut du prospect', 'En cours'],
            ['Statut du prospect', 'Complet'],
            ['Mode de paiement', 'En espèces'],
            ['Mode de paiement', 'Chèque'],
            ['Mode de paiement', 'Orange Money'],
            ['Mode de paiement', 'Wave'],
            ['Type des produits et services', 'Produit'],
            ['Type des produits et services', 'Service'],
            ['Statut des devis', 'Envoyé'],
            ['Statut des devis', 'Validé'],
            ['Statut des devis', 'Brouillon'],
            ['Priorité des tâches', 'Haute'],
            ['Priorité des tâches', 'Moyen'],
            ['Priorité des tâches', 'Faible'],
            ['Priorité des tâches', 'Urgent'],
            ['Priorité des tâches', 'Aucun'],
            ['Statut de la tâche', 'En attente'],
            ['Statut de la tâche', 'En cours'],
            ['Statut de la tâche', 'Terminé'],
            ['TVA', '0'],
            ['TVA', '18'],

        ];

        $last = Entreprise::orderBy('id', 'DESC')->first();

        foreach ($tab as $sds) {
            StaticData::create([
                    'type' => $sds[0],
                    'valeur' => $sds[1],
                    'entreprise_id' => $last->id,
                ]);
        }
    }

    public function initCountries()
    {
        $countPays = Country::count();
        if($countPays === 0){
            $pays = [
                ['AF', 'AFG', 'Afghanistan', 'Afghanistan'],
                ['AL', 'ALB', 'Albania', 'Albanie'],
                ['AQ', 'ATA', 'Antarctica', 'Antarctique'],
                ['DZ', 'DZA', 'Algeria', 'Algérie'],
                ['AS', 'ASM', 'American Samoa', 'Samoa Américaines'],
                ['AD', "AND", 'Andorra', 'Andorre'],
                ['AO', 'AGO', 'Angola', 'Angola'],
                ['AG', 'ATG', 'Antigua and Barbuda', 'Antigua-et-Barbuda'],
                ['AZ', 'AZE', 'Azerbaijan', 'Azerbaïdjan'],
                [ 'AR', 'ARG', 'Argentina', 'Argentine'],
                [ 'AU', 'AUS', 'Australia', 'Australie'],
                [ 'AT', 'AUT', 'Austria', 'Autriche'],
                [ 'BS', 'BHS', 'Bahamas', 'Bahamas'],
                [ 'BH', 'BHR', 'Bahrain', 'Bahreïn'],
                [ 'BD', 'BGD', 'Bangladesh', 'Bangladesh'],
                [ 'AM', 'ARM', 'Armenia', 'Arménie'],
                [ 'BB', 'BRB', 'Barbados', 'Barbade'],
                [ 'BE', 'BEL', 'Belgium', 'Belgique'],
                [ 'BM', 'BMU', 'Bermuda', 'Bermudes'],
                [ 'BT', 'BTN', 'Bhutan', 'Bhoutan'],
                [ 'BO', 'BOL', 'Bolivia', 'Bolivie'],
                [ 'BA', 'BIH', 'Bosnia and Herzegovina', 'Bosnie-Herzégovine'],
                [ 'BW', 'BWA', 'Botswana', 'Botswana'],
                ['BV', 'BVT', 'Bouvet Island', 'Île Bouvet'],
                ['BR', 'BRA', 'Brazil', 'Brésil'],
                ['BZ', 'BLZ', 'Belize', 'Belize'],
                ['IO', 'IOT', 'British Indian Ocean Territory', 'Territoire Britannique de l\'Océan Indien'],
                ['SB', 'SLB', 'Solomon Islands', 'Îles Salomon'],
                ['VG', 'VGB', 'British Virgin Islands', 'Îles Vierges Britanniques'],
                ['BN', 'BRN', 'Brunei Darussalam', 'Brunéi Darussalam'],
                ['BG', 'BGR', 'Bulgaria', 'Bulgarie'],
                ['MM', 'MMR', 'Myanmar', 'Myanmar'],
                ['BI', 'BDI', 'Burundi', 'Burundi'],
                ['BY', 'BLR', 'Belarus', 'Bélarus'],
                ['KH', 'KHM', 'Cambodia', 'Cambodge'],
                ['CM', 'CMR', 'Cameroon', 'Cameroun'],
                ['CA', 'CAN', 'Canada', 'Canada'],
                ['CV', 'CPV', 'Cape Verde', 'Cap-vert'],
                ['KY', 'CYM', 'Cayman Islands', 'Îles Caïmanes'],
                ['CF', 'CAF', 'Central African', 'République Centrafricaine'],
                ['LK', 'LKA', 'Sri Lanka', 'Sri Lanka'],
                ['TD', 'TCD', 'Chad', 'Tchad'],
                ['CL', 'CHL', 'Chile', 'Chili'],
                ['CN', 'CHN', 'China', 'Chine'],
                ['TW', 'TWN', 'Taiwan', 'Taïwan'],
                ['CX', 'CXR', 'Christmas Island', 'Île Christmas'],
                ['CC', 'CCK', 'Cocos (Keeling) Islands', 'Îles Cocos (Keeling)'],
                ['CO', 'COL', 'Colombia', 'Colombie'],
                ['KM', 'COM', 'Comoros', 'Comores'],
                ['YT', 'MYT', 'Mayotte', 'Mayotte'],
                ['CG', 'COG', 'Republic of the Congo', 'République du Congo'],
                ['CD', 'COD', 'The Democratic Republic Of The Congo', 'République Démocratique du Congo'],
                ['CK', 'COK', 'Cook Islands', 'Îles Cook'],
                ['CR', 'CRI', 'Costa Rica', 'Costa Rica'],
                ['HR', 'HRV', 'Croatia', 'Croatie'],
                ['CU', 'CUB', 'Cuba', 'Cuba'],
                ['CY', 'CYP', 'Cyprus', 'Chypre'],
                ['CZ', 'CZE', 'Czech Republic', 'République Tchèque'],
                ['BJ', 'BEN', 'Benin', 'Bénin'],
                ['DK', 'DNK', 'Denmark', 'Danemark'],
                ['DM', 'DMA', 'Dominica', 'Dominique'],
                ['DO', 'DOM', 'Dominican Republic', 'République Dominicaine'],
                ['EC', 'ECU', 'Ecuador', 'Équateur'],
                ['SV', 'SLV', 'El Salvador', 'El Salvador'],
                ['GQ', 'GNQ', 'Equatorial Guinea', 'Guinée Équatoriale'],
                ['ET', 'ETH', 'Ethiopia', 'Éthiopie'],
                ['ER', 'ERI', 'Eritrea', 'Érythrée'],
                ['EE', 'EST', 'Estonia', 'Estonie'],
                ['FO', 'FRO', 'Faroe Islands', 'Îles Féroé'],
                ['FK', 'FLK', 'Falkland Islands', 'Îles (malvinas) Falkland'],
                ['GS', 'SGS', 'South Georgia and the South Sandwich Islands', 'Géorgie du Sud et les Îles Sandwich du Sud'],
                ['FJ', 'FJI', 'Fiji', 'Fidji'],
                ['FI', 'FIN', 'Finland', 'Finlande'],
                ['AX', 'ALA', 'Åland Islands', 'Îles Åland'],
                ['FR', 'FRA', 'France', 'France'],
                ['GF', 'GUF', 'French Guiana', 'Guyane Française'],
                ['PF', 'PYF', 'French Polynesia', 'Polynésie Française'],
                ['TF', 'ATF', 'French Southern Territories', 'Terres Australes Françaises'],
                ['DJ', 'DJI', 'Djibouti', 'Djibouti'],
                ['GA', 'GAB', 'Gabon', 'Gabon'],
                ['GE', 'GEO', 'Georgia', 'Géorgie'],
                ['GM', 'GMB', 'Gambia', 'Gambie'],
                ['PS', 'PSE', 'Occupied Palestinian Territory', 'Territoire Palestinien Occupé'],
                ['DE', 'DEU', 'Germany', 'Allemagne'],
                ['GH', 'GHA', 'Ghana', 'Ghana'],
                ['GI', 'GIB', 'Gibraltar', 'Gibraltar'],
                ['KI', 'KIR', 'Kiribati', 'Kiribati'],
                ['GR', 'GRC', 'Greece', 'Grèce'],
                ['GL', 'GRL', 'Greenland', 'Groenland'],
                ['GD', 'GRD', 'Grenada', 'Grenade'],
                ['GP', 'GLP', 'Guadeloupe', 'Guadeloupe'],
                ['GU', 'GUM', 'Guam', 'Guam'],
                ['GT', 'GTM', 'Guatemala', 'Guatemala'],
                ['GN', 'GIN', 'Guinea', 'Guinée'],
                ['GY', 'GUY', 'Guyana', 'Guyana'],
                ['HT', 'HTI', 'Haiti', 'Haïti'],
                ['HM', 'HMD', 'Heard Island and McDonald Islands', 'Îles Heard et Mcdonald'],
                ['VA', 'VAT', 'Vatican City State', 'Saint-Siège (état de la Cité du Vatican)'],
                ['HN', 'HND', 'Honduras', 'Honduras'],
                ['HK', 'HKG', 'Hong Kong', 'Hong-Kong'],
                ['HU', 'HUN', 'Hungary', 'Hongrie'],
                ['IS', 'ISL', 'Iceland', 'Islande'],
                ['IN', 'IND', 'India', 'Inde'],
                ['ID', 'IDN', 'Indonesia', 'Indonésie'],
                ['IR', 'IRN', 'Islamic Republic of Iran', 'République Islamique d\'Iran'],
                ['IQ', 'IRQ', 'Iraq', 'Iraq'],
                ['IE', 'IRL', 'Ireland', 'Irlande'],
                ['IL', 'ISR', 'Israel', 'Israël'],
                ['IT', 'ITA', 'Italy', 'Italie'],
                ['CI', 'CIV', 'Côte d\'Ivoire', 'Côte d\'Ivoire'],
                ['JM', 'JAM', 'Jamaica', 'Jamaïque'],
                ['JP', 'JPN', 'Japan', 'Japon'],
                ['KZ', 'KAZ', 'Kazakhstan', 'Kazakhstan'],
                ['JO', 'JOR', 'Jordan', 'Jordanie'],
                ['KE', 'KEN', 'Kenya', 'Kenya'],
                ['KP', 'PRK', 'Democratic People\'s Republic of Korea', 'République Populaire Démocratique de Corée'],
                ['KR', 'KOR', 'Republic of Korea', 'République de Corée'],
                ['KW', 'KWT', 'Kuwait', 'Koweït'],
                ['KG', 'KGZ', 'Kyrgyzstan', 'Kirghizistan'],
                ['LA', 'LAO', 'Lao People\'s Democratic Republic', 'République Démocratique Populaire Lao'],
                ['LB', 'LBN', 'Lebanon', 'Liban'],
                ['LS', 'LSO', 'Lesotho', 'Lesotho'],
                ['LV', 'LVA', 'Latvia', 'Lettonie'],
                ['LR', 'LBR', 'Liberia', 'Libéria'],
                ['LY', 'LBY', 'Libyan Arab Jamahiriya', 'Jamahiriya Arabe Libyenne'],
                ['LI', 'LIE', 'Liechtenstein', 'Liechtenstein'],
                ['LT', 'LTU', 'Lithuania', 'Lituanie'],
                ['LU', 'LUX', 'Luxembourg', 'Luxembourg'],
                ['MO', 'MAC', 'Macao', 'Macao'],
                ['MG', 'MDG', 'Madagascar', 'Madagascar'],
                ['MW', 'MWI', 'Malawi', 'Malawi'],
                ['MY', 'MYS', 'Malaysia', 'Malaisie'],
                ['MV', 'MDV', 'Maldives', 'Maldives'],
                ['ML', 'MLI', 'Mali', 'Mali'],
                ['MT', 'MLT', 'Malta', 'Malte'],
                ['MQ', 'MTQ', 'Martinique', 'Martinique'],
                ['MR', 'MRT', 'Mauritania', 'Mauritanie'],
                ['MU', 'MUS', 'Mauritius', 'Maurice'],
                ['MX', 'MEX', 'Mexico', 'Mexique'],
                ['MC', 'MCO', 'Monaco', 'Monaco'],
                ['MN', 'MNG', 'Mongolia', 'Mongolie'],
                ['MD', 'MDA', 'Republic of Moldova', 'République de Moldova'],
                ['MS', 'MSR', 'Montserrat', 'Montserrat'],
                ['MA', 'MAR', 'Morocco', 'Maroc'],
                ['MZ', 'MOZ', 'Mozambique', 'Mozambique'],
                ['OM', 'OMN', 'Oman', 'Oman'],
                ['NA', 'NAM', 'Namibia', 'Namibie'],
                ['NR', 'NRU', 'Nauru', 'Nauru'],
                ['NP', 'NPL', 'Nepal', 'Népal'],
                ['NL', 'NLD', 'Netherlands', 'Pays-Bas'],
                ['AN', 'ANT', 'Netherlands Antilles', 'Antilles Néerlandaises'],
                ['AW', 'ABW', 'Aruba', 'Aruba'],
                ['NC', 'NCL', 'New Caledonia', 'Nouvelle-Calédonie'],
                ['VU', 'VUT', 'Vanuatu', 'Vanuatu'],
                ['NZ', 'NZL', 'New Zealand', 'Nouvelle-Zélande'],
                ['NI', 'NIC', 'Nicaragua', 'Nicaragua'],
                ['NE', 'NER', 'Niger', 'Niger'],
                ['NG', 'NGA', 'Nigeria', 'Nigéria'],
                ['NU', 'NIU', 'Niue', 'Niué'],
                ['NF', 'NFK', 'Norfolk Island', 'Île Norfolk'],
                ['NO', 'NOR', 'Norway', 'Norvège'],
                ['MP', 'MNP', 'Northern Mariana Islands', 'Îles Mariannes du Nord'],
                ['UM', 'UMI', 'United States Minor Outlying Islands', 'Îles Mineures Éloignées des États-Unis'],
                ['FM', 'FSM', 'Federated States of Micronesia', 'États Fédérés de Micronésie'],
                ['MH', 'MHL', 'Marshall Islands', 'Îles Marshall'],
                ['PW', 'PLW', 'Palau', 'Palaos'],
                ['PK', 'PAK', 'Pakistan', 'Pakistan'],
                ['PA', 'PAN', 'Panama', 'Panama'],
                ['PG', 'PNG', 'Papua New Guinea', 'Papouasie-Nouvelle-Guinée'],
                ['PY', 'PRY', 'Paraguay', 'Paraguay'],
                ['PE', 'PER', 'Peru', 'Pérou'],
                ['PH', 'PHL', 'Philippines', 'Philippines'],
                ['PN', 'PCN', 'Pitcairn', 'Pitcairn'],
                ['PL', 'POL', 'Poland', 'Pologne'],
                ['PT', 'PRT', 'Portugal', 'Portugal'],
                ['GW', 'GNB', 'Guinea-Bissau', 'Guinée-Bissau'],
                ['TL', 'TLS', 'Timor-Leste', 'Timor-Leste'],
                ['PR', 'PRI', 'Puerto Rico', 'Porto Rico'],
                ['QA', 'QAT', 'Qatar', 'Qatar'],
                ['RE', 'REU', 'Réunion', 'Réunion'],
                ['RO', 'ROU', 'Romania', 'Roumanie'],
                ['RU', 'RUS', 'Russian Federation', 'Fédération de Russie'],
                ['RW', 'RWA', 'Rwanda', 'Rwanda'],
                ['SH', 'SHN', 'Saint Helena', 'Sainte-Hélène'],
                ['KN', 'KNA', 'Saint Kitts and Nevis', 'Saint-Kitts-et-Nevis'],
                ['AI', 'AIA', 'Anguilla', 'Anguilla'],
                ['LC', 'LCA', 'Saint Lucia', 'Sainte-Lucie'],
                ['PM', 'SPM', 'Saint-Pierre and Miquelon', 'Saint-Pierre-et-Miquelon'],
                ['VC', 'VCT', 'Saint Vincent and the Grenadines', 'Saint-Vincent-et-les Grenadines'],
                ['SM', 'SMR', 'San Marino', 'Saint-Marin'],
                ['ST', 'STP', 'Sao Tome and Principe', 'Sao Tomé-et-Principe'],
                ['SA', 'SAU', 'Saudi Arabia', 'Arabie Saoudite'],
                ['SN', 'SEN', 'Senegal', 'Sénégal'],
                ['SC', 'SYC', 'Seychelles', 'Seychelles'],
                ['SL', 'SLE', 'Sierra Leone', 'Sierra Leone'],
                ['SG', 'SGP', 'Singapore', 'Singapour'],
                ['SK', 'SVK', 'Slovakia', 'Slovaquie'],
                ['VN', 'VNM', 'Vietnam', 'Viet Nam'],
                ['SI', 'SVN', 'Slovenia', 'Slovénie'],
                ['SO', 'SOM', 'Somalia', 'Somalie'],
                ['ZA', 'ZAF', 'South Africa', 'Afrique du Sud'],
                ['ZW', 'ZWE', 'Zimbabwe', 'Zimbabwe'],
                ['ES', 'ESP', 'Spain', 'Espagne'],
                ['EH', 'ESH', 'Western Sahara', 'Sahara Occidental'],
                ['SD', 'SDN', 'Sudan', 'Soudan'],
                ['SR', 'SUR', 'Suriname', 'Suriname'],
                ['SJ', 'SJM', 'Svalbard and Jan Mayen', 'Svalbard etÎle Jan Mayen'],
                ['SZ', 'SWZ', 'Swaziland', 'Swaziland'],
                ['SE', 'SWE', 'Sweden', 'Suède'],
                ['CH', 'CHE', 'Switzerland', 'Suisse'],
                ['SY', 'SYR', 'Syrian Arab Republic', 'République Arabe Syrienne'],
                ['TJ', 'TJK', 'Tajikistan', 'Tadjikistan'],
                ['TH', 'THA', 'Thailand', 'Thaïlande'],
                ['TG', 'TGO', 'Togo', 'Togo'],
                ['TK', 'TKL', 'Tokelau', 'Tokelau'],
                ['TO', 'TON', 'Tonga', 'Tonga'],
                ['TT', 'TTO', 'Trinidad and Tobago', 'Trinité-et-Tobago'],
                ['AE', 'ARE', 'United Arab Emirates', 'Émirats Arabes Unis'],
                ['TN', 'TUN', 'Tunisia', 'Tunisie'],
                ['TR', 'TUR', 'Turkey', 'Turquie'],
                ['TM', 'TKM', 'Turkmenistan', 'Turkménistan'],
                ['TC', 'TCA', 'Turks and Caicos Islands', 'Îles Turks et Caïques'],
                ['TV', 'TUV', 'Tuvalu', 'Tuvalu'],
                ['UG', 'UGA', 'Uganda', 'Ouganda'],
                ['UA', 'UKR', 'Ukraine', 'Ukraine'],
                ['MK', 'MKD', 'The Former Yugoslav Republic of Macedonia', 'L\'ex-République Yougoslave de Macédoine'],
                ['EG', 'EGY', 'Egypt', 'Égypte'],
                ['GB', 'GBR', 'United Kingdom', 'Royaume-Uni'],
                ['IM', 'IMN', 'Isle of Man', 'Île de Man'],
                ['TZ', 'TZA', 'United Republic Of Tanzania', 'République-Unie de Tanzanie'],
                ['US', 'USA', 'United States', 'États-Unis'],
                ['VI', 'VIR', 'U.S. Virgin Islands', 'Îles Vierges des États-Unis'],
                ['BF', 'BFA', 'Burkina Faso', 'Burkina Faso'],
                ['UY', 'URY', 'Uruguay', 'Uruguay'],
                ['UZ', 'UZB', 'Uzbekistan', 'Ouzbékistan'],
                ['VE', 'VEN', 'Venezuela', 'Venezuela'],
                ['WF', 'WLF', 'Wallis and Futuna', 'Wallis et Futuna'],
                ['WS', 'WSM', 'Samoa', 'Samoa'],
                ['YE', 'YEM', 'Yemen', 'Yémen'],
                ['CS', 'SCG', 'Serbia and Montenegro', 'Serbie-et-Monténégro'],
                ['ZM', 'ZMB', 'Zambia', 'Zambie']
            ];

            foreach ($pays as $ps) {
                Country::create([
                        'alpha2' => $ps[0],
                        'alpha3' => $ps[1],
                        'nom_en' => $ps[2],
                        'nom_fr' => $ps[3],
                    ]);
            }
        }
    }
}
