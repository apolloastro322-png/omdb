<?php

return [

    'required' => 'Kolom :attribute wajib diisi.',
    'email' => 'Kolom :attribute harus berupa email yang valid.',
    'unique' => 'Kolom :attribute sudah digunakan.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',

    'min' => [
        'string' => 'Kolom :attribute minimal :min karakter.',
    ],

    'password' => [
        'letters' => 'Kolom :attribute harus mengandung minimal satu huruf.',
        'mixed' => 'Kolom :attribute harus mengandung huruf besar dan kecil.',
        'numbers' => 'Kolom :attribute harus mengandung minimal satu angka.',
        'symbols' => 'Kolom :attribute harus mengandung minimal satu simbol.',
        'uncompromised' => 'Kolom :attribute pernah bocor di internet, gunakan password lain.',
    ],

    'attributes' => [
        'name' => 'nama',
        'email' => 'email',
        'password' => 'password',
    ],

];
