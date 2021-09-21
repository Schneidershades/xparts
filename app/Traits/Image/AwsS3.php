<?php

namespace App\Traits\Image;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AwsS3
{
    function storeImage($connection, $image)
    {
        $extension = $image->getClientOriginalExtension();
        $name = Str::slug(now()->toDayDateTimeString())
            .random_int(20, 3000000)
            .'.'
            .$extension;
            
        Storage::disk($connection)->put($path = "public/images/ride_request/$name", fopen($image, 'r+'));

        return config('services.s3.url').$path;
    }
}


