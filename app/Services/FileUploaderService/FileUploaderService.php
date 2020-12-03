<?php


namespace App\Services\FileUploaderService;


use Illuminate\Support\Str;

class FileUploaderService implements FileUploaderServiceInterface
{
    public function uploadFile(string $path, $file)
    {
        $uploadDirectory = public_path() . '/' . $path;
        $this->createFolderIfNotExist($uploadDirectory);
        $image = $file;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = Str::random(10).'.'.'png';
        \File::put($uploadDirectory .'/'. $imageName, base64_decode($image));
        return $imageName;
    }

    private function createFolderIfNotExist($uploadDirectory){
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }
    }
}
