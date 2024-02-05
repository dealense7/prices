<?php

namespace App\View\Components\list;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    public function __construct()
    {
        //
    }


    public function render(): View|Closure|string
    {
        return view('components.list.modal');
    }
}
