<?php

namespace App\View\Components\ManajemenAkunDinas;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class makundinaslayout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.manajemen-akun-dinas.makundinas-layout');
    }
}
