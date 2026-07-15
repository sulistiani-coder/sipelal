<?php

return [
    'institution_name' => env('INSTITUTION_NAME', 'Universitas Umum'),
    'email_domain' => env('INSTITUTION_EMAIL_DOMAIN', 'student.ac.id'),
    'nim_length' => env('NIM_LENGTH', 8),
    'fine_per_day' => env('FINE_PER_DAY', 5000),
    'max_loan_days_mahasiswa' => env('MAX_LOAN_DAYS_MAHASISWA', 7),
    'max_loan_days_dosen' => env('MAX_LOAN_DAYS_DOSEN', 14),
    'max_active_loans_mahasiswa' => env('MAX_ACTIVE_LOANS_MAHASISWA', 3),
    'max_items_per_loan' => env('MAX_ITEMS_PER_LOAN', 5),
    'tujuan_options' => [
        'Praktikum Terjadwal',
        'Tugas Mandiri',
        'Penelitian Skripsi/Tesis',
        'Kegiatan Organisasi',
        'Lainnya',
    ],
    'mata_kuliah_options' => [
        'Matematika',
        'Fisika',
        'Kimia',
        'Biologi',
        'Pemrograman',
        'Sistem Digital',
        'Instrumen Laboratorium',
    ],
    'reminder_pickup_hour' => 8,
    'reminder_return_hour' => 8,
    'denda_per_hari' => env('DENDA_PER_HARI', 5000),
];
