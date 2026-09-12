<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactReplay extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden  = ['updated_at','owner_type'];
    protected $appends =['type'];

    public function contact(){
        return $this->belongsTo(Contact::class,'contact_id');
    }

    public function owner()
    {
        return $this->morphTo();
    }

    public function getTypeAttribute(){
        switch($this->owner_type){
            case Admin::class : return 'admin';
            case User::class : return 'user';
        }
    }
}
