<?php

/**
 * Arsip konten dpm.uii.ac.id (situs lama) yang diambil sebelum situs tersebut down.
 *
 * - Produk hukum: nomor, tahun, judul, dan tautan Google Drive asli.
 * - Laporan: entri laporan keuangan yang tautannya tersimpan di arsip.
 * - Sejarah: kutipan dari halaman beranda lama.
 *
 * Entri tanpa tautan dibiarkan kosong; admin dapat mengunggah berkasnya nanti.
 */
return [
    'legal_products' => [
        [
            'type' => 'pdkm',
            'title' => 'Peraturan Dasar Keluarga Mahasiswa UII',
            'external_url' => 'https://drive.google.com/file/d/16hQHb5cweCfarxCJcEcMu5NiDN_ZeKCA/view?usp=share_link',
            'description' => 'Konstitusi tertinggi KM UII yang mengatur struktur dasar organisasi, asas, tujuan, kelembagaan, dan sistem pemerintahan mahasiswa.',
        ],
        [
            'type' => 'gbhkm',
            'title' => 'Garis-Garis Besar Haluan Keluarga Mahasiswa UII',
            'external_url' => 'https://drive.google.com/file/d/1leWSrtFA1wtwKNi1I7HuWKpnexEvU55d/view?usp=share_link',
            'description' => 'Pedoman arah kebijakan KM UII per periode: visi-misi, proyeksi masa depan, dan strategi pengembangan organisasi kemahasiswaan.',
        ],

        // PKM 2018
        ['type' => 'pkm', 'number' => 1, 'year' => 2018, 'title' => 'Tentang Pemilihan Umum Wakil Mahasiswa UII', 'external_url' => 'https://drive.google.com/file/d/1dujeRvT8REMMpeKGUBuOj8ZsAeM2Evkg/view'],
        ['type' => 'pkm', 'number' => 2, 'year' => 2018, 'title' => 'Tentang Pengelolaan Aspirasi UII', 'external_url' => 'https://drive.google.com/file/d/1bDo1PPD7ETyDfC2dkQq_baDEFpoTwyAr/view'],
        ['type' => 'pkm', 'number' => 3, 'year' => 2018, 'title' => 'Tentang Produksi Jas Almamater KM UII', 'external_url' => 'https://drive.google.com/file/d/1rFZTIC8A-ZSEucEm0LhIUSgWS1mo8icP/view'],
        ['type' => 'pkm', 'number' => 4, 'year' => 2018, 'title' => 'Tentang Pedoman Keanggotaan KM UII', 'external_url' => 'https://drive.google.com/file/d/1Ef3Q2bs5wLu7SOmAZoBoyVY2XDuk8sA8/view'],
        ['type' => 'pkm', 'number' => 5, 'year' => 2018, 'title' => 'Tentang Pedoman Administrasi KM UII', 'external_url' => 'https://drive.google.com/file/d/1qZnORDu4E2oF0_t2wYcwMOkFhbkOpLSu/view'],
        ['type' => 'pkm', 'number' => 6, 'year' => 2018, 'title' => 'Tentang Pedoman Keuangan KM UII', 'external_url' => 'https://drive.google.com/file/d/1Q9MLo5k--VfuMuWqtd7EMqJ7_B0Tx4aU/view'],
        ['type' => 'pkm', 'number' => 7, 'year' => 2018, 'title' => 'Tentang Kode Etik Lembaga Legislatif UII', 'external_url' => 'https://drive.google.com/file/d/1ErXi8EEYnWHTf3MLLgAmK66x3gtngpkz/view'],

        // PKM 2019
        ['type' => 'pkm', 'number' => 1, 'year' => 2019, 'title' => 'Tentang Pedoman Pembentukan, Pembekuan dan Pembubaran Lembaga KM UII', 'external_url' => 'https://drive.google.com/file/d/1Hxk1t8ST9iqVtVuqqtq9gW6FKFR_S6eH/view'],
        ['type' => 'pkm', 'number' => 2, 'year' => 2019, 'title' => 'Tentang DPM U dan DPM F', 'external_url' => 'https://drive.google.com/file/d/17A2kWBkKRnS0Up-AOqTXJIHtFh_0L7I5/view'],
        ['type' => 'pkm', 'number' => 3, 'year' => 2019, 'title' => 'Tentang Pedoman Pelaksanaan Foraslak Lembaga Legislatif KM UII', 'external_url' => 'https://drive.google.com/file/d/1f1JHjVVp0Ia8MkHs1e52g5EAblsoHGkR/view'],
        ['type' => 'pkm', 'number' => 4, 'year' => 2019, 'title' => 'Tentang UKM KM UII', 'external_url' => 'https://drive.google.com/file/d/1COzbBfqkcoBMauJLuGf0BD4gDSnJZ3m9/view'],
        ['type' => 'pkm', 'number' => 5, 'year' => 2019, 'title' => 'Tentang UKMK KM UII', 'external_url' => 'https://drive.google.com/file/d/11sCmzEqZ5bhwaoh2eKW5IfWowdzosztr/view'],
        ['type' => 'pkm', 'number' => 6, 'year' => 2019, 'title' => 'Tentang LEM U dan LEM F KM UII', 'external_url' => 'https://drive.google.com/file/d/1wZ224awmU8_OcOwkCaYTmmS_5syfiU-5/view'],
        ['type' => 'pkm', 'number' => 7, 'year' => 2019, 'title' => 'Tentang Perubahan PKM No. 4 Tahun 2018 Tentang Produksi Jas Almamater', 'external_url' => 'https://drive.google.com/file/d/1l0oG41FSe0noUCZ8OolX7Izft3co_rd1/view', 'amends' => ['type' => 'pkm', 'number' => 3, 'year' => 2018]],
        ['type' => 'pkm', 'number' => 8, 'year' => 2019, 'title' => 'Tentang Distribusi dan Alokasi Dana KM UII', 'external_url' => 'https://drive.google.com/file/d/14WPycDOTYDDn3vax7QzQiDFEmMoGfQg2/view'],
        ['type' => 'pkm', 'number' => 9, 'year' => 2019, 'title' => 'Tentang Pengelolaan Aset KM UII', 'external_url' => 'https://drive.google.com/file/d/1LA1Z8UvPPSK_K5JFNHUFGB-jukMQwN_b/view'],
        ['type' => 'pkm', 'number' => 10, 'year' => 2019, 'title' => 'Tentang Pemilihan Umum Wakil Mahasiswa (Perubahan Atas PKM No. 2 Tahun 2018)', 'external_url' => 'https://drive.google.com/file/d/1ZV777We_uV9tuSHaCLOnBRgY996Yrehx/view', 'amends' => ['type' => 'pkm', 'number' => 1, 'year' => 2018]],

        // PKM 2022
        ['type' => 'pkm', 'number' => 1, 'year' => 2022, 'title' => 'Tentang Pemilihan Umum Wakil Mahasiswa (Perubahan Kedua Atas PKM No. 2 Tahun 2018)', 'external_url' => 'https://drive.google.com/file/d/1mKFsBpbSYge3vsnfygjgjqbCuEqDFMVX/view', 'amends' => ['type' => 'pkm', 'number' => 1, 'year' => 2018]],
        ['type' => 'pkm', 'number' => 2, 'year' => 2022, 'title' => 'Tentang Perubahan Ketiga Atas PKM UII Tentang Pemilihan Umum Wakil Mahasiswa', 'external_url' => 'https://drive.google.com/file/d/1VSPGL5GjgJczjy_FK4Dsw67t72BNT8S4/view', 'amends' => ['type' => 'pkm', 'number' => 1, 'year' => 2018]],

        // PKM 2023
        ['type' => 'pkm', 'number' => 1, 'year' => 2023, 'title' => 'Tentang Perubahan Atas Pedoman Administrasi KM UII', 'external_url' => 'https://drive.google.com/file/d/1cjdhiJ5JTUpff938rCWucXqUbaYfkKMF/view', 'amends' => ['type' => 'pkm', 'number' => 5, 'year' => 2018]],

        // PKM 2024
        ['type' => 'pkm', 'number' => 1, 'year' => 2024, 'title' => 'Tentang Pedoman Kegiatan Kepanitiaan KM UII', 'external_url' => 'https://drive.google.com/file/d/1pwT67391WrVwuGsH0QXmcE4fU7gL1_qw/view?usp=share_link'],
        ['type' => 'pkm', 'number' => 2, 'year' => 2024, 'title' => 'Tentang Distribusi dan Alokasi Dana KM UII', 'external_url' => 'https://drive.google.com/file/d/1IO0-w6G2L2oa4IPeav-Mv26hcZiWVcev/view?usp=share_link'],

        // PDPM
        ['type' => 'pdpm', 'number' => 1, 'year' => 2018, 'title' => 'Tentang Tata Tertib', 'external_url' => 'https://drive.google.com/file/d/1ylx-6MIlIxFMLByrg6dFEKAZn013K1gU/view'],
        ['type' => 'pdpm', 'number' => 1, 'year' => 2019, 'title' => 'Tentang Pedoman Pelaksanaan Tim Monitoring dan Advokasi Pesona Taaruf UII', 'external_url' => 'https://drive.google.com/file/d/15oFDAm42QOLJmhUg0VbVU9b7Cl2Okqq9/view'],
        ['type' => 'pdpm', 'number' => 1, 'year' => 2021, 'title' => 'Tentang Tata Tertib Dewan, Mandataris LEM dan Alat Kelengkapan', 'external_url' => 'https://drive.google.com/file/d/12QvThMlKldhLNP3qEhaNPEgTCjYV_uFP/view'],
        ['type' => 'pdpm', 'number' => 1, 'year' => 2022, 'title' => 'Tentang Perubahan Atas PDPM UII No. 1 Tahun 2021 Tentang Tata Tertib Dewan, Mandataris LEM dan Alat Kelengkapan', 'external_url' => 'https://drive.google.com/file/d/1NsxATYJNk6oFUKKobKWEeAv_-7eWprWh/view', 'amends' => ['type' => 'pdpm', 'number' => 1, 'year' => 2021]],
    ],

    'documents' => [
        [
            'category' => 'laporan-keuangan',
            'title' => 'Plafonase Triwulan I 2017/2018',
            'year' => 2017,
            'quarter' => 1,
            'external_url' => 'https://drive.google.com/file/d/1_Yv9QDjGRhwkpqq7qYTiDK8DLC0Ze2nJ/view',
        ],
        [
            'category' => 'laporan-keuangan',
            'title' => 'Plafonase Triwulan II 2017/2018',
            'year' => 2017,
            'quarter' => 2,
            'external_url' => 'https://drive.google.com/file/d/1_Yv9QDjGRhwkpqq7qYTiDK8DLC0Ze2nJ/view',
        ],
        [
            'category' => 'laporan-keuangan',
            'title' => 'Realisasi Distribusi Dana Taktis TW II 2017/2018',
            'year' => 2017,
            'quarter' => 2,
            'external_url' => 'https://drive.google.com/file/d/1KwEXDZun6lP4NQfQz8kxR92wp3hluIIb/view',
        ],
    ],

    'sejarah' => [
        'student_government' => 'Keluarga Mahasiswa Universitas Islam Indonesia (KM UII) secara resmi berdiri pada tanggal 21 September 1950. Ciri khas utama yang melekat pada KM UII adalah dikenalnya istilah “student government” sebagai dasar pelaksanaan sistem kelembagaan di KM UII. Secara umum, student government bermakna pemerintahan dari, untuk dan oleh mahasiswa. Dengan demikian maka pelaksanaan atau sistem kelembagaan di KM UII dilakukan oleh mahasiswa UII, dari mahasiswa UII untuk mahasiswa UII itu sendiri.',
        'km_uii' => 'Sekolah Tinggi Islam yang berdiri pada hari ahad tanggal 27 Rajab 1364 bertepatan dengan tanggal 8 Juli 1945 dan kini bernama Universitas Islam Indonesia, tidak terlepas dari kiprah mahasiswa untuk senantiasa memberikan peran positif yang maksimal untuk bangsanya. Hal ini terbukti dari sejak berdirinya STI, mahasiswa yang waktu itu hanya diterima 14 orang dari 78 pendaftar telah membulatkan tekadnya dalam membangun bangsa.',
    ],
];
