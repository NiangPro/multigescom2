<?php

use App\Http\Livewire\Abonnement;
use App\Http\Livewire\Admins;
use App\Http\Livewire\Cgu;
use App\Http\Livewire\Clients;
use App\Http\Livewire\Commercial;
use App\Http\Livewire\Company;
use App\Http\Livewire\Comptable;
use App\Http\Livewire\DataStatic;
use App\Http\Livewire\Depenses;
use App\Http\Livewire\Devis;
use App\Http\Livewire\Employes;
use App\Http\Livewire\Fournisseurs;
use App\Http\Livewire\General;
use App\Http\Livewire\History;
use App\Http\Livewire\Home;
use App\Http\Livewire\Inscription;
use App\Http\Livewire\Ipn;
use App\Http\Livewire\Login;
use App\Http\Livewire\Messages;
use App\Http\Livewire\Users;
use App\Http\Livewire\Profil;
use App\Http\Livewire\Password;
use App\Http\Livewire\PasswordForget;
use App\Http\Livewire\PayError;
use App\Http\Livewire\PaySuccess;
use App\Http\Livewire\Produits;
use App\Http\Livewire\Prospects;
use App\Http\Livewire\Rapports;
use App\Http\Livewire\Reunions;
use App\Http\Livewire\Taches;
use App\Http\Livewire\Ventes;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', Login::class)->name('login');
Route::get('/accueil', Home::class)->name('home');
Route::get('/utilisateurs', Users::class)->name('users');
Route::get('/donnees_statiques', DataStatic::class)->name('staticData');
Route::get('/entreprises', Company::class)->name('entreprises');
Route::get('/employes', Employes::class)->name('employe');
Route::get('/produits', Produits::class)->name('produit');
Route::get('/clients', Clients::class)->name('client');
Route::get('/fournisseurs', Fournisseurs::class)->name('fournisseur');
Route::get('/prospects', Prospects::class)->name('prospect');
Route::get('/taches', Taches::class)->name('tache');
Route::get('/reunions', Reunions::class)->name('reunion');
Route::get('/commerciaux', Commercial::class)->name('commercial');
Route::get('/comptables', Comptable::class)->name('comptable');
Route::get('/administrateurs', Admins::class)->name('admin');
Route::get('/depenses', Depenses::class)->name('depense');
Route::get('/devis', Devis::class)->name('devis');
Route::get('/rapports', Rapports::class)->name('rapport');
Route::get('/messages', Messages::class)->name('message');
Route::get('/ventes', Ventes::class)->name('vente');
Route::get('/historiques', History::class)->name('history');
Route::get('/profil', Profil::class)->name('profil');
Route::get('/ipn_url', Ipn::class)->name('ipn_url');
Route::get('/url_pay_success', PaySuccess::class)->name('url_pay_success');
Route::get('/url_pay_error', PayError::class)->name('url_pay_error');
Route::get('/mot_de_passe', Password::class)->name('password');
Route::get('/abonnements', Abonnement::class)->name('abonnement');
Route::get('/creation_entreprise', Inscription::class)->name('inscription');
Route::get('/mot_de_passe_oublie', PasswordForget::class)->name('passwordforget');
Route::get('/configuration_generale', General::class)->name('general');
Route::get('/conditions_generales_utilisation', Cgu::class)->name('cgu');

