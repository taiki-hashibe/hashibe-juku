<?php

namespace App\View\Components;

use App\Models\Post;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PostNavigationButtons extends Component
{
    public bool $auth;
    public Post|null $prev;
    public Post|null $next;
    /**
     * Create a new component instance.
     */
    public function __construct(Post $post)
    {
        $this->auth = auth('users')->check();
        $this->prev = $post->prev();
        $this->next = $post->next();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.post-navigation-buttons');
    }
}
