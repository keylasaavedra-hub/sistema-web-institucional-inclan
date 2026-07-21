<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PublicLayout extends Component
{
    public function __construct(
        public string $title = 'Portal institucional'
    ) {
    }

    public function render(): View
    {
        return view('layouts.public');
    }
}