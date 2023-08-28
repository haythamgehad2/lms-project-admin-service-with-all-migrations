<?php
namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadImageTrait {

    /**
     * Undocumented function
     *
     * @param UploadedFile $file
     * @param [type] $path
     * @return void
     */
    private static function moveFileToPublic(UploadedFile $file, $path) {
        $fileName = time() .'-'. rand(1000,10000) .  '.' . $file->getClientOriginalExtension();
        Storage::disk('root-public')->put($path ."/". $fileName, $file->get());
        return "$path/$fileName";
    }

     /**
      * Undocumented function
      *
      * @param [type] $files
      * @param [type] $collection
      * @param boolean $hasDefault
      * @param string $disk
      * @return object
      */
   public function saveFiles($files, $collection = null, $disk = 'public')
    {
       $collection = $collection ?? $this->mediaCollectionName;
       if (is_array($files)) {
           foreach ($files as $key => $file) {
               $media = $this->addMedia($file)->usingFileName(time().'.'.$file ->extension())->toMediaCollection($collection, $disk);
           }
       } else {
           $media = $this->addMedia($files)->usingFileName(time().'.'.$files->extension())->toMediaCollection($collection, $disk);
       }

       return $media;
   }


   /**
    * Undocumented function
    *
    * @param [type] $files
    * @param [type] $collection
    * @param boolean $hasDefault
    * @param [type] $disk
    * @return object
    */
   public function updateFile($files, $collection = null, $hasDefault = true, $disk=null)
   {
       $collection = $collection ?? $this->mediaCollectionName;
       $disk = $disk ? $disk:'public';
       $this->clearMediaCollection($collection);
       $this->saveFiles($files, $collection, $disk);
   }


   /**
    * Defult Image Url function
    *
    * @return string
    */
   public function getDefaultImageUrlAttribute(): string
   {
       if ($image = $this->getMedia($this->mediaCollectionName)->first()) {
           return $image->getFullUrl();

       }

       return asset('/images/default.jpg');
   }


   /**
    * getImage url function
    *
    * @return string
    */
   public function getImgUrlAttribute(): string
   {
       if ($image = $this->getMedia($this->mediaCollectionName)->first()) {

           return $image->getFullUrl();

       }

       return asset('/images/default.jpg');
   }


   /**
    * Get Image Url function
    *
    * @return array
    */
   public function getImagesUrlAttribute(): array
   {
       $images = $this->getMedia($this->mediaCollectionName)->map(function ($image) {
           return $image->getFullUrl();
       })->toArray();

       return $images;
   }

   /**
    * GetImagesAttribute
    */
   public function getImagesAttribute()
   {
       return $this->getMedia($this->mediaCollectionName);
   }
}
