<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\StatusEnum;
use App\Models\Category;
use App\Models\Exercise;
use App\Models\ExerciseChoice;
use App\Models\PublishLevelEnum;
use App\Rules\ExerciseChoiceIsCorrect;
use App\Services\GenerateSlug;
use App\Services\ItemOrderAutoIncrement;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View
    {
        /** @var \App\Models\Admin $admin */
        $admin = auth('admins')->user();
        $items = Post::editable()->orderByDesc('created_at');
        if (!request()->all_post) {
            $items = $items->where('admin_id', $admin->id);
        }
        return view('admin.pages.post.index', [
            'items' => $items,
        ]);
    }

    public function create(): \Illuminate\Contracts\View\View
    {
        $categories = Category::all();
        $status = StatusEnum::toArrayForEditor();
        $publishLevels = PublishLevelEnum::toArray();
        return view('admin.pages.post.create', [
            'categories' => $categories,
            'status' => $status,
            'publishLevels' => $publishLevels,
        ]);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        /** @var \App\Models\Admin $admin */
        $admin = auth('admins')->user();
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'nullable',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'required',
            'publish_level' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|string',
            'exercises' => 'nullable|array',
            'exercises.*.question' => 'required|string|max:255',
            'exercises.*.choices' => ['required', 'array', new ExerciseChoiceIsCorrect()],
            'exercises.*.choices.*.text' => 'required|string|max:255',
        ]);
        $file = $request->file('image');
        if (is_array($file)) {
            $file = $file[0];
        }
        /** @var string|null $title */
        $title = $request->title;
        /** @var int|null $categoryId */
        $categoryId = $request->category_id;
        $item = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => GenerateSlug::generate($title, Post::class),
            'category_id' => $request->category_id ?? null,
            'status' => $request->status,
            'publish_level' => $request->publish_level,
            'image' => $file ? $file->store('post_thumbnails', 'public') : null,
            'video' => $request->video,
            'admin_id' => $admin->id,
            'order' => ItemOrderAutoIncrement::post($categoryId),
        ]);
        if ($request->exercises) {
            /** @var array<int, array<string, string|bool>> $exercises */
            $exercises = $request->exercises;
            foreach ($exercises as $i => $ex) {
                /** @var string $question */
                $question = $ex['question'];
                $exercise = Exercise::create([
                    'post_id' => $item->id,
                    'question' => $question,
                    'order' => $i,
                ]);
                /** @var array<int, array<string, string|bool>> $choices*/
                $choices = $ex['choices'];
                foreach ($choices as $j => $choice) {
                    $isCorrect = array_key_exists('is_correct', $choice);
                    $choice = ExerciseChoice::create([
                        'exercise_id' => $exercise->id,
                        'text' => $choice['text'],
                        'is_correct' => $isCorrect,
                        'order' => $j,
                    ]);
                }
            }
        }
        return redirect()->route('admin.post.show', [
            'post' => $item->id
        ])->with('message', $item->title . 'を登録しました。');
    }

    public function show(Post $post): \Illuminate\Contracts\View\View
    {
        return view('admin.pages.post.show', [
            'item' => $post,
        ]);
    }

    public function edit(Post $post): \Illuminate\Contracts\View\View
    {
        $categories = Category::all();
        $status = StatusEnum::toArrayForEditor();
        $publishLevels = PublishLevelEnum::toArray();
        return view('admin.pages.post.edit', [
            'item' => $post,
            'categories' => $categories,
            'status' => $status,
            'publishLevels' => $publishLevels,
        ]);
    }

    public function update(Request $request, Post $post): \Illuminate\Http\RedirectResponse
    {
        /** @var \App\Models\Admin $admin */
        $admin = auth('admins')->user();
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'nullable',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'required',
            'publish_level' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|string',
            'exercises' => 'nullable|array',
            'exercises.*.question' => 'required|string|max:255',
            'exercises.*.choices' => ['required', 'array', new ExerciseChoiceIsCorrect()],
            'exercises.*.choices.*.text' => 'required|string|max:255',
        ]);
        $file = $request->file('image');
        if (is_array($file)) {
            $file = $file[0];
        }
        $order = $post->order;
        if ($request->category_id !== $post->category_id) {
            /** @var int|null $categoryId */
            $categoryId = $request->category_id;
            $order = ItemOrderAutoIncrement::post($categoryId);
        }
        $post->revision();
        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id ?? null,
            'status' => $request->status,
            'publish_level' => $request->publish_level,
            'image' => $file ? $file->store('post_thumbnails', 'public') : $post->image,
            'video' => $request->video,
            'admin_id' => $admin->id,
            'order' => $order,
        ]);
        $post->exercises()->delete();
        if ($request->exercises) {
            /** @var array<int, array<string, string|bool>> $exercises */
            $exercises = $request->exercises;
            foreach ($exercises as $i => $ex) {
                /** @var string $question */
                $question = $ex['question'];
                $exercise = Exercise::create([
                    'post_id' => $post->id,
                    'question' => $question,
                    'order' => $i,
                ]);
                /** @var array<int, array<string, string|bool>> $choices */
                $choices = $ex['choices'];
                foreach ($choices as $j => $choice) {
                    $isCorrect = array_key_exists('is_correct', $choice);
                    /** @var string $text */
                    $text = $choice['text'];
                    $choice = ExerciseChoice::create([
                        'exercise_id' => $exercise->id,
                        'text' => $text,
                        'is_correct' => $isCorrect,
                        'order' => $j,
                    ]);
                }
            }
        }
        return redirect()->route('admin.post.show', [
            'post' => $post->id
        ])->with('message', $post->title . 'を更新しました。');
    }

    public function revert(Post $post): \Illuminate\Http\RedirectResponse
    {
        $original = $post->original;
        if (!$original) {
            abort(500, '元記事が存在しません。');
        }
        $original->revision();
        $original->update([
            'title' => $post->title,
            'content' => $post->content,
            'category_id' => $post->category_id ?? null,
            'status' => $post->status,
            'image' => $post->image,
            'video' => $post->video,
        ]);
        return redirect()->route('admin.post.show', [
            'post' => $original->id
        ])->with('message', $post->title . 'を復元しました。');
    }


    public function destroy(Post $post): \Illuminate\Http\RedirectResponse
    {
        $post->delete();
        return redirect()->route('admin.post.index')->with('message', $post->title . 'を削除しました。');
    }

    public function sort(Category $category = null): \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
    {
        if (request()->method() === 'POST') {
            request()->validate([
                'sort_item' => 'required|array',
            ]);
            /** @var array<int, array<string,int>> $sortItemIds<int,int> */
            $sortItemIds = request()->sort_item;
            foreach ($sortItemIds as $i => $id) {
                $sortItem = Post::where($id)->first();
                if (!$sortItem) continue;
                $sortItem->update([
                    'order' => $i
                ]);
            }
            if ($category) {
                return redirect(route('admin.category.show', [
                    'category' => $category->id,
                ]))->with('message', '並べ替えが完了しました');
            }
            return redirect(route('admin.post.index'))->with('message', '並べ替えが完了しました');
        }
        $posts = Post::where('category_id', null)->editable()->sortOrder()->get();
        if ($category) {
            $posts = $category->posts()->editable()->sortOrder()->get();
        }
        return view('admin.pages.post.sort', [
            'collection' => $posts,
            'category' => $category
        ]);
    }
}