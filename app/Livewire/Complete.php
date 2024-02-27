<?php

namespace App\Livewire;

use App\Models\CompletePost;
use App\Models\Post;
use App\Models\User;
use Livewire\Component;

class Complete extends Component
{
    public User $user;
    public Post $post;
    public CompletePost|null $completePost = null;

    public function mount(Post $post): void
    {
        $user = auth('users')->user();
        if (!$user instanceof User) {
            abort(500);
        }
        $this->user = $user;
        $this->post = $post;
        $this->completePost = CompletePost::where('user_id', $this->user->id)
            ->where('post_id', $this->post->id)
            ->first();
    }

    public function toggle(): void
    {
        if ($this->completePost) {
            $this->completePost->delete();
            $this->completePost = null;
        } else {
            $this->completePost = CompletePost::create([
                'user_id' => $this->user->id,
                'post_id' => $this->post->id,
            ]);
        }
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.complete');
    }
}
