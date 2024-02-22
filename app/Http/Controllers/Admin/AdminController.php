<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View
    {
        $items = Admin::orderByDesc('updated_at');
        return view('admin.pages.admin.index', [
            'items' => $items
        ]);
    }

    public function create(): \Illuminate\Contracts\View\View
    {
        return view('admin.pages.admin.create');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|max:255|unique:admins,name',
            'email' => 'required|email|max:255|unique:admins,email',
            'password' => 'required|min:8|confirmed',
        ]);
        /** @var string $password */
        $password = $request->password;
        $item = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($password),
        ]);
        return redirect()->route('admin.admin.show', [
            'admin' => $item->id
        ])->with('message', $item->name . 'を登録しました。');
    }

    public function show(Admin $admin): \Illuminate\Contracts\View\View
    {
        return view('admin.pages.admin.show', [
            'item' => $admin
        ]);
    }

    public function destroy(Admin $admin): \Illuminate\Http\RedirectResponse
    {
        request()->validate([
            'post_delete' => 'nullable'
        ]);
        /** @var \App\Models\Admin $authUser */
        $authUser = auth('admins')->user();
        if ($admin->id === $authUser->id) {
            return redirect()->route('admin.admin.show', [
                'admin' => $admin->id
            ])->with('message', '自分自身を削除することはできません。');
        }
        if (request()->post_delete === 'on') {
            $admin->posts()->delete();
        }
        $admin->delete();
        return redirect()->route('admin.admin.index')->with('message', $admin->name . 'を削除しました。');
    }
}
