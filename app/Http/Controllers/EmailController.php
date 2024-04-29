<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendWelcomeEmail()
    {
        $title = 'Renitialisation du mot passe';
        $body = 'code 4 chiffre envoiye';

        Mail::to('fallcodeur@gmail.com')->send(new TestMail($title, $body));

        return "Email sent successfully!";
    }
}
