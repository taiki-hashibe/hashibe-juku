<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\GenerateSlug;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Page::orderBy('order');
        return view('admin.pages.page.index', [
            'items' => $items,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.page.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);
        $item = Page::create([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => GenerateSlug::generate($request->title, Page::class),
            'order' => 0
        ]);
        return redirect()->route('admin.page.show', [
            'page' => $item->id
        ])->with('message', $item->title . 'を登録しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        return view('admin.pages.page.show', [
            'item' => $page,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        return view('admin.pages.page.edit', [
            'item' => $page,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);
        $page->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);
        return redirect()->route('admin.page.show', [
            'page' => $page->id
        ])->with('message', $page->title . 'を更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.page.index')->with('message', $page->title . 'を削除しました。');
    }

    public function sort()
    {
        if (request()->method() === 'POST') {
            request()->validate([
                'order' => 'required|array',
                'order.*' => 'required|exists:pages,id',
            ]);
            foreach (request()->order as $i => $id) {
                $item = Page::where('id', $id)->first();
                $item->update([
                    'order' => $i
                ]);
            }
            return redirect()->route('admin.page.index')->with('message', '並び替えを更新しました。');
        }
        $sortItems = Page::sortOrder()->get();
        return view('admin.pages.page.sort', [
            'collection' => $sortItems,
        ]);
    }
}
