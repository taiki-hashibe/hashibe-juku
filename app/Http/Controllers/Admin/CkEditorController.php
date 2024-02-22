<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class CkEditorController extends Controller
{
    public function imageUpload(): JsonResponse
    {
        $file = request()->file('image');
        if (is_array($file)) {
            $file = $file[0];
        }
        if (!$file instanceof \Illuminate\Http\UploadedFile) {
            return response()->json([
                'uploaded' => false,
                'error' => [
                    'message' => 'The given data was invalid.',
                    'errors' => [
                        'image' => [
                            'The image field is required.'
                        ]
                    ]
                ]
            ]);
        }
        $file = $file->store('post_images', 'public');
        return response()->json([
            'uploaded' => true,
            'url' => asset('storage/' . $file)
        ]);
    }
}
