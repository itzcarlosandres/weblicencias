const CACHE_NAME = 'todokeys-cache-v2';
const urlsToCache = [
  '/',
  '/manifest.json',
  '/favicon.ico',
  '/build/assets/app.css', // O la ruta de Vite correcta
  '/build/assets/app.js'
];

// Instalar y guardar recursos en caché
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        return cache.addAll(urlsToCache).catch(err => console.log('Error caching static assets: ', err));
      })
  );
  self.skipWaiting();
});

// Activar y limpiar cachés antiguos
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
  self.clients.claim();
});

// Interceptar peticiones de red
self.addEventListener('fetch', event => {
  // Ignorar peticiones a la API o al panel de admin para evitar problemas de caché con datos dinámicos
  if (event.request.url.includes('/admin') || event.request.method !== 'GET') {
      return;
  }

  event.respondWith(
    caches.match(event.request)
      .then(response => {
        // Cache hit - return response
        if (response) {
          return response;
        }

        return fetch(event.request).then(
          function(response) {
            // Check if we received a valid response
            if(!response || response.status !== 200 || response.type !== 'basic') {
              return response;
            }

            // IMPORTANTE: Clonar la respuesta.
            // Una respuesta es un flujo (stream) y al guardarlo en caché se consume,
            // por lo tanto necesitamos clonarlo para devolver uno al navegador y otro a la caché.
            var responseToCache = response.clone();

            caches.open(CACHE_NAME)
              .then(function(cache) {
                // Solo guardamos en caché imágenes, CSS y JS. Evitamos HTML dinámico para no tener datos viejos.
                if (event.request.url.match(/\.(css|js|png|jpg|jpeg|gif|svg|woff2|woff)$/)) {
                    cache.put(event.request, responseToCache);
                }
              });

            return response;
          }
        );
      })
  );
});
