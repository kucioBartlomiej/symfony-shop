<?php

namespace AppBundle\File;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileManager {
    
    
    public function upload(string $path, string $newFileName, UploadedFile $file)
    {
        $fileName = $newFileName.'.'.$file->guessExtension();
        $file->move($path, $fileName);
    }
    
    public function delete(string $path, string $fileName)
    {
        $file = $path.$fileName;
        if (file_exists($file)) 
        {
            unlink($file);
        }
    }
    
    
}
