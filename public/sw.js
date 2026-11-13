const CACHE_NAME = 'rude-hz-pwa-v1';
const STATIC_ASSETS = [
    '/',
    '/project',
    '/support',
    '/tracks',
    '/news',
    '/artists',
    '/playlists'
];

// Install event: cache static assets
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(STATIC_ASSETS.map(url => new Request(url, {cache: 'reload'}))).catch(err => {
                console.log('Static asset caching failed:', err);
            });
        })
    );
    self.skipWaiting();
});

// Activate event: clean up old caches
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (cacheName !== CACHE_NAME) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
    self.clients.claim();
});

// Fetch event: Network-first for HTML/dynamic, Cache-first for static assets, Exclude console, login, api
self.addEventListener('fetch', (event) => {
    const url = new URL(event.request.url);

    // Never cache API, console, login, or non-GET requests
    if (
        event.request.method !== 'GET' ||
        url.pathname.startsWith('/api') ||
        url.pathname.startsWith('/console') ||
        url.pathname.startsWith('/login') ||
        url.pathname.startsWith('/register') ||
        url.pathname.startsWith('/admin')
    ) {
        return;
    }

    // For static assets (css, js, images, build assets)
    if (
        url.pathname.startsWith('/build/') ||
        url.pathname.startsWith('/css/') ||
        url.pathname.startsWith('/js/') ||
        url.pathname.startsWith('/images/') ||
        url.pathname.endsWith('.css') ||
        url.pathname.endsWith('.js') ||
        url.pathname.endsWith('.png') ||
        url.pathname.endsWith('.jpg') ||
        url.pathname.endsWith('.ico')
    ) {
        event.respondWith(
            caches.match(event.request).then((cachedResponse) => {
                if (cachedResponse) {
                    return cachedResponse;
                }
                return fetch(event.request).then((networkResponse) => {
                    return caches.open(CACHE_NAME).then((cache) => {
                        cache.put(event.request, networkResponse.clone());
                        return networkResponse;
                    });
                });
            })
        );
        return;
    }

    // For HTML / Navigation requests: Network-first with offline fallback
    if (event.request.mode === 'navigate' || event.request.headers.get('accept').includes('text/html')) {
        event.respondWith(
            fetch(event.request)
                .then((networkResponse) => {
                    return caches.open(CACHE_NAME).then((cache) => {
                        cache.put(event.request, networkResponse.clone());
                        return networkResponse;
                    });
                })
                .catch(() => {
                    return caches.match(event.request).then((cachedResponse) => {
                        if (cachedResponse) {
                            return cachedResponse;
                        }
                        return new Response('Offline - Rude-Hz Community', {
                            status: 503,
                            headers: { 'Content-Type': 'text/html; charset=utf-8' }
                        });
                    });
                })
        );
    }
});
