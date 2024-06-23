<?php

namespace App\Traits;


use App\Models\Image;

use Illuminate\Support\Facades\Storage;


// use getID3; pour les video get the duration

trait ImageTrait
{


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////         IMAGES
   ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   protected function imageName($imageable_id, $image)
   {
       $image = uniqid() . "-" . $imageable_id . "." . $image->extension();
       return $image;
   }

   protected function imagePath($imageName, $image)
   {
       $path = $image->storeAs('images', $imageName, 'public');
       return $path;
   }
   protected function uploadAndCreateImage(
       $image,
       $imageable_id,
       $imageable_type,
       $useCase
   ) {
       $imageName = $this->imageName($imageable_id, $image);
       $imagePath = $this->imagePath($imageName, $image);

       $dimensions = getimagesize($image->getRealPath());

       // Index 0 contains the width and index 1 contains the height
       $width = $dimensions[0];
       $height = $dimensions[1];

       $url = Storage::disk('public')->url($imagePath);
       // $url = 'http://105.96.104.158:8000/storage/images/' . $imageName;
       $size = Storage::disk('public')->size($imagePath);
       $data = [
           "name" => $imageName,
           "path" => $imagePath,
           "url" => $url,
           "size" => $size,
           "width" => $width,
           "height" => $height,
           "use_case" => $useCase,
           "imageable_id" => $imageable_id,
           "imageable_type" => $imageable_type
       ];
       $createdImages[] = Image::create($data);
   }

   protected function uploadAndCreateImages(
       $images,
       $imageable_id,
       $imageable_type,
       $useCase
   ) {
       $createdImages = [];
       foreach ($images as $image) {
           $this->uploadAndCreateImage(
               $image,
               $imageable_id,
               $imageable_type,
               $useCase
           );
       }
       return $createdImages;
   }


   protected function uploadAndUpdateImages($images, $imageable_id, $imageable_type, $useCase)
   {
       // Find and delete old images with the given imageable_id and imageable_type
       $oldImages = Image::where('imageable_id', $imageable_id)
           ->where('imageable_type', $imageable_type)
           ->get();
       if ($oldImages) {
           foreach ($oldImages as $oldImage) {
               Storage::disk('public')->delete($oldImage->path);
               $oldImage->delete();
           }
       }
       $this->uploadAndCreateImages(
           $images,
           $imageable_id,
           $imageable_type,
           $useCase
       );
   }

   protected function uploadAndUpdateImage($image, $imageable_id, $imageable_type, $useCase)
   {
       // Find and delete old images with the given imageable_id and imageable_type
       $oldImage = Image::where('imageable_id', $imageable_id)
           ->where('imageable_type', $imageable_type)
           ->first();
       if ($oldImage) {
        $this->deleteImage($oldImage);
       }
       $this->uploadAndCreateImage(
           $image,
           $imageable_id,
           $imageable_type,
           $useCase
       );
   }

   public  function deleteImage($image){
    Storage::disk('public')->delete($image->path);
    $image->delete();
   }
public function deleteImages($images){
    foreach ($images as $image) {
        $this->deleteImage($image);
    }
}
}
