<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InflowRoute;
use App\Services\GenerateUniqueText;
use Illuminate\Http\Request;

class InflowRouteController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View
    {
        $items = InflowRoute::orderByDesc('created_at');
        return view('admin.pages.inflow-route.index', [
            'items' => $items
        ]);
    }

    public function create(): \Illuminate\Contracts\View\View
    {
        return view('admin.pages.inflow-route.create');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        /** @var \App\Models\Admin $admin */
        $admin = auth('admins')->user();
        $request->validate([
            'route' => 'nullable|max:255',
            'source' => 'nullable|max:255',
            'redirect_url' => 'required|url',
        ]);
        $item = InflowRoute::create([
            'route' => $request->route ?? null,
            'source' => $request->source ?? null,
            'key' => GenerateUniqueText::generate(InflowRoute::class, 'key'),
            'redirect_url' => $request->redirect_url,
        ]);
        return redirect()->route('admin.inflow-route.show', [
            'inflow_route' => $item->id
        ])->with('message', ($item->name ?? '流入経路') . 'を登録しました。');
    }

    public function show(InflowRoute $inflowRoute): \Illuminate\Contracts\View\View
    {
        return view('admin.pages.inflow-route.show', [
            'item' => $inflowRoute
        ]);
    }

    public function edit(InflowRoute $inflowRoute): \Illuminate\Contracts\View\View
    {
        return view('admin.pages.inflow-route.edit', [
            'item' => $inflowRoute,
        ]);
    }

    public function update(Request $request, InflowRoute $inflowRoute): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'route' => 'nullable|max:255',
            'source' => 'nullable|max:255',
            'redirect_url' => 'required|url',
        ]);
        $inflowRoute->update([
            'route' => $request->route ?? null,
            'source' => $request->source ?? null,
            'redirect_url' => $request->redirect_url,
        ]);

        return redirect()->route('admin.inflow-route.show', [
            'inflow_route' => $inflowRoute->id
        ])->with('message', ($inflowRoute->name ?? '流入経路') . 'を更新しました。');
    }

    public function destroy(InflowRoute $inflowRoute): \Illuminate\Http\RedirectResponse
    {
        $inflowRoute->delete();
        return redirect()->route('admin.inflow-route.index')->with('message', $inflowRoute->name . 'を削除しました。');
    }
}
