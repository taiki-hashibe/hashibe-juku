<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class MediaUpload extends Component
{
    public string|null $media = null;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $media = null)
    {
        $this->media = $media;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.components.media-upload');
    }
}
