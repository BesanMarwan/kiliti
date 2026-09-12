<?php

use Barryvdh\TranslationManager\Models\Translation;
use Illuminate\Support\Facades\Cache;
use \Google\Cloud\Translate\V3\Client\TranslationServiceClient;

function set_if(&$var, $ret = '', $prefix = '')
{
    if (isset($var)) {
        return $prefix.$var;
    } else {
        return $ret;
    }
}
function lng($key,$def=""){
    return lang($key,[],$def);
}
function lang($key, $replacements = [], $defult = '',$lang='ar')
{

    $lang = app()->getLocale() ?? $lang;
//
//    if(!app()->getLocale()){
//        app()->setLocale('ar');
//    }
//    if($lang != app()->getLocale()){
//        app()->setLocale($lang);
//    }
    $trns = trans($key, $replacements);
    if ($trns == $key) {
        $arr = explode('.', $key, 2);
        $value = [
            'ar' => $defult,
            'en' => '',
        ];
        if (isset($arr[0]) && isset($arr[1])) {

            if ($defult == '') {
                $defult = str_replace('_', ' ', collect(explode('.', $arr[1]))->last());
                $trans_ar=Translation::where([
                    'locale' => 'ar',
                    'group' => $arr[0],
                    'key' => $arr[1],
                ])->first();
                $trans_en=Translation::where([
                    'locale' => 'en',
                    'group' => $arr[0],
                    'key' => $arr[1],
                ])->first();
                $value = [
                    'ar' => $trans_ar?$trans_ar->value:translate($defult, 'ar'),
                    'en' => $trans_en?$trans_en->value:translate($defult, 'en'),
                ];
            }else{
                $trans_ar=Translation::where([
                    'locale' => 'ar',
                    'group' => $arr[0],
                    'key' => $arr[1],
                ])->first();
                $trans_en=Translation::where([
                    'locale' => 'en',
                    'group' => $arr[0],
                    'key' => $arr[1],
                ])->first();
                $value = [
                    'ar' => $trans_ar?$trans_ar->value:$defult,
                    'en' => $trans_en?$trans_en->value:translate($defult, 'en'),
                ];
            }
            Translation::firstOrCreate([
                'locale' => 'ar',
                'group' => $arr[0],
                'key' => $arr[1],
            ], ['value' => $value['ar']]);
            Translation::firstOrCreate([
                'locale' => 'en',
                'group' => $arr[0],
                'key' => $arr[1],
            ], ['value' => $value['en']]);
        }

//        return $value[app()->getLocale()];
        return $value['ar'];
    }

    return $trns;
}
function translate($text, $targetLanguage)
{

    /** Uncomment and populate these variables in your code */
    // $text = 'The text to translate.'
    // $targetLanguage = 'ja';  // Language to translate to
    $model = 'base';  // "base" for standard edition, "nmt" for premium
    try{
        if(cache()->get($text.'__'.$targetLanguage)){
            return cache()->get($text.'__'.$targetLanguage);
        }
        $translate = new \Google\Cloud\Translate\V3\Client\TranslationServiceClient(['key' => 'AIzaSyCb85vm81DOLoPj-3qKSN8EZtDOPnKiwwQ', 'model' => 'base']);
        $result = $translate->translate($text, [
            'target' => $targetLanguage,
            'model' => $model,
        ]);

        if( isset($result['text'])){
            cache()->set($text.'__'.$targetLanguage,$result['text']);
            return isset($result['text']) ? $result['text'] : $text;
        }

        return  $text;
    }catch (Exception $exception){
        return  $text;

    }


}
function currency()
{
    return Cache::remember('currency', 500, function () {
        return \App\Models\Country::where('is_default', 1)->first()->currency;
    });
}
