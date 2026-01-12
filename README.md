# Bio Keren Editor

Sistem editor drag & drop untuk membuat halaman bio link yang keren dan customizable.

## Fitur Utama

- **Drag & Drop Editor**: Susun ulang elemen dengan mudah
- **Modal Edit**: Edit setiap elemen dengan modal yang user-friendly
- **Real-time Preview**: Lihat perubahan secara real-time
- **Responsive Design**: Bekerja dengan baik di desktop dan mobile
- **JSON Storage**: Data tersimpan dalam format JSON yang terstruktur

## Struktur JSON

Sistem menyimpan data dalam format JSON dengan struktur berikut:

### 1. Profil Pengguna (`profil_pengguna`)
```json
{
  "profil_pengguna": {
    "username": "Nama Pengguna",
    "deskripsi": "Deskripsi singkat tentang pengguna",
    "foto_profil": "path/to/image.jpg",
    "updated_at": "2024-01-01T00:00:00.000Z"
  }
}
```

### 2. Grid Produk (`grid_produk`)
```json
{
  "grid_produk": [
    {
      "foto_produk": "path/to/product1.jpg",
      "link_produk": "https://example.com/product1",
      "harga": "Rp 100.000"
    },
    {
      "foto_produk": "path/to/product2.jpg",
      "link_produk": "https://example.com/product2",
      "harga": "Rp 150.000"
    }
  ]
}
```

### 3. Tombol Link (`tombol_link`)
```json
{
  "tombol_link": [
    {
      "nama_link": "YouTube",
      "link_tombol": "https://youtube.com/@username"
    },
    {
      "nama_link": "TikTok",
      "link_tombol": "https://tiktok.com/@username"
    }
  ]
}
```

### 4. YouTube Embed (`youtube_embeded`)
```json
{
  "youtube_embeded": {
    "header_youtube": "Video Tutorial Terbaru",
    "deskripsi_header": "Tonton video tutorial terbaru kami",
    "embeded_youtube": [
      "<iframe src='...'></iframe>",
      "<iframe src='...'></iframe>"
    ]
  }
}
```

### 5. Sosial Media (`sosial_media`)
```json
{
  "sosial_media": [
    {
      "platform": "YouTube",
      "link": "https://youtube.com/@username",
      "active": true
    },
    {
      "platform": "Instagram",
      "link": "https://instagram.com/@username",
      "active": true
    }
  ]
}
```

### 6. Portfolio Project (`portfolio_project`)
```json
{
  "portfolio_project": [
    {
      "gambar_project": "path/to/project1.jpg",
      "judul_project": "E-Commerce Platform",
      "deskripsi_project": "Website toko online dengan fitur lengkap",
      "link_project": "https://example.com/project1"
    }
  ]
}
```

### 7. Gambar Thumbnail (`gambar_thumbnail`)
```json
{
  "gambar_thumbnail": {
    "gambar_thumbnail": "path/to/thumbnail.jpg"
  }
}
```

### 8. Spotify Embed (`spotify_embed`)
```json
{
  "spotify_embed": {
    "embeded_spotify": [
      "<iframe src='...'></iframe>",
      "<iframe src='...'></iframe>"
    ]
  }
}
```

## Struktur Lengkap JSON

```json
{
  "order": [
    "profil_pengguna",
    "grid_produk",
    "tombol_link",
    "youtube_embeded",
    "sosial_media",
    "portfolio_project",
    "gambar_thumbnail",
    "spotify_embed"
  ],
  "hidden": [],
  "timestamp": "2024-01-01T00:00:00.000Z",
  "profil_pengguna": { ... },
  "grid_produk": [ ... ],
  "tombol_link": [ ... ],
  "youtube_embeded": { ... },
  "sosial_media": [ ... ],
  "portfolio_project": [ ... ],
  "gambar_thumbnail": { ... },
  "spotify_embed": { ... }
}
```

## API Endpoints

### Layout Management
- `POST /store-layout` - Simpan/update layout
- `GET /get-layout` - Ambil layout yang tersimpan

### Element Updates
- `POST /update-profile` - Update profil pengguna
- `POST /update-grid-produk` - Update grid produk
- `POST /update-tombol-link` - Update tombol link
- `POST /update-youtube-embed` - Update YouTube embed
- `POST /update-sosial-media` - Update sosial media
- `POST /update-portfolio-project` - Update portfolio project
- `POST /update-gambar-thumbnail` - Update gambar thumbnail
- `POST /update-spotify-embed` - Update Spotify embed

## Cara Penggunaan

### 1. Buka Editor
- Akses `/editor` setelah login
- Editor akan menampilkan sidebar dengan daftar elemen

### 2. Edit Elemen
- Klik tombol edit (ikon pensil) pada elemen yang ingin diedit
- Modal akan terbuka dengan form yang sesuai
- Isi data yang diperlukan
- Klik "Simpan" untuk menyimpan perubahan

### 3. Drag & Drop
- Gunakan handle drag (ikon grip) untuk memindahkan elemen
- Elemen akan otomatis tersusun ulang

### 4. Toggle Visibility
- Klik tombol mata untuk menyembunyikan/menampilkan elemen
- Elemen yang disembunyikan tidak akan muncul di preview

### 5. Simpan Layout
- Klik tombol "Simpan Layout" untuk menyimpan ke server
- Layout akan tersimpan dalam database

## File Upload

Sistem mendukung upload file untuk:
- Foto profil: `profiles/` folder
- Foto produk: `products/` folder  
- Gambar project: `portfolio/` folder
- Gambar thumbnail: `thumbnails/` folder

Format yang didukung: JPG, PNG, GIF
Ukuran maksimal: 2MB

## Database Schema

### Tabel `links`
```sql
CREATE TABLE links (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    data_link JSON NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

## Dependencies

- Laravel 10+
- PHP 8.1+
- MySQL 8.0+ (dengan JSON support)
- Tailwind CSS
- Font Awesome 6

## Installation

1. Clone repository
2. Install dependencies: `composer install`
3. Copy `.env.example` ke `.env`
4. Setup database
5. Run migrations: `php artisan migrate`
6. Run seeder: `php artisan db:seed`
7. Start server: `php artisan serve`

## Contributing

1. Fork repository
2. Create feature branch
3. Commit changes
4. Push to branch
5. Create Pull Request

## License

MIT License
