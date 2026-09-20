const CACHE_NAME = 'seventy-five-hard-v1';
const PRECACHED_URLS = ['/icons/icon-192.png', '/icons/icon-512.png', '/manifest.json'];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => cache.addAll(PRECACHED_URLS))
            .then(() => self.skipWaiting())
    );
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys()
            .then((names) => Promise.all(
                names.filter((name) => name !== CACHE_NAME).map((name) => caches.delete(name))
            ))
            .then(() => self.clients.claim())
    );
});

function isCacheableAsset(request) {
    const url = new URL(request.url);

    return url.origin === self.location.origin
        && (url.pathname.startsWith('/build/') || url.pathname.startsWith('/icons/'));
}

self.addEventListener('fetch', (event) => {
    if (event.request.method !== 'GET' || !isCacheableAsset(event.request)) {
        return;
    }

    event.respondWith(
        caches.match(event.request).then((cached) => cached ?? fetch(event.request).then((response) => {
            const copy = response.clone();
            caches.open(CACHE_NAME).then((cache) => cache.put(event.request, copy));

            return response;
        }))
    );
});
