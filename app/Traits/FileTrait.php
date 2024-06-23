<?php

namespace App\Traits;


use App\Models\File;

use Illuminate\Support\Facades\Storage;


// use getID3; pour les video get the duration

trait FileTrait
{


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////         fileS
   ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   protected function fileName($fileable_id, $file)
   {
       $file = uniqid() . "-" . $fileable_id . "." . $file->extension();
       return $file;
   }

   protected function filePath($fileName, $file)
   {
       $path = $file->storeAs('files', $fileName, 'public');
       return $path;
   }
   protected function uploadAndCreateFile(
       $file,
       $fileable_id,
       $fileable_type,
       $useCase
   ) {
       $fileName = $this->fileName($fileable_id, $file);
       $filePath = $this->filePath($fileName, $file);
       $url = Storage::disk('public')->url($filePath);
       $size = Storage::disk('public')->size($filePath);
       $data = [
        "name" => $fileName,
        "path" => $filePath,
        "url"=>$url,
        "size" => $size,
        "use_case" => $useCase,
        "fileable_id" => $fileable_id,
        "fileable_type" => $fileable_type
    ];
       $createdFiles[] = file::create($data);
   }

   protected function uploadAndCreateFiles(
       $files,
       $fileable_id,
       $fileable_type,
       $useCase
   ) {
       $createdFiles = [];
       foreach ($files as $file) {
           $this->uploadAndCreateFile(
               $file,
               $fileable_id,
               $fileable_type,
               $useCase
           );
       }
       return $createdFiles;
   }


   protected function uploadAndUpdateFiles($files, $fileable_id, $fileable_type, $useCase)
   {
       // Find and delete old files with the given fileable_id and fileable_type
       $oldFiles = file::where('fileable_id', $fileable_id)
           ->where('fileable_type', $fileable_type)
           ->get();
       if ($oldFiles) {
           foreach ($oldFiles as $oldFile) {
               Storage::disk('public')->delete($oldFile->path);
               $oldFile->delete();
           }
       }
       $this->uploadAndCreateFiles(
           $files,
           $fileable_id,
           $fileable_type,
           $useCase
       );
   }

   protected function uploadAndUpdateFile($file, $fileable_id, $fileable_type, $useCase)
   {
       // Find and delete old files with the given fileable_id and fileable_type
       $oldFile = file::where('fileable_id', $fileable_id)
           ->where('fileable_type', $fileable_type)
           ->first();
       if ($oldFile) {
        $this->deleteFile($oldFile);
       }
       $this->uploadAndCreateFile(
           $file,
           $fileable_id,
           $fileable_type,
           $useCase
       );
   }

   public  function deleteFile($file){
    Storage::disk('public')->delete($file->path);
    $file->delete();
   }
public function deleteFiles($files){
    foreach ($files as $file) {
        $this->deleteFile($file);
    }
}
}
