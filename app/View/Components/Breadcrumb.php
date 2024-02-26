<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public \App\Models\Category|null $category;
    public \App\Models\Post|null $post;
    public array $breadcrumbs;
    /**
     * Create a new component instance.
     */
    public function __construct(\App\Models\Post $post = null, \App\Models\Category $category = null)
    {
        $this->post = $post;
        $this->category = $category;
        $breadcrumbs = [];
        if ($this->category) {
            $breadcrumbs[] = [
                'label' => $category->name,
                'url' => route('category.detail', [
                    'category' => $this->category->slug,
                ]),
            ];
            if ($this->category->parent) {
                $breadcrumbs[] = [
                    'label' => $this->category->parent->name,
                    'url' => route('category.detail', [
                        'category' => $this->category->parent->slug,
                    ]),
                ];
            }
        }
        $breadcrumbs = array_reverse($breadcrumbs);
        if (Auth::guard('users')->check()) {
            array_unshift($breadcrumbs, [
                'label' => 'マイページ',
                'url' => route('home'),
            ]);
        } else {
            array_unshift($breadcrumbs, [
                'label' => 'トップページ',
                'url' => route('home'),
            ]);
        }
        if ($this->post) {
            $breadcrumbs[] = [
                'label' => $post->title,
                'url' => route('post.post', [
                    'post' => $post->slug
                ])
            ];
        }
        unset($breadcrumbs[count($breadcrumbs) - 1]['url']);
        $this->breadcrumbs = $breadcrumbs;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.breadcrumb');
    }
}
