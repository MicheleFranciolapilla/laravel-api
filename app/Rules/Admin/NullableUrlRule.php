<?php

namespace App\Rules\Admin;

use Illuminate\Contracts\Validation\Rule;

class NullableUrlRule implements Rule
{
    public function passes($attribute, $value)
    {
        // dd($value, $attribute);
        var_dump(filter_var($value, FILTER_VALIDATE_URL));
        if ($value === null || $value === '') 
        {
            return true;
        }
        return filter_var($value, FILTER_VALIDATE_URL) !== false;
    }

    public function message()
    {
        return 'Il campo "url" deve essere vuoto oppure coincidere con un indirizzo "http" o "https" validi.';
    }
}
