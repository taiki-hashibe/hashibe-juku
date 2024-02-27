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
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Post $post, string $column = null)
    {
        $this->post = $post;
        $this->column = $column ?? 'content';
        if (!$column && !$this->post->isCanView() && $this->post->content_free) {
            $this->column = 'content_free';
        }
        $this->content = $post->{$this->column};
        $this->parse();
    }

    public function parse(): void
    {
        if (!$this->content) return;
        // $this->content = PublishLevelParser::parse($this->content);
        // $this->content = ModalImageParser::parse($this->content);
        // $imageModalProperty = GetImageModalProperty::get($this->content);
        // $this->alpineData = $imageModalProperty->alpineData;
        // $this->modalImages = $imageModalProperty->modalImages;
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
