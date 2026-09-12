<?php

namespace App\Traits;


use App\Models\Country;

trait AddMobilePrefix
{

    public function getMobilePrefixAttribute()
    {
        if($this->country){
            $c= $this->country;
        }else{
            $c=Country::where('is_default',1)->first();

        }
        return $c->prefix.$this->mobile;
    }
}
