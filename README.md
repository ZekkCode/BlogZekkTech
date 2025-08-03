# BlogZekkTech - Platform Berbagi Ilmu Teknologi Gratis

BlogZekkTech adalah platform blog yang dibuat untuk berbagi pengetahuan teknologi secara gratis tanpa dipungut biaya. Blog ini menyediakan artikel-artikel seputar teknologi, tips & trik, serta perkembangan terkini di dunia digital untuk membantu semua orang belajar dan berkembang bersama.

## 🎯 Misi & Visi

**Misi**: Menyediakan akses gratis terhadap pengetahuan teknologi berkualitas untuk semua kalangan

**Visi**: Membangun komunitas pembelajar yang saling berbagi ilmu dan berkembang bersama di era digital

## � Topik Artikel

-   💻 **Teknologi Terkini**: Update dan review teknologi terbaru
-   🛠️ **Tips & Trik**: Panduan praktis untuk developer dan tech enthusiast
-   📱 **Mobile Development**: Tutorial dan best practices
-   🌐 **Web Development**: Frontend, backend, dan full-stack development
-   🔒 **Cybersecurity**: Keamanan digital dan privacy
-   🤖 **AI & Machine Learning**: Perkembangan dan implementasi AI
-   ☁️ **Cloud Computing**: Layanan cloud dan deployment

## ✨ Fitur

### Frontend

-   🎨 **Multi-Theme Support**: Light, Dark, dan Warm theme untuk kenyamanan membaca
-   📱 **Responsive Design**: Optimized untuk desktop dan mobile
-   🔍 **Real-time Search**: Pencarian artikel dengan AJAX
-   🎯 **Clean UI**: Desain minimalist untuk fokus pada konten
-   📖 **Markdown Support**: Dukungan penuh untuk format Markdown
-   🏷️ **Category System**: Sistem kategorisasi artikel berdasarkan topik
-   📊 **SEO Friendly**: Optimized untuk search engine

### Admin Panel

-   👨‍💼 **User Management**: Sistem admin dan user management
-   ✍️ **Content Management**: CRUD lengkap untuk artikel dan kategori
-   🖼️ **Image Upload**: Upload dan manajemen gambar
-   📋 **Dashboard Analytics**: Overview konten dan statistik
-   🔐 **Secure Authentication**: Sistem login yang aman

## 🛠️ Tech Stack

-   **Framework**: Laravel 12.x
-   **Frontend**: Blade Templates + TailwindCSS
-   **Database**: SQLite (default) / MySQL
-   **Icons**: Lucide Icons (SVG)
-   **Styling**: Custom CSS Variables + Tailwind
-   **Build Tools**: Vite

## 📋 Requirements

-   PHP 8.2+
-   Composer
-   Node.js & NPM
-   SQLite/MySQL

## 🚀 Installation

### 1. Clone Repository

```bash
git clone https://github.com/ZekkCode/BlogZekkTech.git
cd BlogZekkTech
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup

```bash
# Run migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed
```

### 5. Build Assets

```bash
# For development
npm run dev

# For production
npm run build
```

### 6. Start Development Server

```bash
php artisan serve
```

Akses aplikasi di: `http://127.0.0.1:8000`

## 👨‍💼 Admin Access

Setelah menjalankan seeder, gunakan kredential berikut:

-   **URL**: `/admin/login`
-   **Email**: `admin@blogzekktech.com`
-   **Password**: `password`

## 📁 Project Structure

```
BlogZekkTech/
├── app/
│   ├── Http/Controllers/     # Controllers
│   ├── Models/              # Eloquent Models
│   └── Helpers/             # Helper Classes
├── database/
│   ├── migrations/          # Database Migrations
│   └── seeders/            # Database Seeders
├── resources/
│   ├── views/              # Blade Templates
│   ├── css/                # Stylesheets
│   └── js/                 # JavaScript Files
├── public/
│   └── images/             # Static Images
└── routes/
    └── web.php             # Web Routes
```

## 🎨 Theme System

BlogZekkTech menggunakan sistem tema dengan CSS custom properties:

### Available Themes

-   **Light**: Clean white background dengan blue accent
-   **Dark**: Dark background dengan blue accent
-   **Warm**: Warm sepia-toned theme

### Theme Implementation

Tema diatur menggunakan CSS custom properties di `app.blade.php`:

```css
:root {
    /* Light theme variables */
}
.dark {
    /* Dark theme variables */
}
.warm {
    /* Warm theme variables */
}
```

## 🔧 Configuration

### Database Configuration

Edit file `.env` untuk konfigurasi database:

```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite
```

### App Configuration

```env
APP_NAME="BlogZekkTech"
APP_URL=http://localhost:8000
```

## 📖 Usage Guide

Untuk panduan lengkap penggunaan, lihat:

-   [PANDUAN_LENGKAP.md](PANDUAN_LENGKAP.md) - Panduan pengguna lengkap
-   [PANDUAN_ADMIN.md](PANDUAN_ADMIN.md) - Panduan admin panel

## 🤝 Contributing

1. Fork repository ini
2. Buat branch baru (`git checkout -b feature/amazing-feature`)
3. Commit perubahan (`git commit -m 'Add amazing feature'`)
4. Push ke branch (`git push origin feature/amazing-feature`)
5. Buat Pull Request

## 📝 License

Project ini menggunakan [MIT License](LICENSE).

## 👨‍💻 Author

**Zakaria Mujur**

-   GitHub: [@ZekkCode](https://github.com/ZekkCode)
-   Instagram: [@zekksparow](https://instagram.com/zekksparow)
-   Email: zakariamujur6@gmail.com

## 🙏 Acknowledgments

-   Icons dari [Lucide Icons](https://lucide.dev)
-   Framework [Laravel](https://laravel.com)
-   Styling dengan [TailwindCSS](https://tailwindcss.com)

---

⭐ Jika project ini membantu dan bermanfaat untuk pembelajaran, jangan lupa untuk memberikan star!

<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>{{ config('app.name') }} - @yield('title')</title>
</head>
<body class="bg-[#12141c] text-gray-100">
<header>
<!-- Navigation -->
</header>

        <main>@yield('content')</main>

        <footer>
            <!-- Footer content -->
        </footer>
    </body>

</html>
```

### Halaman Blog

File: `resources/views/blog/index.blade.php`

Menampilkan daftar postingan dengan grid:

```html
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($posts as $post)
    <div class="bg-gray-900 rounded-lg overflow-hidden">
        <img
            src="{{ asset('storage/' . $post->image) }}"
            alt="{{ $post->title }}"
        />
        <div class="p-5">
            <h2 class="text-xl font-bold">{{ $post->title }}</h2>
            <p class="text-gray-400">{{ $post->excerpt }}</p>
            <a
                href="{{ route('blog.show', $post->slug) }}"
                class="text-blue-400"
                >Read more</a
            >
        </div>
    </div>
    @endforeach
</div>
```

## Persyaratan Teknis

-   PHP 8.2+
-   Laravel 12+
-   MySQL/MariaDB
-   Composer
-   Node.js dan NPM

## Instalasi

1. Clone repositori:

    ```
    git clone https://github.com/username/BlogZekkTech.git
    cd BlogZekkTech
    ```

2. Install dependensi:

    ```
    composer install
    npm install
    ```

3. Konfigurasi lingkungan:

    ```
    cp .env.example .env
    php artisan key:generate
    ```

4. Konfigurasi database di file `.env`

5. Jalankan migrasi dan seeder:

    ```
    php artisan migrate --seed
    ```

6. Link storage:

    ```
    php artisan storage:link
    ```

7. Compile asset:

    ```
    npm run dev
    ```

8. Jalankan server:
    ```
    php artisan serve
    ```

## Teknologi

-   [Laravel](https://laravel.com)
-   [Tailwind CSS](https://tailwindcss.com)
-   [Alpine.js](https://alpinejs.dev)
-   [CommonMark for Markdown](https://github.com/graham-campbell/laravel-markdown)
