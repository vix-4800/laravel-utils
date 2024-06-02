<?php

namespace Vix\LaravelUtils\Rules;

use Illuminate\Contracts\Validation\Rule;

class NewPassword implements Rule
{
    public function passes($attribute, $value)
    {
        return $value !== request('old_password');
    }

    public function message()
    {
        return 'The new password is the same as the old one.';
    }
}
