<?php


namespace App\Services\FileUploaderService;


use Illuminate\Http\UploadedFile;

interface FileUploaderServiceInterface
{
    public function uploadFile(string $path, UploadedFile $file);
}
