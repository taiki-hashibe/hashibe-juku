<?php

namespace App\View\Components;

use App\Models\Post;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PostVideo extends Component
{
    public Post $post;
    public string $column = 'video';
    public string|null $video;
    /**
     * Create a new component instance.
     */
    public function __construct(Post $post, string $column = null)
    {
        $this->post = $post;
        $this->column = $column ?? 'video';
        if (!$column && !$this->post->isCanView() && $this->post->video_free) {
            $this->column = 'video_free';
        }
        $this->video = $post->{$this->column};
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.post-video');
    }
}
