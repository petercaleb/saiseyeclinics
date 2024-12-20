<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

trait FileUploadTrait
{
    /**
     * Open a file and return the stored file path.
     *
     * @param Request $request
     * @param string $fieldName
     * @param string $storagePath
     * @return string|null
     */
    public function openFile($file, $storage_path)
    {
        // Define the storage path for your files
        $storagePath = storage_path('app/public/' . $storage_path);

        // Full path to the file
        $filePath = $storagePath . '/' . $file;

        // Check if the file exists
        if (file_exists($filePath)) {

            // Get the file extension
            $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

            // Set the appropriate Content-Type header
            $contentType = $fileExtension === 'pdf' ? 'application/pdf' : 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';

            // Send the file as a response with headers
            return Response::make(file_get_contents($filePath), 200, [
                'Content-Type' => $contentType,
                'Content-Disposition' => 'inline; filename="' . $file . '"',
            ]);
        }

        return $filePath;
    }

    /**
     * Upload a file and return the stored file path.
     *
     * @param Request $request
     * @param string $fieldName
     * @param string $storagePath
     * @return string|null
     */

    public function uploadFile(Request $request, $fileName, $storagePath = 'public/uploads')
    {
        if ($request->hasFile($fileName) && $request->file($fileName)->isValid()) {
            // file name with extension
            $fileNameWithExt = $request->file($fileName)->getClientOriginalName();

            // Get Filename
            $getFileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            // Get just Extension
            $extention = $request->file($fileName)->getClientOriginalExtension();

            // Filename To store
            $fileNameToStore = $getFileName . '_' . time() . '.' . $extention;

            // Upload Image
            $request->file($fileName)->storeAs($storagePath, $fileNameToStore);

            return $fileNameToStore;
        }
        $fileNameToStore = "noimage.png";
        return $fileNameToStore;
    }

    /**
     * Remove file and return the stored file path.
     *
     * @param Request $request
     * @param string $fieldName
     * @param string $storagePath
     * @return string|null
     */

    public function delete_file($path, $file)
    {
        if ($file == 'noimage.png') {
            Storage::delete($path . $file);
            return true;
        }

        return false;
    }
}
