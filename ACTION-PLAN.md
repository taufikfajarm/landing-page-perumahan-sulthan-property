# Action Plan: SEO Optimization Roadmap

- **Target:** `https://sulthanproperty.com/`
- **Goal:** Elevate overall SEO health from `68/100` to `90+/100`, fix critical DNS/Crawl blockers, enrich local schema, and enable AI search discovery.

---

## Phase 1: Immediate Critical Fixes (Day 1)
High-impact fixes to eliminate crawl errors, security warnings, and unreachable domains.

### 1. Fix `www` Subdomain DNS & 301 Redirect
- **Problem:** `www.sulthanproperty.com` fails DNS resolution.
- **Action:**
  1. Go to your DNS Manager (Cloudflare / cPanel Zone Editor).
  2. Add a `CNAME` record:
     - Name: `www`
     - Target: `sulthanproperty.com`
     - TTL: Auto
  3. Ensure web server redirects `www` to non-`www` in `.htaccess`:
     ```apache
     RewriteCond %{HTTP_HOST} ^www\.sulthanproperty\.com [NC]
     RewriteRule ^(.*)$ https://sulthanproperty.com/$1 [L,R=301]
     ```

### 2. Remove Broken Email Obfuscation Link (404)
- **Problem:** Link to `/cdn-cgi/l/email-protection` with anchor `[email protected]` returns 404.
- **Action:** In `resources/views/layouts/app.blade.php`, replace the broken Cloudflare-obfuscated email link with clean `mailto:` or link to contact form:
  ```blade
  {{-- Replace this --}}
  <a href="/cdn-cgi/l/email-protection">...</a>

  {{-- With this --}}
  <a href="mailto:info@sulthanproperty.com" class="hover:text-amber-500 transition">info@sulthanproperty.com</a>
  ```

### 3. Add Missing HTTP Security Headers
- **Problem:** Missing `X-Frame-Options`, `Referrer-Policy`, and `Permissions-Policy`.
- **Action:** In `public/.htaccess`, add the following directives inside `<IfModule mod_headers.c>`:
  ```apache
  <IfModule mod_headers.c>
      Header always set X-Frame-Options "SAMEORIGIN"
      Header always set X-Content-Type-Options "nosniff"
      Header always set Referrer-Policy "strict-origin-when-cross-origin"
      Header always set Permissions-Policy "camera=(), microphone=(), geolocation=()"
  </IfModule>
  ```

---

## Phase 2: Quick Wins & Schema Enrichment (Week 1)
High impact, minimal effort optimizations.

### 4. Enrich RealEstateAgent Schema in `resources/views/layouts/app.blade.php`
- **Problem:** Current schema has empty `sameAs: []` and lacks local business NAP.
- **Action:** Update the JSON-LD script in `resources/views/layouts/app.blade.php`:
  ```json
  <script type="application/ld+json">
  {
      "@context": "https://schema.org",
      "@type": "RealEstateAgent",
      "name": "Sulthan Property",
      "url": "https://sulthanproperty.com",
      "logo": "{{ asset('favicon.svg') }}",
      "image": "{{ asset('images/og-image.jpg') }}",
      "description": "Developer properti terpercaya di Jawa Tengah yang menyediakan perumahan subsidi dan komersil berkualitas dengan lokasi strategis dan harga terjangkau.",
      "telephone": "+6281234567890",
      "priceRange": "Rp 160.000.000 - Rp 500.000.000",
      "address": {
          "@type": "PostalAddress",
          "streetAddress": "Jl. Pangeran Diponegoro Pesantunan",
          "addressLocality": "Brebes",
          "addressRegion": "Jawa Tengah",
          "postalCode": "52212",
          "addressCountry": "ID"
      },
      "geo": {
          "@type": "GeoCoordinates",
          "latitude": -6.8694,
          "longitude": 109.0453
      },
      "openingHoursSpecification": [
          {
              "@type": "OpeningHoursSpecification",
              "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
              "opens": "08:00",
              "closes": "17:00"
          }
      ],
      "sameAs": [
          "https://www.instagram.com/sulthanproperty/",
          "https://www.tiktok.com/@sulthanproperty"
      ]
  }
  </script>
  ```

### 5. Deploy `public/llms.txt` for AI Search Engines (GEO)
- **Problem:** AI crawlers and LLM search agents lack structured summary of the company.
- **Action:** Create `public/llms.txt` with the following content:
  ```markdown
  # Sulthan Property
  
  > Pengembang properti perumahan subsidi dan komersil terpercaya di Brebes dan Tegal, Jawa Tengah.
  
  ## Informasi Utama
  - Nama Perusahaan: Sulthan Property
  - Website: https://sulthanproperty.com
  - Lokasi: Brebes & Tegal, Jawa Tengah, Indonesia
  - Layanan: Penjualan rumah subsidi, rumah komersil, konsultasi KPR bank syariah/konvensional, survey lokasi.
  
  ## Proyek Unggulan
  - Almaz de Mansion: https://sulthanproperty.com/perumahan/almaz-de-mansion
  - Pagejugan Land: https://sulthanproperty.com/perumahan/pagejugan-land
  - Grand Sulthan: https://sulthanproperty.com/perumahan/grand-sulthan
  - Sulthan Residence: https://sulthanproperty.com/perumahan/sulthan-residence
  
  ## Kontak
  - WhatsApp Marketing: https://sulthanproperty.com/marketing
  - Halaman Tentang: https://sulthanproperty.com/about
  ```

### 6. Explicitly Manage AI Search Crawlers in `public/robots.txt`
- **Action:** Add explicit permissions for search AI bots while maintaining scraper restrictions:
  ```robots.txt
  User-agent: PerplexityBot
  Allow: /

  User-agent: ChatGPT-User
  Allow: /
  ```

### 7. Optimize Meta Title & Meta Description Lengths
- **Current Title:** `Sulthan Property - Perumahan Berkualitas dengan Harga Terjangkau di Jawa Tengah` (78 chars — truncated on SERP)
  - **Proposed Title:** `Sulthan Property - Perumahan Murah & Subsidi di Brebes` (53 chars)
- **Current Description:** 173 characters (exceeds 160 char limit).
  - **Proposed Description:** `Developer perumahan terpercaya di Brebes & Tegal. Menyediakan rumah subsidi & komersil berkualitas, lokasi strategis, DP ringan, dan cicilan mudah.` (151 chars)

---

## Phase 3: Strategic Improvements & Performance (Week 2–3)

### 8. Add Explicit Image Dimensions to Prevent Layout Shifts (CLS)
- **Problem:** 4 housing card images in loop lack explicit `width` and `height`.
- **Action:** In `resources/views/housing/index.blade.php` and `resources/views/home.blade.php`, ensure every `<img>` tag specifies `width="400" height="250" loading="lazy"`.

### 9. Automatic WebP Image Conversion
- **Problem:** Hero images are 226KB JPEGs; total page image weight exceeds 1.5MB.
- **Action:** Configure Filament `FileUpload` or Spatie Media Library to automatically convert uploads to `.webp` with 80% quality, reducing image weight by ~60%.

### 10. Internal Linking & Orphan Page Remediation
- **Problem:** 7 housing type detail URLs (e.g. `/perumahan/almaz-de-mansion/3060-subsidi`) have ≤1 incoming link.
- **Action:**
  - Link directly to specific housing types from housing show cards.
  - Add contextual internal links within blog posts (e.g., in articles about "Tips Rumah Subsidi", add direct links to subsidized types).
  - Update generic anchor text like `"Lihat Detail"` to keyword-rich anchors: `"Lihat Tipe 30/60 Almaz de Mansion"`.

---

## Execution Checklist

- [ ] DNS: Add CNAME record for `www` and test redirect
- [ ] Code: Remove `/cdn-cgi/l/email-protection` link in `layouts/app.blade.php`
- [ ] Server: Insert security headers in `.htaccess`
- [ ] SEO: Update JSON-LD `RealEstateAgent` schema with `sameAs` & full address
- [ ] GEO: Create `public/llms.txt`
- [ ] Robots: Add `PerplexityBot` and `ChatGPT-User` to `robots.txt`
- [ ] On-Page: Tune Title (53 chars) and Meta Description (151 chars)
- [ ] CWV: Add missing `width` & `height` attributes to all card images
