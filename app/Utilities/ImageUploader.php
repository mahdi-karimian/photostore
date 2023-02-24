<?php

namespace App\Utilities;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageUploader
{
    public static function upload($image, $path, $diskType)
    {
        if (!is_null($image)) {
            Storage::disk($diskType)->put($path, File::get($image));

        }
    }

    public static function uploadMany(array $images, $path, $diskType = 'public_storage')
    {
        $imagesPath = [];
        foreach ($images as $key => $image) {
            $fullPath = $path . $key . '_' . $image->GetClientOriginalName();
            if (!is_null($image)) {
                self::upload($images, $fullPath, $diskType);
            }
            //  Storage::disk($diskType)->put($fullPath, File::get($image));
            $imagesPath += [$key => $fullPath];
        }
        return $imagesPath;
    }


}
