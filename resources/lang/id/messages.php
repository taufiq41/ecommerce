<?php

return [
    'required' => ':attribute harus diisi.',
    'otp' => [
        'wrong' => 'Kode OTP salah',
        'sent' => 'Kode OTP telah kami kirimkan',
        'resend' => 'Kami telah mengirimkan ulang kode OTP baru',
        'failed_to_sent' => 'OTP gagal dikirim, sepertinya data yang kamu masukkan salah atau sistem sedang bermasalah. Silahkan coba lagi',
        'wrong_or_expired' => 'Kode OTP yang Anda masukkan salah atau kadaluarsa',
        'max_retry' => 'Batas maksimal percobaan telah habis',
        'expired_at' => 'Kode OTP akan kadaluarsa dalam',
        'has_expired' => 'Kode OTP telah kadaluarsa, silahkan kirim ulang',
        'link' => 'Atau, kamu juga dapat melakukan verifikasi melalui tautan ini :link',
        'not_same_as_session' => ':attribute belum verifikasi OTP',
        'can_not_same_as_existing' => ':attribute tidak boleh sama dengan :attribute saat ini',
        'messages' => [
            'register_new_account' => 'Data registrasi kamu telah berhasil kami terima. Verifikasi akun kamu dengan kode OTP berikut:',
            'reset_password' => 'Permintaan reset password kamu telah berhasil kami terima. Berikut kode OTP untuk reset password kamu:',
            'change_email' => 'Permintaan ganti email kamu telah berhasil kami terima. Berikut kode OTP untuk ganti email kamu:',
            'change_phone_number' => 'Permintaan ganti nomor telepon kamu telah berhasil kami terima. Masukan kode verifikasi berikut ini untuk mengganti kata sandi:',
        ]
    ],
    'insert' => [
        'success' => 'Berhasil menambahkan data :attribute',
        'failed' => 'Gagal menambahkan data :attribute',
    ],
    'update' => [
        'success' => 'Berhasil menyimpan data :attribute',
        'failed' => 'Gagal menyimpan data :attribute',
    ],
    'restore' => [
        'success' => 'Berhasil mengembalikan data :attribute',
        'failed'  => 'Gagal mengembalikan :attribute',
    ],
    'delete' => [
        'success' => 'Berhasil menghapus data :attribute',
        'failed' => 'Gagal menghapus data :attribute',
        'failed_because_relations' => 'Gagal menghapus data :attribute, karena data ini telah memiliki relasi',
    ],
    'username' => [
        'not_found' => 'Username yang anda masukan tidak terdaftar',
    ],
    'password' => [
        'update' => [
            'success' => 'Password berhasil diganti, silahkan login kembali menggunakan password baru',
            'failed' => 'Password gagal diganti',
            'old_inccorect' => 'Password lama yang anda masukan salah',
        ]
    ],
    'data' => [
        'not_found' => 'Data :attribute tidak ditemukan!'
    ],
    'activity' => [
        'update' => [
            'quota_limit_reached' => 'Perpanjangan tidak bisa dilakukan karena kuota perpanjangan kamu tersisa :transaction_extended_quota kali untuk transaksi ini',
            'due_date_less_than_now' => 'Batas waktu pengembalian sudah lewat'
        ],
    ],
    'error' => [
        'database' => 'Ada Kesalahan Sistem :attribute'
    ],
    'report' => [
        'generate' => 'Generate Laporan Maksimal :attribute hari'
    ],
    'custom_message'  => ':attribute',
];
