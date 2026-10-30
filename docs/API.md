# API Publik DPM UII

Backend Laravel untuk situs DPM UII. Panel admin (Blade) tetap dipakai pengelola untuk
mengisi konten; **frontend terpisah** (React/Vue/Next, dll.) mengambil data lewat API di sini.

- **Base URL lokal**: `http://127.0.0.1:8000/api`
- **Produksi**: `https://<domain>/api`
- Semua endpoint **GET bersifat publik** (tanpa token). Hanya `POST /complaints` yang menulis data.
- Semua respons JSON, dibungkus `data`. Endpoint berpaginasi menambahkan `links` dan `meta`.
- Tanggal ISO-8601 (`2026-10-29T10:00:00+07:00`). URL berkas/gambar sudah absolut.
- Path aset upload: `/uploads/...` (bukan `/storage/...`) — tidak butuh symlink.

## CORS

Origin frontend diatur lewat `FRONTEND_URLS` (dipisah koma) di `.env`:

```
FRONTEND_URLS=http://localhost:3000,http://localhost:5173
```

Hanya path `api/*` yang dibuka. `supports_credentials` mati, jadi autentikasi berbasis cookie
tidak dipakai — API murni baca data publik.

## Ringkasan endpoint

| Method | Endpoint | Keterangan |
|---|---|---|
| GET | `/api/home` | Semua data beranda dalam satu request |
| GET | `/api/settings` | Identitas situs, hero, kontak, sosial, SEO, navigasi |
| GET | `/api/legal-products` | Daftar produk hukum (PDKM/GBHKM/PKM/PDPM) |
| GET | `/api/legal-products/types` | Metadata tiap jenis + jumlah |
| GET | `/api/legal-products/grouped?type=pkm` | Produk hukum dikelompokkan per tahun |
| GET | `/api/documents` | Arsip dokumen (SK, laporan, dll.) |
| GET | `/api/documents/categories` | Kategori dokumen + jumlah |
| GET | `/api/documents/reports` | Laporan keuangan per tahun → triwulan |
| GET | `/api/posts` | Berita/pengumuman terbit |
| GET | `/api/posts/categories` | Kategori berita + jumlah |
| GET | `/api/posts/{slug}` | Detail berita (termasuk `body` HTML) + 3 berita terkait |
| GET | `/api/units` | Badan/lembaga/komisi + fungsionaris aktif |
| GET | `/api/units/{slug}` | Detail satu unit |
| POST | `/api/complaints` | Kirim pengaduan (rate limit 5/menit) |
| GET | `/api/complaints/{ticket}` | Lacak status pengaduan (rate limit 30/menit) |

---

## GET /api/home

Payload siap pakai untuk landing page. Di-cache 1 menit di server.

```json
{
  "data": {
    "stats": { "legal_products": 28, "documents": 3, "units": 5, "posts": 3 },
    "legal_products": {
      "types": {
        "pdkm": { "key": "pdkm", "label": "PDKM", "name": "Peraturan Dasar Keluarga Mahasiswa",
                  "description": "...", "numbered": false, "total": 1,
                  "endpoint": "/api/legal-products?type=pdkm" },
        "gbhkm": { "...": "..." }, "pkm": { "...": "..." }, "pdpm": { "...": "..." }
      },
      "latest": [ /* 4 produk hukum bernomor terbaru, bentuk LegalProduct */ ]
    },
    "documents": {
      "categories": [ /* bentuk DocumentCategory */ ],
      "latest": [ /* 5 dokumen terbaru */ ]
    },
    "reports": [ { "year": 2025, "items": [ /* dokumen laporan keuangan */ ] } ],
    "posts": [ /* 3 berita terbaru */ ],
    "units": [ /* 6 unit tingkat atas beserta officials */ ]
  }
}
```

## GET /api/settings

```json
{
  "data": {
    "site": { "name": "DPM UII", "tagline": "...", "logo": null, "about": "..." },
    "hero": { "title": "...", "subtitle": "...", "image": "http://.../uploads/hero.jpg" },
    "contact": { "email": "dpm@uii.ac.id", "phone": "0812...", "address": "..." },
    "social": { "instagram": "https://...", "facebook": null, "youtube": null },
    "seo": { "meta_description": "..." },
    "footer_text": "...",
    "sections": [ { "key": "visi-misi", "title": "Visi Misi", "subtitle": "Informasi tentang DPM UII", "url": "/tentang/visi-misi" } ],
    "navigation": [ { "label": "Tentang", "url": "#", "children": [ { "label": "Visi Misi", "url": "/tentang/visi-misi" } ] } ]
  }
}
```

Nilai bisa `null` bila belum diisi di panel admin — FE wajib menangani itu.

## GET /api/legal-products

Query: `type` (`pdkm|gbhkm|pkm|pdpm`), `year`, `q` (cari judul), `per_page` (1–100, default 20).

Perilaku tiap jenis:

| type | numbered | Arti |
|---|---|---|
| `pdkm` | false | Konstitusi, satu dokumen, `number`/`year` selalu `null` |
| `gbhkm` | false | Arah kebijakan, satu dokumen, `number`/`year` selalu `null` |
| `pkm` | true | Peraturan bernomor + bertahun, bisa dirujuk sebagai "perubahan atas" |
| `pdpm` | true | Peraturan internal DPM, bernomor + bertahun |

Objek produk hukum:

```json
{
  "id": 29, "type": "pkm", "type_label": "PKM",
  "type_name": "Peraturan Keluarga Mahasiswa", "is_numbered": true,
  "number": 1, "year": 2018,
  "regulation_number": "PKM UII No. 1 Tahun 2018",
  "heading": "PKM UII No. 1 Tahun 2018",
  "title": "Tentang ...", "slug": "...", "description": "...",
  "is_amendment": false,
  "amends": { "id": 12, "heading": "PKM UII No. 4 Tahun 2018", "slug": "..." },
  "period": { "id": 1, "name": "2025/2026" },
  "file": { "url": "http://.../uploads/produk-hukum/2018/x.pdf", "extension": "PDF",
            "size": 102400, "human_size": "100 KB", "available": true },
  "download_url": "http://127.0.0.1:8000/produk-hukum/pkm-uii-no-1-tahun-2018/unduh",
  "downloads": 12,
  "published_at": "2026-10-29T10:00:00+07:00"
}
```

`amends` hanya muncul jika relasi dimuat (selalu dimuat di endpoint ini). `download_url`
adalah endpoint backend yang menambah penghitung unduhan lalu redirect ke berkas di server —
pakai tautan ini, bukan `file.url` langsung, bila ingin statistik tetap akurat.

Produk hukum **selalu berupa berkas unggahan** (tidak ada tautan luar). Bila admin belum
mengunggah berkas, `file.available` bernilai `false` dan `download_url` bernilai `null`.

Respons berpaginasi: `data[]`, `links`, `meta` (termasuk `meta.types`).

## GET /api/legal-products/grouped?type=pkm

`type` wajib; tanpa itu → 422. Cocok untuk halaman arsip dengan heading per tahun.

```json
{
  "data": {
    "type": "pkm",
    "meta": { "key": "pkm", "label": "PKM", "numbered": true, "total": 22, "...": "..." },
    "groups": [
      { "year": 2025, "total": 3, "items": [ /* produk hukum */ ] },
      { "year": 2018, "total": 6, "items": [ /* ... */ ] }
    ]
  }
}
```

## GET /api/documents

Query: `kategori` (slug), `tahun` (int), `triwulan` (1–4), `q`, `per_page` (default 15).

```json
{
  "data": [
    {
      "id": 3, "title": "Laporan Keuangan Triwulan II 2025", "slug": "...",
      "description": "...",
      "category": { "id": 3, "name": "Laporan Keuangan", "slug": "laporan-keuangan" },
      "year": 2025, "quarter": 2, "quarter_label": "Triwulan II",
      "file": { "url": "https://drive.google.com/...", "extension": "LINK",
                "size": null, "human_size": "-", "is_external": true },
      "download_url": "http://127.0.0.1:8000/dokumen/.../unduh",
      "downloads": 8, "published_at": "..."
    }
  ],
  "links": { "...": "..." },
  "meta": {
    "categories": [ { "id": 3, "name": "Laporan Keuangan", "slug": "laporan-keuangan",
                      "description": "...", "total": 4,
                      "endpoint": "/api/documents?kategori=laporan-keuangan" } ],
    "years": [2025, 2024],
    "quarters": { "1": "Triwulan I", "2": "Triwulan II", "3": "Triwulan III", "4": "Triwulan IV" }
  }
}
```

Dokumen bisa bertipe **berkas lokal** (`is_external: false`, extension PDF/DOCX/…) atau
**tautan luar** seperti Google Drive (`is_external: true`, `extension: "LINK"`).

## GET /api/documents/reports

Laporan keuangan (kategori `laporan-keuangan`) siap dirender sebagai tabel tahun × triwulan:

```json
{
  "data": [
    {
      "year": 2025,
      "quarters": [
        { "quarter": 1, "label": "Triwulan I", "documents": [] },
        { "quarter": 2, "label": "Triwulan II", "documents": [ /* dokumen */ ] },
        { "quarter": 3, "label": "Triwulan III", "documents": [] },
        { "quarter": 4, "label": "Triwulan IV", "documents": [] }
      ]
    }
  ]
}
```

`documents` bisa kosong — tampilkan status "belum tersedia".

## GET /api/posts dan /api/posts/{slug}

Query daftar: `kategori` (slug), `q`, `per_page` (default 9). Hanya berita berstatus
`published` dengan `published_at <= sekarang` yang muncul; draf → 404.

```json
{
  "data": [
    { "id": 1, "title": "...", "slug": "...", "excerpt": "...",
      "category": { "id": 1, "name": "Pengumuman", "slug": "pengumuman" },
      "featured_image": "http://.../uploads/berita/x.jpg",
      "published_at": "...", "url": "http://.../blog/slug",
      "meta_title": null, "meta_description": null }
  ],
  "links": {}, "meta": { "categories": [ { "id": 1, "name": "Pengumuman", "slug": "pengumuman", "total": 3, "endpoint": "/api/posts?kategori=pengumuman" } ] }
}
```

Detail menambahkan `data.body` (HTML dari editor Quill — render dengan `v-html`/`dangerouslySetInnerHTML`)
dan `related` (3 berita lain).

## Halaman statis (tentang)

Tidak ada endpoint halaman bebas. Enam seksi tetap disajikan sebagai halaman HTML:

| URL | Seksi |
|---|---|
| `/tentang/sambutan` | Sambutan |
| `/tentang/sejarah` | Sejarah KM UII |
| `/tentang/visi-misi` | Visi Misi |
| `/tentang/struktur` | Struktur |
| `/tentang/kedudukan-tugas-wewenang` | Kedudukan, Tugas dan Wewenang |
| `/tentang/profil-dewan` | Profil Dewan |

Daftar `key`, `title`, `subtitle`, dan `url` tersedia di `GET /api/settings` → `data.sections`.

## GET /api/units dan /api/units/{slug}

```json
{
  "data": [
    { "id": 1, "type": "badan", "name": "Badan Legislasi", "slug": "badan-legislasi",
      "description": "...", "logo": null, "sort_order": 1,
      "url": "http://.../unit/badan-legislasi",
      "officials": [
        { "id": 4, "name": "Nama", "position": "Ketua", "photo": "http://.../uploads/fungsionaris/x.jpg",
          "email": null, "instagram": "https://instagram.com/...", "linkedin": null, "sort_order": 1 }
      ] }
  ]
}
```

## POST /api/complaints

`Content-Type: application/json` untuk pengaduan tanpa lampiran, atau `multipart/form-data`
bila mengirim `attachment`.

| Field | Wajib | Aturan |
|---|---|---|
| `name` | ya, kecuali `is_anonymous=true` | maks 100 |
| `email` | ya | email valid, maks 150 |
| `phone` | tidak | maks 30 |
| `category` | tidak | maks 100 (mis. "Fasilitas", "Akademik") |
| `subject` | ya | maks 180 |
| `message` | ya | 20–5000 karakter |
| `is_anonymous` | tidak | boolean; bila true, `name` tidak disimpan |
| `attachment` | tidak | maks 5 MB; pdf, jpg, jpeg, png, doc, docx, xls, xlsx |

Contoh:

```bash
curl -X POST http://127.0.0.1:8000/api/complaints \
  -F "email=mahasiswa@uii.ac.id" -F "subject=Kursi rusak" \
  -F "message=Kursi ruang baca lantai dua banyak yang rusak." \
  -F "attachment=@bukti.pdf"
```

Respons `201`:

```json
{
  "data": {
    "ticket_number": "DPM-261029-A1B2",
    "status": "baru",
    "status_label": "Baru",
    "created_at": "2026-10-29T10:00:00+07:00",
    "status_endpoint": "/api/complaints/DPM-261029-A1B2"
  }
}
```

Validasi gagal → `422` dengan `errors` per field. Rate limit → `429`.

## GET /api/complaints/{ticket}

Nomor tiket tidak case-sensitive. Tidak membocorkan email/nama/telepon.

```json
{
  "data": {
    "ticket_number": "DPM-261029-A1B2",
    "subject": "Kursi rusak", "category": "Fasilitas",
    "status": "diproses", "status_label": "Diproses",
    "response": "Sudah diteruskan ke bagian sarana.",
    "created_at": "...", "responded_at": "..."
  }
}
```

Status: `baru`, `diproses`, `selesai`, `ditolak`. Tiket tidak dikenal → `404`.

---

## Catatan untuk frontend

- Jangan hardcode jumlah/daftar kategori — ambil dari `meta` atau `/api/*/categories`.
- Endpoint `/api/home` sudah menggabungkan semuanya; hindari memanggil 7 endpoint sekaligus
  saat pertama render.
- Semua URL berkas absolut, jadi aman dipakai dari origin frontend yang berbeda.
- Gambar di `public/uploads` boleh di-`<img src>` langsung; tidak ada signed URL.
- Konten `body` berasal dari editor Quill dan **sudah HTML**; jangan escape, render sebagai HTML.
- Bila butuh field tambahan (mis. pencarian global, agenda, galeri), tambahkan endpoint baru
  di `routes/api.php` — bukan mengubah bentuk respons yang sudah ada.

## Menjalankan backend

```bash
php artisan serve            # http://127.0.0.1:8000
php artisan test             # 37 tes
npm run dev                  # HMR untuk panel admin Blade
```

Database dev: PostgreSQL (Neon). Produksi: MySQL — cukup ganti blok `DB_*` di `.env`.
