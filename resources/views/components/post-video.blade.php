@if ($video)
    <div class="mb-8">
        <div class="w-full aspect-video">
            <video id="video-js" class="w-full h-full video video-js" playsinline controls>
                <source src="{{ $video }}">
            </video>
        </div>
    </div>
@endif
