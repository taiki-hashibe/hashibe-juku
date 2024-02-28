<x-layout class="bg-white">
    {{ Breadcrumbs::render(request()->route()->getName(), $page) }}
    <h2 class="text-slate-700 mb-12 font-bold text-lg px-4">{{ $page->title }}</h2>
    <x-page-content :content="$page->content"></x-page-content>
</x-layout>
