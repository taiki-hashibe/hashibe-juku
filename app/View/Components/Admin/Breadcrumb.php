<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class Breadcrumb extends Component
{
    /**
     * @var array<\App\Models\Post>
     */
    public array $pages;
    /**
     * Create a new component instance.
     * @param array<\App\Models\Post> $pages
     * @return void
     */
    public function __construct(array $pages)
    {
        $this->pages = $pages;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.components.breadcrumb');
    }
}
