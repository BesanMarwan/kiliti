<?php
namespace App\Rules;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
class MinDate implements Rule
{
    public $nowDate;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($now='')
    {
        if($now !=''){
            $this->nowDate=Carbon::parse($now);
        }else{
            $this->nowDate=Carbon::now()->startOfDay();
        }
    }
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $val=Carbon::parse($value);
        if($this->nowDate->lte($val)){
            return true;
        }
        return false;
    }
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'يجب ادخال تاريخ اكبر من '.$this->nowDate->toDateString();
    }
}
