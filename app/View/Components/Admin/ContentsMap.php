<?php

namespace App\View\Components\Admin;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class ContentsMap extends Component
{
    public int $nest = 0;
    public bool $isParent;
    /**
     * @var Collection<int, Category>
     */
    public Collection|null $categories;
    /**
     * @var Collection<int, Post>
     */
    public Collection|null $posts;
    /**
     * @var array<int,string>
     */
    public array $lineColors = [
        'bg-slate-300',
        'bg-primary-200',
        'bg-orange-200',
    ];
    public string $lineColor = 'bg-slate-300';
    /**
     * Create a new component instance.
     * @param Collection<int, Category>|null $categories
     * @param Collection<int, Post>|null $posts
     * @return void
     */
    public function __construct(int $nest = 0, bool $isParent = false, Collection $categories = null, Collection $posts = null)
    {
        $this->nest = $nest;
        // $nestの数でlineColorを決定する
        $this->lineColor = $this->lineColors[$nest % count($this->lineColors)];
        $this->isParent = $isParent;
        if ($this->isParent) {
            $this->categories = Category::parentCategories()->onlyHasPost()->get();
            $this->posts = Post::where('category_id', null)->publish()->get();
        } else {
            $this->categories = $categories;
            $this->posts = $posts;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.components.contents-map');
    }
}
