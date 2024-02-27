<?php

namespace App\View\Components;

use App\Models\Curriculum;
use App\Models\Post;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SameCurriculumList extends Component
{
    public Curriculum $curriculum;
    public Post $post;

    /**
     * Create a new component instance.
     */
    public function __construct(Post $post, Curriculum $curriculum)
    {
        $this->post = $post;
        $this->curriculum = $curriculum;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.same-curriculum-list');
    }
}
