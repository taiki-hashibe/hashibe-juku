<?php

namespace App\View\Components\Layouts;

use App\Models\Page;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class AuthLayout extends Component
{
    public User $user;
    public Collection $pages;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->user = auth('users')->user();
        $this->pages = Page::sortOrder()->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.auth-layout');
    }
}
