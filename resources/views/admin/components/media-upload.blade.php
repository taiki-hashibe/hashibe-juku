<input id="{{ $name }}-upload-route" type="hidden" value="{{ route('admin.media-upload.upload.file') }}">
<div id="{{ $name }}-resumable-drop" class="mb-3">
    <label id="{{ $name }}-resumable-browse"
        class="cursor-pointer w-full mb-4 block px-3 py-2 border border-slate-300 rounded-md text-start flex flex-col justify-center items-center py-4">
        <div id="{{ $name }}Preview" class="flex flex-col items-center">
            @if ($media)
                <video id="video-js" class="video video-js" playsinline controls>
                    <source src="{{ $media }}">
                </video>
                <span class="block mt-2 py-2 text-slate-700 cursor-pointer hover:underline">変更する</span>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 opacity-60 mb-3">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                </svg>
                <span class="text-sm opacity-60">アップロード</span>
            @endif
        </div>
    </label>
    <input type="hidden" name="{{ $name }}" id="{{ $name }}-form" value="{{ old('video') ?? $media }}">
</div>
