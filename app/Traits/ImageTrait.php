<?php

namespace App\Traits;



use Illuminate\Database\Eloquent\Casts\Attribute;

trait ImageTrait
{

    /**
     * @return string
     */

    protected function ImageUrl(): Attribute
    {
        $logo=isset($this->attributes['image'])?$this->attributes['image']:'';
        if($logo){
            $base_path=  realpath('public/uploads/') ? realpath('public/uploads/') : realpath('uploads/');
            $path=$base_path.'/'.$logo;
            if(!file_exists($path)){
                $old_path=$base_path.'/'.$logo;
                if(file_exists($old_path)){
                    rename($old_path, $path);
                }
            }
        }
        $image = $logo?asset('uploads/'.$logo):asset('assets/media/default.png');
        return Attribute::make(
            get: fn ($value) => $image,
        );
    }
//    public function getImageUrlAttribute()
//    {
//
//
//
//        return ;
//    }

}
