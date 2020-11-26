<?php


namespace App\Services\FileUploaderService;


use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image as File;

class FileUploaderService implements FileUploaderServiceInterface
{
    public function uploadFile(string $path, UploadedFile $file)
    {
        $uploadDirectory = public_path() . '/' . $path;
        $this->createFolderIfNotExist($uploadDirectory);
        $filename = time()+rand(100,100000) . '.' . $file->getClientOriginalExtension();
        $filePath =  $uploadDirectory . '/' . $filename;
        File::make($file)->save($filePath);
        return $filename;
    }

    private function createFolderIfNotExist($uploadDirectory){
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }
    }
}
