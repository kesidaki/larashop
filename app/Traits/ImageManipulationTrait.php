<?php 

namespace App\Traits;

use Image;
use Illuminate\Support\Facades\File;

trait ImageManipulationTrait 
{

	/**
    * Store Product Image and creates a thumbnail
    * For thumbnail: 
    *   Resizes image to set proportions ($thumbnailSize) while keeping the aspect intact
    *   Then, place the image at the center of a square canvas, 
    *   to make sure the thumbnail is a set height and width
    * Save Image and Thumbnail on their respective directories
    * And return the name used to store the images
    *
    * @param $path - path the image will be saved to
    * @param $image - image file
    * @param $name - name of the image
    * @param $size - size (width/height) of the image
    * @param $square - boolean, defines if the image will be inserted into a square container
    */
    public function storeImage($path, $image, $name, $size, $square=true) 
    {
        $imagename = $name.'.'.$image->getClientOriginalExtension();
        $img       = Image::make($image->getRealPath());

        $img->resize($size, $size, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        if ($square) {
        	// Create Canvas for thumbnail
	        $canvas = Image::canvas($size, $size);
	        // Insert the image on the center of the canvas and then save it
	        $canvas->insert($img, 'center');
	        $canvas->save($path.'/'.$imagename);
        }
        else {
        	// Save to Image
        	$img->save($path.'/'.$imagename);
        }

        return $imagename;
    }

    /**
    * Copies an already uploaded image, then resizes it
    */
    public function manipulateImage($imgPath, $name, $size, $square=true) 
    {
        $img = Image::make($imgPath.$name);

        $img->resize($size, $size, function ($constraint) {
            $constraint->aspectRatio();
        })->save();

        return $name;
    }

    /**
    * Add Text to an Image
    * @param $imgPath: path to the original image
    * @param $textArr: array of text and it's information
    *                  -- context
    *                  -- offsetX
    *                  -- offsetY
    *                  -- font
    *                  -- size
    *                  -- color
    * @param $finalName: name of the resulting image
    */
    public function addTextToImage($imgPath, $textArr, $finalName) 
    {
        $img = Image::make($imgPath);

        foreach ($textArr as $text) {
            $img->text($text['context'], $text['offsetX'], $text['offsetY'], function($font) use ($text) {  
                $font->file($text['font']);
                $font->size($text['size']);
                $font->color($text['color']);
            }); 
        }

        $img->save($finalName);

        return $img;
    }

}

?>