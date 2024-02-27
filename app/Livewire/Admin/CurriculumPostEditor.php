<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CurriculumPostEditor extends Component
{
    public Collection $posts;
    public Collection $filteredPosts;
    public Collection $selected;
    public string $filterFormValue = '';

    public function mount(Collection $selected = null)
    {
        $this->selected = $selected ?? collect();
        $this->posts = Post::publish()->orderBy('created_at', 'desc')->get();
        $this->filteredPosts = $this->posts;
    }

    public function filterFormOnChange()
    {
        $query = Post::query();
        $query->where('title', 'like', '%' . $this->filterFormValue . '%');
        $this->filteredPosts = $query->get();
    }

    public function postSelect($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return;
        }
        $this->selected->push($post);
        $this->filterFormValue = '';
    }

    public function postRemove($id)
    {
        $this->selected = $this->selected->reject(function ($post) use ($id) {
            return $post->id === $id;
        });
    }

    public function render()
    {
        return view('livewire.admin.curriculum-post-editor');
    }
}
