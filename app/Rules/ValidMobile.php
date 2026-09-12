<?php
namespace App\Rules;
use App\Models\Country;
use Illuminate\Contracts\Validation\Rule;
class ValidMobile implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $prefix;
    public $with_prefix;
    public $length_check;
    public $start_digit;
    public $check_start_digit;
    public function __construct($country_id=0)
    {
        if($country_id == 0){
            $c=Country::where('is_default',1)->first();
            $this->prefix=$c->prefix;
            $this->length_check=$c->mobile_digits;
            $this->with_prefix=$c->accept_prefix;
            if($this->with_prefix){
                $this->length_check+=strlen((string) $this->prefix);
            }
            $this->start_digit=$c->start_digit;
            $this->check_start_digit=$c->check_start_digit;
        }else{
            $c=Country::where('id',$country_id)->first();
            $this->prefix=$c->prefix;
            $this->length_check=$c->mobile_digits;
            $this->with_prefix=$c->accept_prefix;
            if($this->with_prefix){
                $this->length_check+=strlen((string) $this->prefix);
            }
            $this->start_digit=$c->start_digit;
            $this->check_start_digit=$c->check_start_digit;
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
        if (is_numeric ($value)){
            if(strlen((string) $value) == $this->length_check ){
                if($this->with_prefix){
                    if(substr($value,0,strlen((string) $this->prefix)) == $this->prefix){
                        if($this->check_start_digit){
                            if(substr($value,0,1) == $this->start_digit){
                                return true;
                            }
                        }

                    }
                }else{
                    if($this->check_start_digit){
                        if(substr($value,0,1) == $this->start_digit){
                            return true;
                        }
                    }else{
                        return true;
                    }
                }

            }
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

        if($this->with_prefix){
            return trans('validation.valid_mobile_prefix',['count'=>$this->length_check,'prefix'=>$this->prefix]);
        }elseif($this->check_start_digit){
            return trans('validation.valid_mobile_start_digit',['count'=>$this->length_check,'start_digit'=>$this->start_digit]);

        }else{
            return trans('validation.valid_mobile_length',['count'=>$this->length_check]);

        }




    }
}
