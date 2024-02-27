<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\Bookmark as ModelsBookmark;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;

class Bookmark extends Component
{
    public User $user;
    public Post $post;
    public ModelsBookmark|null $bookmark = null;
    public string $key;

    public function mount(Post $post): void
    {
        $user = auth('users')->user();
        if (!$user instanceof User) {
            abort(500);
        }
        $this->user = $user;
        $this->post = $post;
        $this->bookmark = ModelsBookmark::where('user_id', $this->user->id)
            ->where('post_id', $this->post->id)
            ->first();
        $this->key = Str::random(10);
    }

    public function toggle(): void
    {
        if ($this->bookmark) {
            $this->bookmark->delete();
            $this->bookmark = null;
        } else {
            $this->bookmark = ModelsBookmark::create([
                'user_id' => $this->user->id,
                'post_id' => $this->post->id,
            ]);
        }
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.bookmark');
    }
}
