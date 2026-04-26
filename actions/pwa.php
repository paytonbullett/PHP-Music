<?php
// actions/pwa.php
// Note: This file is included from index.php, so it has access to the $pwa variable.

if ($pwa == 'manifest') {
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode([
    "name" => "PHP Music",
    "short_name" => "Music",
    "start_url" => "./",
    "display" => "standalone",
    "background_color" => "#030303",
    "theme_color" => "#121212",
    "description" => "A simple, fast music player with user accounts and uploads.",
    "icons" => [[
        "src" => "?action=get_app_icon&size=192",
        "sizes" => "192x192",
        "type" => "image/svg+xml",
        "purpose" => "any maskable"
      ],[
        "src" => "?action=get_app_icon&size=512",
        "sizes" => "512x512",
        "type" => "image/svg+xml",
        "purpose" => "any maskable"
      ]
    ]
  ]);
  exit;
}

if ($pwa == 'sw') {
  header('Content-Type: application/javascript; charset=utf-8');
  echo <<<SW
  const CACHE_NAME = 'php-music-cache-v22';
  const STATIC_ASSETS =[
    './',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css',
    'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js',
    'https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js',
    'https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap',
    'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/fonts/bootstrap-icons.woff2?v=1.11.3'
  ];

  self.addEventListener('install', event => {
    event.waitUntil(caches.open(CACHE_NAME).then(cache => cache.addAll(STATIC_ASSETS)));
  });

  self.addEventListener('activate', event => {
    const cacheWhitelist = [CACHE_NAME];
    event.waitUntil(
      caches.keys().then(cacheNames => {
        return Promise.all(
          cacheNames.map(cacheName => {
            if (cacheWhitelist.indexOf(cacheName) === -1) {
              return caches.delete(cacheName);
            }
          })
        );
      })
    );
  });

  self.addEventListener('fetch', event => {
    const url = new URL(event.request.url);
    const isApiCall = url.searchParams.has('action') || url.searchParams.has('share_type');
    const isPwaCall = url.searchParams.has('pwa');

    if (isApiCall || isPwaCall) {
      event.respondWith(fetch(event.request));
      return;
    }
    
    event.respondWith(
      caches.match(event.request).then(response => {
        return response || fetch(event.request).then(networkResponse => {
          if (networkResponse && networkResponse.ok) {
            const responseToCache = networkResponse.clone();
            caches.open(CACHE_NAME).then(cache => cache.put(event.request, responseToCache));
          }
          return networkResponse;
        });
      })
    );
  });
SW;
  exit;
}
