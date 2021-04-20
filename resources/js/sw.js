/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

self.addEventListener('install', (e) => {
	e.waitUntil(
		caches.open('Sudu').then((cache) => {
			let webBase = self.location.pathname.split('/');
			webBase.pop();
			webBase = webBase.join('/');
			return cache.addAll([webBase + '/']);
		})
	);
});
self.addEventListener('fetch', (event) => {
	event.respondWith(
		caches.open('Sudu').then((cache) => {
			return fetch(event.request).then((response) => {
				cache.put(event.request, response.clone());
				return response;
			}).catch(() => {
				// Special response on api requests
				if (event.request.url.indexOf('/api/') > 0) {
					return new Response('', {status: 500, statusText: 'store.action.fetchFiles.offline'});
				}
				return cache.match(event.request).catch(() => new Response('', {status: 500, statusText: 'store.action.fetchFiles.offline'}));
			});
		})
	);
});
