<?php

namespace App\Models;

use App\Traits\HasSearchable;
use App\Traits\HasStatus;
use App\Traits\HasTranslations;
use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Model;

class FamilyPermissionType extends Model
{
    use HasTranslations,HasSearchable,HasStatus;
    public $translatable = ['label'];
    public $guarded = [];
}
