<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PasswordForget extends Component
{
    public function render()
    {
        return view('livewire.password-forget')->layout('layouts.app');
    }
}
