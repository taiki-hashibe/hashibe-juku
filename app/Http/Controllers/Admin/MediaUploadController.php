<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;

class MediaUploadController extends Controller
{
    public function uploadFile(FileReceiver $receiver): JsonResponse
    {

        // check if the upload is success, throw exception or return response you need
        if ($receiver->isUploaded() === false) {
            return response()->json(1);
        }
        // receive the file
        $save = $receiver->receive();
        if (!$save instanceof \Pion\Laravel\ChunkUpload\Save\AbstractSave) {
            return response()->json(2);
        }

        // check if the upload has finished (in chunk mode it will send smaller files)
        if ($save->isFinished()) {
            // save the file and return any response you need
            return $this->saveFile($save->getFile());
        }

        // we are in chunk mode, lets send the current progress
        /** @var AbstractHandler $handler */
        $handler = $save->handler();
        return response()->json([
            "done" => $handler->getPercentageDone()
        ]);
    }

    public function upload(Request $request): JsonResponse
    {
        // create the file receiver
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

        // check if the upload is success, throw exception or return response you need
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }

        // receive the file
        $save = $receiver->receive();
        if (!$save instanceof \Pion\Laravel\ChunkUpload\Save\AbstractSave) {
            return response()->json([
                'status' => false
            ]);
        }

        // check if the upload has finished (in chunk mode it will send smaller files)
        if ($save->isFinished()) {
            // save the file and return any response you need, current example uses `move` function. If you are
            // not using move, you need to manually delete the file by unlink($save->getFile()->getPathname())
            return $this->saveFile($save->getFile());
        }

        // we are in chunk mode, lets send the current progress
        /** @var AbstractHandler $handler */
        $handler = $save->handler();

        return response()->json([
            "done" => $handler->getPercentageDone(),
            'status' => true
        ]);
    }

    protected function saveFile(UploadedFile $file): JsonResponse
    {
        $fileName = $this->createFilename($file);
        // Group files by mime type
        $mimeType = $file->getMimeType();
        if (!$mimeType) {
            throw new \RuntimeException("Mime type not found");
        }
        $mime = str_replace('/', '-', $mimeType);
        // Group files by the date (week
        $dateFolder = date("Y-m-d");

        // Build the file path
        $filePath = "{$dateFolder}/";
        $finalPath = storage_path("app/public/videos/" . $filePath);

        // move the file name
        $file->move($finalPath, $fileName);

        return response()->json([
            'path' => $filePath,
            'name' => $fileName,
            'full_path' => asset("/storage/videos/" . $filePath . $fileName),
            'mime_type' => $mime
        ]);
    }

    protected function createFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace("." . $extension, "", $file->getClientOriginalName()); // Filename without extension

        // Add timestamp hash to name of the file
        $filename .= "_" . md5((string) time()) . "." . $extension;

        return $filename;
    }
}
