<?php

namespace App\View\Components\Layouts;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Layout extends Component
{
    public User|null $user;
    public bool $unlink;
    /**
     * Create a new component instance.
     */
    public function __construct(bool $unlink = false)
    {
        $this->user = auth('users')->user();
        $this->unlink = $unlink;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if ($this->user) {
            return view('layouts.auth-layout');
        }
        return view('layouts.guest-layout');
    }
}
