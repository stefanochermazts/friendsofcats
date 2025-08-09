<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml">
@foreach($urls as $u)
  <url>
    <loc>{{ $u['loc'] }}</loc>
    @isset($u['alternates'])
        @foreach($u['alternates'] as $alt)
            <xhtml:link rel="alternate" hreflang="{{ $alt['hreflang'] }}" href="{{ $alt['href'] }}" />
        @endforeach
    @endisset
    @isset($u['lastmod'])<lastmod>{{ $u['lastmod'] }}</lastmod>@endisset
    @isset($u['changefreq'])<changefreq>{{ $u['changefreq'] }}</changefreq>@endisset
    @isset($u['priority'])<priority>{{ $u['priority'] }}</priority>@endisset
  </url>
@endforeach
</urlset> 