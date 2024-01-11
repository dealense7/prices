<?php

namespace App\View\Components\home;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Stores extends Component
{
    public function __construct(public Collection $stores)
    {
        //
    }

    public function render(): View
    {
        return view('components.home.stores');
    }
}
