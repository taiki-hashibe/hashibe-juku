<?php

namespace App\View\Components\Layouts;

use App\Models\Page;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class GuestLayout extends Component
{
    public bool $unlink;
    public Collection $pages;
    /**
     * Create a new component instance.
     */
    public function __construct(bool $unlink = false)
    {
        $this->unlink = $unlink;
        $this->pages = Page::sortOrder()->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.guest-layout');
    }
}
