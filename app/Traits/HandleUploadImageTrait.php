<?php

namespace App\Traits;

use App\Models\Image;

trait HandleUploadImageTrait
{
    protected $path = 'uploads/';
    public function verify($request)
    {
        return $request->has('image');
    }
    public function saveImage($request)
    {
        if ($this->verify($request)) {
            $image = $request->file('image');
            $name = time() . $image->getClientOriginalName();
            $image->move($this->path, $name);
            return $name;
        }
        return null; // Return null if no image is uploaded
    }
    public function UpdateImage($request, $currentImage)
    {
        if ($this->verify($request)) {
            $this->deleteImage($currentImage);
            return $this->saveImage($request);
        }
        return $currentImage;
    }
    public function deleteImage($imageName)
    {
        if ($imageName && file_exists($this->path . $imageName)) {
            unlink($this->path . $imageName);
        }
    }
}
