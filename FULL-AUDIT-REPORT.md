# Full SEO Audit Report: Sulthan Property

- **Target URL:** `https://sulthanproperty.com/`
- **Audit Date:** 2026-11-16
- **Audit Scope:** Full Single-URL & Technical Infrastructure Audit (Homepage, Crawlability, Technical, Schema, On-Page, Security, AI Readiness)
- **Overall Score:** `68/100` — **Needs Improvement**
- **Score Confidence:** `High` (Verified with direct HTTP fetch, DOM parsing, security header inspection, DNS resolution, and link crawler)
- **Interactive HTML Report:** `SEO-REPORT.html`

---

## 1. Audit Summary

Sulthan Property (`https://sulthanproperty.com/`) is a regional property developer website based in Brebes, Central Java, providing subsidized and commercial housing. The website possesses solid fundamentals: clean semantic HTML5, active HTTPS with HSTS, an XML sitemap registered in robots.txt, fast server TTFB (~200ms), and 100% of images having descriptive `alt` attributes.

However, several critical technical issues, missing security headers, DNS misconfigurations, and incomplete structured data hinder organic visibility, social sharing, and AI search indexing.

### Top 3 Critical Issues:
1. **Broken `www` Subdomain DNS Resolution:** `https://www.sulthanproperty.com/` fails to resolve (`getaddrinfo` DNS failure). Any user or backlink using the `www` prefix encounters an unreachable site error.
2. **Broken Internal Link (HTTP 404):** Cloudflare email protection link `https://sulthanproperty.com/cdn-cgi/l/email-protection` is hardcoded/crawled on every page, generating an internal 404 error.
3. **Incomplete Schema Entity & Empty `sameAs`:** While `@type: "RealEstateAgent"` exists, `sameAs: []` is empty (disconnecting social profiles) and physical address details (street, city, postal code, phone) are completely omitted.

### Top 3 Strategic Opportunities:
1. **Local SEO Domination (Brebes & Tegal):** Enrich Schema markup with `LocalBusiness` / `RealEstateAgent` complete NAP (Name, Address, Phone), `geo` coordinates, and target high-intent local keywords ("perumahan brebes", "rumah subsidi brebes").
2. **AI Search Readiness (GEO/AEO):** Deploy `/llms.txt` and explicit crawler directives for search assistants (PerplexityBot, ChatGPT-User) to be cited in AI search responses.
3. **Core Web Vitals & Image Modernization:** Supply missing width/height on 4 housing images to eliminate CLS and convert heavy JPEG/PNG images (e.g. 226KB hero images) to modern WebP/AVIF formats.

---

## 2. Category Scorecard

| Category | Weight | Score | Status | Key Factor |
|:---|:---:|:---:|:---:|:---|
| **Technical SEO & DNS** | 25% | 70/100 | Warning | www subdomain DNS resolution error, 1 broken link, missing security headers |
| **On-Page & Content Quality** | 20% | 85/100 | Good | Strong H1/H2 hierarchy, 607 words, meta tags present but slightly long |
| **Schema & Structured Data** | 15% | 60/100 | Warning | Valid RealEstateAgent type, but empty `sameAs: []` and missing NAP |
| **Performance & CWV** | 10% | 65/100 | Warning | Fast TTFB (216ms), but unoptimized JPEG sizes and 4 missing image dimensions |
| **Image Optimization** | 10% | 75/100 | Good | 100% images have alt text (37/37), but no WebP/AVIF and missing dimensions |
| **Internal Linking & Architecture** | 15% | 60/100 | Warning | Good navigation, but orphan housing types and generic anchor texts |
| **AI Search Readiness (GEO)** | 5% | 40/100 | Poor | No `/llms.txt`, unmanaged AI crawler rules in robots.txt |
| **Weighted Total** | **100%** | **68/100** | **Needs Improvement** | Action required on DNS, Schema, and Security headers |

---

## 3. Verified Findings Table

| Area | Severity | Confidence | Finding | Evidence | Fix |
|:---|:---:|:---:|:---|:---|:---|
| **DNS / Infrastructure** | **Critical** | Confirmed | `www.sulthanproperty.com` fails DNS lookup | `NameResolutionError: Failed to resolve 'www.sulthanproperty.com'` | Add CNAME record `www` pointing to `sulthanproperty.com` and 301 redirect to apex. |
| **Crawlability** | **Critical** | Confirmed | Broken internal link returning 404 | `[404] https://sulthanproperty.com/cdn-cgi/l/email-protection` (Anchor: `[email protected]`) | Replace Cloudflare mail protection token with real `mailto:` link or contact form route. |
| **Security Headers** | **Critical** | Confirmed | 4 essential security headers missing | Missing: `Content-Security-Policy`, `X-Frame-Options`, `Referrer-Policy`, `Permissions-Policy` | Add security headers via web server (Nginx/Apache) or Laravel middleware. |
| **Schema Markup** | **Critical** | Confirmed | `sameAs` array is empty and NAP address is incomplete | Schema output: `"sameAs": []`, `"address": {"addressCountry": "ID"}` | Populate `sameAs` with active social URLs and add complete street, city, region, and telephone. |
| **Internal Linking** | **Warning** | Confirmed | Housing type detail pages are potential orphan pages | 7 pages with ≤1 inbound link (e.g., `/perumahan/almaz-de-mansion/3060-subsidi`) | Link specific housing types directly from project catalog cards and blog recommendations. |
| **AI Search (GEO)** | **Warning** | Confirmed | No `llms.txt` or `llms-full.txt` found | `HTTP 404` on `/llms.txt` | Create `public/llms.txt` with company bio, core projects, and canonical URLs. |
| **Robots.txt** | **Warning** | Confirmed | Search AI user-agents not explicitly declared | `ChatGPT-User`, `PerplexityBot`, `FacebookBot` inherit wildcards | Explicitly allow search agent bots in `robots.txt` to ensure inclusion in AI search summaries. |
| **On-Page SEO** | **Warning** | Confirmed | Meta title is 78 characters (exceeds 60 char SERP cutoff) | `<title>`: `Sulthan Property - Perumahan Berkualitas dengan Harga Terjangkau di Jawa Tengah` | Shorten to 55–60 characters: `Sulthan Property - Perumahan Berkualitas di Brebes & Tegal`. |
| **On-Page SEO** | **Warning** | Confirmed | Meta description is 173 characters (exceeds 160 char cutoff) | Description: 173 characters | Trim to 150–155 characters for mobile SERP snippet integrity. |
| **Performance (CLS)** | **Warning** | Confirmed | 4 images lack explicit `width` and `height` attributes | 4 housing card images rendered without width/height attributes | Add explicit `width="400" height="250"` in Blade templates. |
| **Image Optimization**| **Warning** | Confirmed | All images served as uncompressed JPEG/PNG | Hero images: `Content-Type: image/jpeg`, size: 226KB | Enable WebP/AVIF generation in Filament uploaders; target <80KB per image. |
| **Open Graph** | **Info** | Confirmed | Missing explicit dimensions for `og:image` | `og:image` present, but `og:image:width` and `og:image:height` absent | Add `<meta property="og:image:width" content="1200">` and height 630. |

---

## 4. Deep Dive Analysis

### 4.1. Technical SEO & Infrastructure
- **Protocol & Canonical:** HTTP correctly redirects to HTTPS via 301 redirect in 82ms. Canonical tag is self-referential and matches `https://sulthanproperty.com`.
- **Subdomain Gap:** `www.sulthanproperty.com` has no DNS record in place. Visitors typing `www` get browser "Server Not Found" errors.
- **Sitemap & Robots:** `https://sulthanproperty.com/sitemap.xml` is present, returns HTTP 200, contains 6KB of well-structured XML URLs, and is referenced in `robots.txt`.
- **Security Headers:** Strict-Transport-Security (HSTS) is active with `max-age=31536000; includeSubDomains; preload` and `X-Content-Type-Options: nosniff`. However, missing `X-Frame-Options: SAMEORIGIN` and `Referrer-Policy: strict-origin-when-cross-origin` leaves the site vulnerable to iframe clickjacking and reduces referral tracking data.

### 4.2. On-Page & Semantic Architecture
- **Heading Structure:**
  - `H1`: 1 tag (`Wujudkan Impian Keluarga, Segera Miliki Hunian di Sulthan Property`). Good semantic usage.
  - `H2`: 7 tags logically segmenting sections (Proyek, Mengapa Pilih Kami, Survey Lokasi, Peta, Dokumentasi Akad, Artikel, E-Brosur).
  - `H3`: Sub-points and project titles.
- **Content Volume:** 607 words on homepage. Suitable for a conversion-focused landing page, but lacks structured FAQ accordion for PAA (People Also Ask) capture.
- **Keywords:** High relevance for "perumahan", but weak geographical concentration for localized terms like "perumahan subsidi Brebes", "rumah murah Jateng", and "developer Tegal".

### 4.3. Schema Markup & Knowledge Graph
- **Current State:**
  ```json
  {
    "@context": "https://schema.org",
    "@type": "RealEstateAgent",
    "name": "Sulthan Property",
    "url": "https://sulthanproperty.com",
    "logo": "https://sulthanproperty.com/favicon.svg",
    "description": "Developer properti yang menyediakan perumahan...",
    "address": {
      "@type": "PostalAddress",
      "addressCountry": "ID"
    },
    "sameAs": []
  }
  ```
- **Defects:**
  - `sameAs` array is empty despite having active Instagram (`@sulthanproperty`) and TikTok accounts.
  - `address` lacks street address, locality (`Brebes`), region (`Jawa Tengah`), and postal code.
  - Lacks `telephone`, `priceRange`, `areaServed`, and `geo` coordinates.

### 4.4. AI Search & Answer Engine Optimization (GEO & AEO)
- **AI Crawlers in robots.txt:** While scraping bots (ByteSpider, CCBot) are blocked, conversational search bots like `PerplexityBot` and `ChatGPT-User` should be explicitly allowed so AI engines can retrieve real-time housing availability.
- **llms.txt:** Absent. Providing `llms.txt` gives Large Language Models a curated, token-efficient summary of Sulthan Property's offerings.

---

## 5. Environment Limitations & Measurement Notes
- **PageSpeed Insights API:** The public PageSpeed API without an API key was rate-limited during the automated test cycle. Real-user TTFB measured via direct server ping was 216ms (excellent). Full field CWV data should be inspected directly in Google Search Console Core Web Vitals report.
