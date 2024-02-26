<?php

namespace App\View\Components;

use App\Models\Post;
use App\Models\PublishLevelEnum;
use App\Services\PostContentParser\GetImageModalProperty;
use App\Services\PostContentParser\ModalImageParser;
use App\Services\PostContentParser\PublishLevelParser;
use Illuminate\View\Component;

class PostContent extends Component
{
    public Post $post;
    public string $column = 'content';
    public string|null $content;
    /**
     * @var array<int,array<string, string>>
     */
    public array $modalImages = [];
    public string $alpineData = "";
    public bool $isCanView = false;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Post $post, string $column = 'content')
    {
        $this->post = $post;
        $this->column = $column;
        $this->content = $post->{$this->column};
        if (auth('admins')->check()) {
            $this->isCanView = true;
            $this->parse();
            return;
        };
        $this->isCanView = $post->isCanView();
        if (!$this->isCanView) {
            $this->content = null;
        }
        $this->parse();
    }

    public function parse(): void
    {
        if (!$this->content) return;
        $this->content = PublishLevelParser::parse($this->content);
        $this->content = ModalImageParser::parse($this->content);
        $imageModalProperty = GetImageModalProperty::get($this->content);
        $this->alpineData = $imageModalProperty->alpineData;
        $this->modalImages = $imageModalProperty->modalImages;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.post-content');
    }
}
