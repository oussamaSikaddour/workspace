<?php

namespace App\Traits;


use App\Models\Image;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Storage;

// use getID3; pour les video get the duration

trait Utilities
{

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

        $url = Storage::disk('public')->url($imagePath);
        // $url = 'http://105.96.104.158:8000/storage/images/' . $imageName;
        $size = Storage::disk('public')->size($imagePath);
        $data = [
            "name" => $imageName,
            "path" => $imagePath,
            "url" => $url,
            "size" => $size,
            "width" => 50,
            "height" => 50,
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
            Storage::disk('public')->delete(optional($oldImage)->path);
            $oldImage->delete();
        }
        $this->uploadAndCreateImage(
            $image,
            $imageable_id,
            $imageable_type,
            $useCase
        );
    }

    protected function calculateTotalHours($startTime, $endTime)
{
    $start = strtotime($startTime);
    $end = strtotime($endTime);

    if ($start > $end) {
        $end += 86400; // Add 24 hours in seconds if end time is smaller (e.g., end time is the next day)
    }

    $diff = $end - $start;
    $totalHours = $diff / (60 * 60); // Convert seconds to hours

    return $totalHours;
}




protected function getTotalDays($startDate, $endDate, $workingDays)
{
    $startDate = Carbon::parse($startDate);
    $endDate = Carbon::parse($endDate);

    if ($startDate > $endDate) {
        return 0; // Invalid date range, return 0
    }

    $totalDays = $endDate->diffInDays($startDate) + 1; // Calculate the total days of the period

    $daysOff = $startDate->diffInDaysFiltered(function ($date) use ($workingDays) {
        return !in_array($date->dayOfWeek, $workingDays);
    }, $endDate);

    $totalDays -= $daysOff; // Subtract the non-working days from the total days

    return $totalDays;
}


}
