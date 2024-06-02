<?php

namespace Vix\LaravelUtils\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneNumber implements Rule
{
    public function passes($attribute, $value)
    {
        return preg_match('/^\+?[1-9]\d{1,14}$/', $value);
    }

    public function message()
    {
        return 'The :attribute is not a valid phone number.';
    }
}
