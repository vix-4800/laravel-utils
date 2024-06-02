<?php

namespace Vix\LaravelUtils\Rules;

use Illuminate\Contracts\Validation\Rule;

class Domain implements Rule
{
    public function passes($attribute, $value)
    {
        return filter_var($value, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME);
    }

    public function message()
    {
        return 'The :attribute must be a valid domain name.';
    }
}
