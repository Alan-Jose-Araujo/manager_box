<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;

trait UploadFiles
{
    /**
     * Create a fake file for testing purposes.
     * @param array $fileData<string, mixed>
     * Keys: name (string), size (int in KB), mimeType (string)
     * @return \Illuminate\Http\Testing\File
     */
    private function generateFakeFile(array $fileData = []): UploadedFile
    {
        return UploadedFile::fake()->create(
            $fileData['name'] ?? 'file.txt',
            $fileData['size'] ?? 100,
            $fileData['mimeType'] ?? 'text/plain'
        );
    }

    /**
     * Store the uploaded file to the specified disk and path.
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $disk
     * @param mixed $path
     * @return bool|string
     */
    private function storeFileAndGetPath(UploadedFile $file, string $disk = 'public', ?string $path = null): string
    {
        return $file->store($path, $disk);
    }
}
