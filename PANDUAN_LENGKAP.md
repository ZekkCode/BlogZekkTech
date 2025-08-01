# Panduan Lengkap BlogZekkTech

BlogZekkTech adalah aplikasi blog dengan tema gelap yang dibuat menggunakan Laravel. Panduan ini akan menjelaskan cara menggunakan semua fitur yang tersedia.

## Struktur Aplikasi

Blog ini terdiri dari dua bagian utama:

1. **Frontend Blog** - Halaman publik yang bisa diakses oleh pengunjung
2. **Admin Panel** - Area untuk mengelola konten blog

## Mengakses Blog

1. Untuk menjalankan server blog lokal:
    ```
    cd path/to/BlogZekkTech
    php artisan serve
    ```
2. Buka browser dan akses [http://127.0.0.1:8000](http://127.0.0.1:8000)

## Fitur Frontend Blog

### Halaman Beranda

-   Menampilkan daftar postingan terbaru
-   Menampilkan daftar kategori di sidebar
-   Pagination untuk menjelajahi lebih banyak postingan

### Halaman Detail Postingan

-   Menampilkan konten lengkap artikel
-   Format Markdown yang dirender menjadi HTML
-   Informasi penulis dan tanggal publikasi
-   Gambar utama jika tersedia

### Halaman Kategori

-   Menampilkan daftar postingan berdasarkan kategori tertentu
-   Navigasi untuk kembali ke halaman utama

## Fitur Admin Panel

### Mengelola Postingan

#### Melihat Semua Postingan

1. Klik "Admin" di menu navigasi
2. Anda akan melihat daftar semua postingan
3. Informasi yang ditampilkan:
    - Judul dan ringkasan
    - Kategori
    - Status publikasi
    - Tombol aksi (lihat, edit, hapus)

#### Membuat Postingan Baru

1. Di halaman admin, klik "Create New Post"
2. Isi formulir dengan informasi berikut:

    - **Title**: Judul postingan
    - **Category**: Pilih kategori yang sesuai
    - **Excerpt**: Ringkasan singkat (akan muncul di halaman beranda)
    - **Body**: Konten lengkap dalam format Markdown
    - **Featured Image**: Upload gambar utama (opsional)
    - **Publication Status**: Centang untuk langsung mempublikasikan

3. Klik "Create Post" untuk menyimpan

#### Mengedit Postingan

1. Di daftar postingan, klik ikon edit pada postingan yang ingin diubah
2. Update informasi yang diperlukan
3. Klik "Update Post" untuk menyimpan perubahan

#### Menghapus Postingan

1. Di daftar postingan, klik ikon hapus
2. Konfirmasi penghapusan saat dialog muncul

### Mengelola Kategori

#### Melihat Semua Kategori

1. Di admin panel, klik "Categories" pada menu navigasi
2. Anda akan melihat daftar semua kategori beserta jumlah postingan yang terkait

#### Membuat Kategori Baru

1. Di halaman kategori, klik "Create New Category"
2. Masukkan nama kategori
3. Klik "Create Category" untuk menyimpan

#### Mengedit Kategori

1. Di daftar kategori, klik ikon edit pada kategori yang ingin diubah
2. Update nama kategori
3. Klik "Update Category" untuk menyimpan perubahan

#### Menghapus Kategori

1. Di daftar kategori, klik ikon hapus
2. Perhatikan bahwa Anda tidak dapat menghapus kategori yang memiliki postingan terkait

## Menggunakan Format Markdown

Blog ini mendukung format Markdown untuk menulis konten. Markdown adalah format penulisan sederhana yang memungkinkan Anda untuk menulis teks terformat tanpa perlu menggunakan HTML.

### Heading

```markdown
# Heading 1

## Heading 2

### Heading 3
```

### Teks Format

```markdown
**Bold text**
_Italic text_
~~Strikethrough~~
```

### Daftar

```markdown
-   Item 1
-   Item 2
    -   Subitem

1. Numbered item 1
2. Numbered item 2
```

### Link dan Gambar

```markdown
[Link text](https://example.com)

![Alt text for image](/path/to/image.jpg)
```

### Kode

````markdown
`inline code`

```javascript
// code block
function hello() {
    console.log("Hello");
}
```
````

````

### Kutipan

```markdown
> This is a blockquote
> It can span multiple lines
````

## Tips & Trik

1. **Gambar Optimal** - Gunakan gambar dengan rasio aspek 16:9 untuk tampilan terbaik di halaman beranda
2. **Ringkasan** - Tulis ringkasan yang menarik dalam 2-3 kalimat untuk mendorong pembaca mengklik artikel
3. **Preview** - Selalu periksa tampilan artikel di frontend setelah mempublikasikan
4. **Kategori** - Gunakan kategori yang konsisten untuk memudahkan navigasi

## Troubleshooting

Jika Anda mengalami masalah:

1. **Server Error** - Periksa file `storage/logs/laravel.log` untuk detail error
2. **Gambar Tidak Muncul** - Pastikan Anda telah menjalankan `php artisan storage:link`
3. **Format Markdown Tidak Bekerja** - Periksa apakah sintaks Markdown Anda sudah benar
4. **Pagination Error** - Pastikan konfigurasi database Anda sudah benar

## Penutup

Selamat menggunakan BlogZekkTech! Jika ada pertanyaan atau masalah, silakan hubungi pengembang melalui [zakariamujur6@gmail.com](mailto:zakariamujur6@gmail.com).
