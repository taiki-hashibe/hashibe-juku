<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use App\Models\CurriculumPost;
use App\Models\Post;
use App\Services\GenerateSlug;
use App\Services\ItemOrderAutoIncrement;
use Illuminate\Http\Request;

class CurriculumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Curriculum::orderBy('order');
        return view('admin.pages.curriculum.index', [
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.curriculum.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:curricula,name',
            'description' => 'required|max:255',
            'posts' => 'required|array',
            'posts.*' => 'required|exists:posts,id',
        ]);
        $item = Curriculum::create([
            'name' => $request->name,
            'description' => $request->description ?? null,
            'order' => ItemOrderAutoIncrement::curriculum(),
            'slug' => GenerateSlug::generate($request->name, Curriculum::class),
        ]);
        $item->posts()->attach($request->posts);
        return redirect()->route('admin.curriculum.show', [
            'curriculum' => $item->id
        ])->with('message', $item->name . 'を登録しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(Curriculum $curriculum)
    {
        return view('admin.pages.curriculum.show', [
            'item' => $curriculum
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curriculum $curriculum)
    {
        return view('admin.pages.curriculum.edit', [
            'item' => $curriculum
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Curriculum $curriculum)
    {
        $request->validate([
            'name' => 'required|max:255|unique:curricula,name,' . $curriculum->id,
            'description' => 'required|max:255',
            'posts' => 'required|array',
            'posts.*' => 'required|exists:posts,id',
        ]);
        $curriculum->update([
            'name' => $request->name,
            'description' => $request->description ?? null,
        ]);
        $curriculum->posts()->sync($request->posts);
        return redirect()->route('admin.curriculum.show', [
            'curriculum' => $curriculum->id
        ])->with('message', $curriculum->name . 'を更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curriculum $curriculum)
    {
        $curriculum->delete();
        return redirect()->route('admin.curriculum.index')->with('message', $curriculum->name . 'を削除しました。');
    }

    public function sort()
    {
        if (request()->method() === 'POST') {
            request()->validate([
                'order' => 'required|array',
                'order.*' => 'required|exists:curricula,id',
            ]);
            foreach (request()->order as $i => $id) {
                $item = Curriculum::find($id);
                $item->update([
                    'order' => $i
                ]);
            }
            return redirect()->route('admin.curriculum.index')->with('message', '並べ替えが完了しました');
        }
        $items = Curriculum::orderBy('order');
        return view('admin.pages.curriculum.sort', [
            'items' => $items
        ]);
    }

    public function sortItem(Curriculum $curriculum)
    {
        if (request()->method() === 'POST') {
            request()->validate([
                'order' => 'required|array',
                'order.*' => 'required|exists:posts,id',
            ]);
            foreach (request()->order as $i => $id) {
                $item = CurriculumPost::where('curriculum_id', $curriculum->id)->where('post_id', $id)->first();
                $item->update([
                    'order' => $i
                ]);
            }
            return redirect()->route('admin.curriculum.show', [
                'curriculum' => $curriculum->id
            ])->with('message', '並べ替えが完了しました');
        }
        $items = $curriculum->posts();
        return view('admin.pages.curriculum.sort-item', [
            'item' => $curriculum,
            'items' => $items
        ]);
    }
}
