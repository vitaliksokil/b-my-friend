<?php


namespace App\Services\FileUploaderService;


interface FileUploaderServiceInterface
{
    public function uploadFile(string $path, $file);
}
