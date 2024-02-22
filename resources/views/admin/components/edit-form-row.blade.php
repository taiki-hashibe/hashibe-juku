<div class="flex flex-col md:flex-row">
    <div class="w-full md:basis-40 md:p-4 md:pl-8 text-slate-500 dark:text-slate-400 font-bold">
        <span class="inline-block ps-3 md:ps-0 py-2">
            @if (isset($required) && $required)
                <span class="text-red-500">*</span>
            @endif
            {{ $label }}
        </span>
    </div>
    <div class="w-full md:basis-0 grow mb-4 md:mb-0 md:p-4 md:pl-8 text-slate-700 dark:text-slate-400">
        {{ $field }}
    </div>
</div>
