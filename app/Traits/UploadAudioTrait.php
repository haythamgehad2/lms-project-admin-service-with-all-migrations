<?php
namespace App\Traits;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait UploadAudioTrait {

    /**
     * Undocumented function
     *
     * @param UploadedFile $file
     * @param [type] $path
     * @return void
     */
    public function uplodeAudio($file, $path,$item,$key) {

        $audio_file = $file;
        // This will return "mp3" not the file name
        $fileName = $item->id .'_'.time() . '.' . $audio_file->getClientOriginalExtension();
        // This will return /audio/mp3
        $location = public_path($path);
        // This will move the file to /public/audio/mp3/
        // and save it as "mp3" (not what you want)
        // example: /public/audio/mp3/mp3 (without extension)
        $audio_file->move($location,$fileName);
        // mp3 row in your column will just say "mp3"
        // since the $filename above is just an extension of the file
        $item->update([$key=>$fileName]);

    }


    /**
     * Undocumented function
     *
     * @param UploadedFile $file
     * @param [type] $path
     * @return void
     */
    public function updateAudio($file, $path,$item,$key) {


        if(File::exists(public_path().'/'.$path.'/'.$item->$key)){
            File::delete(public_path().'/'.$path.'/'.$item->key);
        }

        $audio_file = $file;
        // This will return "mp3" not the file name
        $fileName = $item->id .'_'.time() . '.' . $audio_file->getClientOriginalExtension();
        // This will return /audio/mp3
        $location = public_path($path);
        // This will move the file to /public/audio/mp3/
        // and save it as "mp3" (not what you want)
        // example: /public/audio/mp3/mp3 (without extension)
        $audio_file->move($location,$fileName);
        // mp3 row in your column will just say "mp3"
        // since the $filename above is just an extension of the file
        $item->update([$key=>$fileName]);
        $item->save();

    }





}
