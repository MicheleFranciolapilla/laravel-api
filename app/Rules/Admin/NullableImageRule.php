<?php

namespace App\Rules\Admin;

use Illuminate\Contracts\Validation\Rule;

class NullableImageRule implements Rule
{
    public function passes($attribute, $value)
    {
        if ($value === null || $value === '') 
        {
            $value = null;
            var_dump('Vuoto: ', $value);
            return true;
        }
        if (@getimagesize($value))
        {
            var_dump('valido: ', $value);
            return true;
        }
        var_dump('non valido: ', $value);
        return false;
    }

    public function message()
    {
        return "Il file selezionato non è valido o non corrisponde ad un'immagine!";
    }
} 
 