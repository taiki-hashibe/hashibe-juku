<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Rules\PreventInfiniteLoop;
use App\Services\GenerateSlug;
use App\Services\ItemOrderAutoIncrement;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View
    {
        $items = Category::orderByDesc('updated_at');
        return view('admin.pages.category.index', [
            'items' => $items
        ]);
    }

    public function create(): \Illuminate\Contracts\View\View
    {
        $items = Category::get();
        return view('admin.pages.category.create', [
            'categories' => $items,
        ]);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        /** @var \App\Models\Admin $admin */
        $admin = auth('admins')->user();
        $request->validate([
            'name' => 'required|max:255|unique:categories,name',
            'description' => 'nullable|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $file = $request->file('image');
        if (is_array($file)) {
            $file = $file[0];
        }
        /** @var string $name */
        $name = $request->name;
        /** @var int|null $parentId */
        $parentId = $request->parent_id;
        $item = Category::create([
            'name' => $request->name,
            'slug' => GenerateSlug::generate($name, Category::class),
            'description' => $request->description ?? null,
            'parent_id' => $parentId,
            'image' => $file ? asset('storage/' . $file->store('category_images', 'public')) : null,
            'admin_id' => $admin->id,
            'order' => ItemOrderAutoIncrement::category($parentId),
        ]);
        return redirect()->route('admin.category.show', [
            'category' => $item->id
        ])->with('message', $item->name . 'を登録しました。');
    }

    public function show(Category $category): \Illuminate\Contracts\View\View
    {
        return view('admin.pages.category.show', [
            'item' => $category
        ]);
    }

    public function edit(Category $category): \Illuminate\Contracts\View\View
    {
        $items = Category::where('id', '<>', $category->id)->get();
        return view('admin.pages.category.edit', [
            'item' => $category,
            'categories' => $items,
        ]);
    }

    public function update(Request $request, Category $category): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|max:255',
            'parent_id' => ['nullable', 'exists:categories,id', new PreventInfiniteLoop($category)],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $file = $request->file('image');
        if (is_array($file)) {
            $file = $file[0];
        }
        $category->update([
            'name' => $request->name,
            'description' => $request->description ?? null,
            'parent_id' => $request->parent_id ?? null,
            'image' => $file ? asset('storage/' . $file->store('category_images', 'public')) : $category->image,
        ]);

        return redirect()->route('admin.category.show', [
            'category' => $category->id
        ])->with('message', $category->name . 'を更新しました。');
    }

    public function destroy(Category $category): \Illuminate\Http\RedirectResponse
    {
        $category->delete();
        return redirect()->route('admin.category.index')->with('message', $category->name . 'を削除しました。');
    }

    public function sort(Category $category = null): \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
    {
        if (request()->method() === 'POST') {
            request()->validate([
                'sort_item' => 'required|array',
            ]);
            /** @var array<int, array<string,int>> $sortItemIds */
            $sortItemIds = request()->sort_item;
            foreach ($sortItemIds as $i => $id) {
                $sortItem = Category::where($id)->first();
                if (!$sortItem) {
                    continue;
                }
                $sortItem->update([
                    'order' => $i
                ]);
            }
            if ($category) {
                return redirect(route('admin.category.show', [
                    'category' => $category->id,
                ]))->with('message', '並べ替えが完了しました');
            }
            return redirect(route('admin.category.index'))->with('message', '並べ替えが完了しました');
        }
        $categories = Category::parentCategories()->sortOrder()->get();
        if ($category) {
            $categories = $category->children()->sortOrder()->get();
        }
        return view('admin.pages.category.sort', [
            'collection' => $categories,
            'item' => $category
        ]);
    }
}
