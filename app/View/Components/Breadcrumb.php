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
    public \App\Models\Curriculum|null $curriculum;
    public array $breadcrumbs;
    /**
     * Create a new component instance.
     */
    public function __construct(bool $guest = false, \App\Models\Post $post = null, \App\Models\Category $category = null, \App\Models\Curriculum $curriculum = null, array $item = null)
    {
        $user = auth('users')->user();
        $prefix = !$guest && $user ? 'user.' : '';
        $this->post = $post;
        $this->category = $category;
        $this->curriculum = $curriculum;
        $breadcrumbs = [];
        if ($this->category) {
            $breadcrumbs[] = [
                'label' => $category->name,
                'url' => route($prefix . 'category.index', [
                    'category' => $this->category->slug,
                ]),
            ];
            if ($this->category->parent) {
                $breadcrumbs[] = [
                    'label' => $this->category->parent->name,
                    'url' => route($prefix . 'category.index', [
                        'category' => $this->category->parent->slug,
                    ]),
                ];
            }
        }
        if ($this->curriculum) {
            $breadcrumbs[] = [
                'label' => $this->curriculum->name,
                'url' => route($prefix . 'curriculum.index', [
                    'curriculum' => $this->curriculum->slug,
                ]),
            ];
        }
        $breadcrumbs = array_reverse($breadcrumbs);
        if (!$guest && $user) {
            array_unshift($breadcrumbs, [
                'label' => 'マイページ',
                'url' => route('user.home'),
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
        if ($item) {
            $breadcrumbs[] = $item;
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
