<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ExceptSymbol implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        // return !preg_match("/([@\#\$\%\^\_\=\<\>\{\}]+)/", $value);
        return !preg_match("/([{\}]+)/", $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        // return ':attribute tidak boleh mengandung simbol @#%^$_=<>{}.';
        // return ':attribute tidak boleh mengandung simbol {}.';
        return ':attribute field can not contain {} symbol.';
    }
}
