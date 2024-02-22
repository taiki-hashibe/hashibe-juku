<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GuestLayout extends Component
{
    public bool $unlink;
    /**
     * Create a new component instance.
     */
    public function __construct(bool $unlink = false)
    {
        $this->unlink = $unlink;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.guest-layout');
    }
}
