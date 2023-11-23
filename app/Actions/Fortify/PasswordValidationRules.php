<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    protected function passwordRules(): array
    {
        return [
         'required',
         'string',
         new Password,
         'between:8,15', // Enforce password length between 8 and 15 characters.
        'regex:/^[A-Za-z]/', // Password must start with an alphabet.
            'regex:/[!@#.\-$]/', // Password must contain at least one special character from the list: @, #, ., -, $
            'regex:/^[A-Za-z0-9@#.\-$]+$/u', // Allow only specified characters.
         'confirmed'];
    }
}
