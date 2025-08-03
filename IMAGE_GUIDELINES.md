# 📸 Panduan Ukuran Gambar BlogZekkTech

## 🎯 Ukuran Gambar Optimal untuk Upload

### **Featured Image (Gambar Utama Artikel)**

-   **Ukuran**: `1200 × 630 pixels`
-   **Aspect Ratio**: `1.91:1` (widescreen)
-   **Format**: JPG, PNG, atau WebP
-   **Kualitas**: 80-85%
-   **Ukuran File**: Maksimal 200KB

### **Thumbnail/Preview (Gambar di Home)**

-   Otomatis di-resize dari featured image
-   **Display Size Desktop**: 192px × 100px
-   **Display Size Mobile**: Full width × sesuai aspect ratio
-   **Aspect Ratio**: Tetap 1.91:1

## 📐 Ukuran Display di Website

### **1. Halaman Home (Blog Index)**

```css
Desktop: 192px width × 100px height (md:w-48 md:h-32)
Mobile:  Full width × auto height
Aspect:  1.91:1 (widescreen)
```

### **2. Halaman Artikel (Blog Show)**

```css
Width:     Full container width
Max Height: 400px
Aspect:    1.91:1 (widescreen)
```

### **3. Sidebar Related Posts**

```css
Size: 64px × 33px (w-16 h-16 equivalent)
Aspect: 1.91:1
```

## 🛠️ Tools Rekomendasi untuk Resize

### **Online Tools:**

1. **TinyPNG** - Kompres gambar tanpa kehilangan kualitas
2. **Canva** - Template 1200×630 tersedia
3. **Photopea** - Photoshop online gratis
4. **GIMP** - Software gratis

### **Photoshop Settings:**

```
Canvas Size: 1200px × 630px
Resolution: 72 DPI (untuk web)
Color Mode: sRGB
Quality: 80-85% (Save for Web)
```

## ✅ Checklist Sebelum Upload

-   [ ] Ukuran 1200×630 pixels
-   [ ] Aspect ratio 1.91:1
-   [ ] File size < 200KB
-   [ ] Format JPG/PNG/WebP
-   [ ] Nama file descriptive (tidak ada spasi)
-   [ ] Alt text yang sesuai

## 🎨 Tips Design

1. **Text Overlay**: Jika ada text, pastikan kontras yang baik
2. **Safe Area**: Hindari elemen penting di tepi gambar
3. **Mobile First**: Pastikan gambar terlihat bagus di mobile
4. **Loading Speed**: Kompres tanpa mengorbankan kualitas
5. **SEO**: Gunakan nama file yang deskriptif

## 📱 Responsive Behavior

Gambar akan otomatis:

-   Scale down di device kecil
-   Maintain aspect ratio 1.91:1
-   Lazy loading untuk performa
-   Hover effects di desktop

## 🚀 Performance Tips

1. **WebP Format**: Gunakan untuk ukuran file lebih kecil
2. **Lazy Loading**: Sudah diimplementasikan
3. **CDN**: Pertimbangkan untuk blog dengan traffic tinggi
4. **Image Optimization**: Compress sebelum upload

---

**Ukuran Optimal: 1200×630 pixels (1.91:1 aspect ratio)**
**File Size Target: < 200KB**
**Format Recommended: JPG 80-85% quality**
