<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public function render(): View
    {
        if (auth()->check() && auth()->user()->hasRole('owner')) {
            return view('layouts.owner');
        }

        return view('layouts.app');
    }
}
