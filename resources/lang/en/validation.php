<?php

return [

    'required' => 'The :attribute field is required.',
    'email' => 'The :attribute must be a valid email address.',
    'unique' => 'The :attribute has already been taken.',
    'confirmed' => 'The :attribute confirmation does not match.',

    'min' => [
        'string' => 'The :attribute must be at least :min characters.',
    ],

    'password' => [
        'letters' => 'The :attribute must contain at least one letter.',
        'mixed' => 'The :attribute must contain at least one uppercase and one lowercase letter.',
        'numbers' => 'The :attribute must contain at least one number.',
        'symbols' => 'The :attribute must contain at least one symbol.',
        'uncompromised' => 'The given :attribute has appeared in a data leak. Please choose a different :attribute.',
    ],

    'attributes' => [
        'name' => 'name',
        'email' => 'email',
        'password' => 'password',
    ],

];
