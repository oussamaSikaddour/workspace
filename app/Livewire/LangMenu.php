<?php
namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class LangMenu extends Component
{
    public $forCustom = false;
    public $locale = 'fr';

    public function setLocale($locale)
    {
        $this->locale = strtolower($locale);
        redirect()->route('setLang', $this->locale);
    }



    public function render()
    {
        return view('livewire.lang-menu');
    }
}
