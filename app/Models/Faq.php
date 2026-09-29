<?php

namespace App\Models;

use App\Traits\HasSearchable;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory,HasTranslations,HasSearchable;

    /**
     * @var array
     */
    public $translatable = ['answer','question'];

    /**
     * @var array
     */
    protected $fillable = ['question','answer'];



    public static function getSearchable()
    {
        return [
            'question' => [
                'type' => 'string',
                'operation' => 'like',
                'title' =>'السؤال',
            ],

        ];
    }

}
