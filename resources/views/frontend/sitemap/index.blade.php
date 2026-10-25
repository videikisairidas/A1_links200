<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    {{-- Competition Sitemap Parts --}}
    @for($i = 1; $i <= $competitionParts; $i++)
    <sitemap>
        <loc>{{ url("/sitemap-competitions/{$i}.xml") }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </sitemap>
    @endfor
    {{-- IMAGES sitemap parts --}}
    @for($i = 1; $i <= $imageParts; $i++)
    <sitemap>
        <loc>{{ url("/sitemap-images/{$i}.xml") }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </sitemap>
    @endfor
    {{-- User Sitemap Parts --}}
    @for($i = 1; $i <= $userParts; $i++)
    <sitemap>
        <loc>{{ url("/sitemap-users/{$i}.xml") }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.7</priority>
    </sitemap>
    @endfor
    {{-- BlogPost Sitemap Parts --}}
    @for($i = 1; $i <= $blogParts; $i++)
    <sitemap>
        <loc>{{ url("/sitemap-blogs/{$i}.xml") }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.5</priority>
    </sitemap>
    @endfor
</sitemapindex>