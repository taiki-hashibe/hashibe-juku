<?php

namespace App\Livewire\Admin;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class PostTagEditor extends Component
{
    public Collection $tags;
    public Collection $filteredTags;
    public Collection $selected;
    public string $filterFormValue = '';

    public function mount(Collection $selected = null)
    {
        $this->selected = $selected ?? collect();
        $this->tags = Tag::orderBy('created_at', 'desc')->get();
        $this->filteredTags = $this->tags;
    }

    public function filterFormOnChange()
    {
        $query = Tag::query();
        $query->where('name', 'like', '%' . $this->filterFormValue . '%');
        $this->filteredTags = $query->get();
    }

    public function tagSelect($id)
    {
        $tag = Tag::find($id);
        if (!$tag) {
            return;
        }
        $this->selected->push($tag);
        $this->filterFormValue = '';
    }

    public function tagRemove($id)
    {
        $this->selected = $this->selected->reject(function ($tag) use ($id) {
            return $tag->id === $id;
        });
    }


    public function render()
    {
        return view('livewire.admin.post-tag-editor');
    }
}
