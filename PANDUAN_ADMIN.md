# Panduan Penggunaan Admin Panel BlogZekkTech

Dokumen ini akan membantu Anda mengelola konten blog melalui panel admin yang telah kami buat. Panel ini dirancang untuk memudahkan pengelolaan artikel tanpa perlu memahami kode PHP.

## Mengakses Panel Admin

1. Buka website blog Anda
2. Klik link "Admin" yang ada di menu navigasi atas
3. Panel admin akan terbuka dengan daftar semua postingan yang ada

## Mengelola Postingan Blog

### Melihat Semua Postingan

Halaman utama admin menampilkan semua postingan blog dengan informasi:

-   Judul dan ringkasan
-   Kategori
-   Status publikasi (dipublikasikan atau draft)
-   Tombol aksi (lihat, edit, hapus)

### Membuat Postingan Baru

1. Klik tombol "Create New Post" di halaman admin
2. Isi formulir dengan informasi berikut:

    - **Title**: Judul postingan Anda
    - **Category**: Pilih kategori dari dropdown
    - **Excerpt**: Ringkasan singkat yang akan muncul di halaman utama
    - **Body**: Konten utama postingan (mendukung format Markdown)
    - **Featured Image**: Unggah gambar utama (opsional)
    - **Publication Status**: Centang "Publish immediately" untuk langsung mempublikasikan

3. Klik tombol "Create Post" untuk menyimpan postingan

### Mengedit Postingan

1. Di halaman daftar postingan, klik ikon pensil (edit) pada postingan yang ingin diubah
2. Form edit akan muncul dengan data postingan yang sudah ada
3. Ubah informasi yang diperlukan
4. Klik "Update Post" untuk menyimpan perubahan

### Menghapus Postingan

1. Di halaman daftar postingan, klik ikon tempat sampah (delete)
2. Konfirmasi penghapusan saat dialog muncul

## Menggunakan Markdown

Blog ini mendukung format Markdown untuk memudahkan penulisan konten terstruktur. Panduan singkat:

### Format Dasar

```
# Heading 1
## Heading 2
### Heading 3

**Bold text**
*Italic text*

- Item 1
- Item 2
  - Sub-item

1. Numbered item 1
2. Numbered item 2

[Link text](https://example.com)

![Alt text for image](path/to/image.jpg)
```

### Kode dan Sintaks

````
`inline code`

```javascript
// Code block
function hello() {
  console.log('Hello');
}
````

### Kutipan

```
> This is a blockquote
> It can span multiple lines
```

## Struktur File Website

Jika Anda tertarik untuk memahami struktur file website:

-   `app/Http/Controllers/Admin/PostController.php`: Kode untuk mengelola postingan admin
-   `resources/views/admin/posts/`: Template untuk halaman admin
-   `resources/views/blog/`: Template untuk halaman publik blog
-   `routes/web.php`: Pengaturan URL website

## Bantuan

Jika Anda memiliki pertanyaan atau masalah dalam menggunakan admin panel ini, silakan hubungi pengembang melalui [zakariamujur6@gmail.com](mailto:zakariamujur6@gmail.com).
