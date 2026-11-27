<?php

return [
    'required' => 'Kolom :Attribute wajib diisi.',
    'string' => 'Kolom :Attribute harus berupa teks.',
    'integer' => 'Kolom :Attribute harus berupa angka bulat.',
    'numeric' => 'Kolom :Attribute harus berupa angka.',
    'boolean' => 'Kolom :Attribute harus bernilai ya atau tidak.',
    'in' => 'Pilihan :Attribute tidak sah.',
    'exists' => ':Attribute yang dipilih tidak tersedia.',
    'image' => ':Attribute harus berupa gambar.',
    'mimes' => ':Attribute harus berformat :values.',
    'date_format' => 'Format :Attribute harus :format.',
    'after_or_equal' => ':Attribute harus setelah atau sama dengan :date.',

    'max' => [
        'string' => 'Kolom :Attribute maksimal :max karakter.',
        'numeric' => 'Kolom :Attribute maksimal :max.',
        'file' => ':Attribute maksimal :max kilobyte.',
        'array' => 'Kolom :Attribute maksimal :max item.',
    ],

    'min' => [
        'string' => 'Kolom :Attribute minimal :min karakter.',
        'numeric' => 'Kolom :Attribute minimal :min.',
        'file' => ':Attribute minimal :min kilobyte.',
        'array' => 'Kolom :Attribute minimal :min item.',
    ],

    'attributes' => [
        'title' => 'nama barang',
        'description' => 'deskripsi',
        'condition' => 'kondisi',
        'category_id' => 'kategori',
        'daily_rate' => 'harga per hari',
        'deposit_amount' => 'deposit',
        'pickup_point' => 'titik serah terima',
        'photo' => 'foto',
        'start_date' => 'tanggal mulai',
        'end_date' => 'tanggal selesai',
    ],
];
