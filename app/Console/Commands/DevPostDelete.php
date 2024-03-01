<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Curriculum;
use App\Models\CurriculumPost;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Console\Command;

class DevPostDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:post-delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (config('app.env') === 'production') {
            $this->error('You can not run this command in production');
            return;
        }
        Post::query()->delete();
        Category::query()->delete();
        Tag::query()->delete();
        CurriculumPost::query()->delete();
        Curriculum::query()->delete();
        $this->info('All posts and categories have been deleted');
    }
}
