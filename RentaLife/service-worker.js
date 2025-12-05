const CACHE_NAME = "rentalife-cache-v1";
const urlsToCache = [
    "index.php",
    "resultados.php",
    "css/index.css",
    "css/login.css",
    "css/resultados.css",
    "css/modal1.css",
    "source/logo.png",
    "source/FondoIndex.jpg"
];


self.addEventListener("install", event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => {
            return cache.addAll(urlsToCache);
        })
    );
});


self.addEventListener("activate", event => {
    event.waitUntil(
        caches.keys().then(keys =>
            Promise.all(
                keys.map(key => {
                    if (key !== CACHE_NAME) {
                        return caches.delete(key);
                    }
                })
            )
        )
    );
});


self.addEventListener("fetch", event => {
    event.respondWith(
        caches.match(event.request).then(response => {
            return response || fetch(event.request);
        })
    );
});