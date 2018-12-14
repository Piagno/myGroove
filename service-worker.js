var CACHE = 'myGrooveCache';
self.addEventListener('install', function(evt) {
	evt.waitUntil(caches.open(CACHE).then(function (cache) {
    	return cache.addAll([
    	  './index.html',
    	  './'
    	])
  	}))
})
self.addEventListener('fetch', function(event) {
	console.log('The service worker is serving the asset.');
	event.respondWith(
		caches.match(event.request).then(function(response) {
			if (response) {
			  console.log('Found response in cache:', response);
				return response;
			}
			console.log('No response found in cache. About to fetch from network...');
			return fetch(event.request).then(function(response) {
			  console.log('Response from network is:', response);
			  return response;
			}).catch(function(error) {
			  console.error('Fetching failed:', error);
			  throw error;
			});
		})
	);
	event.waitUntil(
		caches.open(CACHE).then(function (cache) {
			cache.match(event.request).then(function(response) {
				if(response){
					fetch(event.request).then(function (response) {
						cache.put(event.request, response.clone()).then(function () {
							return true;
						});
    				});
				}
			})
		})
	)
})
