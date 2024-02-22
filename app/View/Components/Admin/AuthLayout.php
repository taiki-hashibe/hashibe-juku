<?php

namespace App\View\Components\Admin;

use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;
use Illuminate\Support\Str;

class AuthLayout extends Component
{
    /**
     * @var array<array<string,string|bool>>
     */
    public array $navigation;
    /**
     * @var array<array<string,string|bool>>
     */
    public array $subNavigation;
    /**
     * @var array<string>
     */
    public array $message = [];
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->navigation = [
            [
                'label' => 'ユーザー',
                'url' => route('admin.user.index'),
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="w-5 h-5 me-2 ' . ($this->isActive('admin.user') ? 'stroke-white' : 'stroke-slate-400') . '">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
              </svg>',
                'active' => $this->isActive('admin.user')
            ],
            [
                'label' => '投稿',
                'url' => route('admin.post.index'),
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" data-slot="icon" class="w-5 h-5 me-2 ' . ($this->isActive('admin.post') ? 'stroke-white' : 'stroke-slate-400') . '">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
              </svg>
              ',
                'active' => $this->isActive('admin.post')
            ],
            [
                'label' => '投稿カテゴリー',
                'url' => route('admin.category.index'),
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" data-slot="icon" class="w-5 h-5 me-2 ' . ($this->isActive('admin.category') ? 'stroke-white' : 'stroke-slate-400') . '">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
              </svg>
              ',
                'active' => $this->isActive('admin.category')
            ],
        ];
        $this->subNavigation = [];
    }

    protected function isActive(string $prefix): bool
    {
        $routeName = Route::currentRouteName();
        if (!$routeName) {
            throw new \Exception('Route name is not found.');
        }
        return Str::startsWith($routeName, $prefix);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.layouts.auth');
    }
}
