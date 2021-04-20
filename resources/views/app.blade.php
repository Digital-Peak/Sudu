<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */
?>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="{{ config('app.url')}}/_manifest">
    <meta name="theme-color" content="#004576"/>
    <link rel="apple-touch-icon" href="{{ config('app.url')}}/public/icons/manifest/icon-152.png">
    <link rel="icon" href="{{ config('app.url') . '/public/favicon.ico' }}" type="image/x-icon"/>
    <title>{{ config('app.name') }}</title>
    <script>
		var CONFIG = {
			name: '{{config('app.name')}}',
			webBase: '{{!empty(parse_url(config('app.url'))['path']) ? parse_url(config('app.url'))['path'] : '/'}}',
			webImageFolder: '{{config('app.web_images_folder')}}',
			locale: '{{config('app.locale')}}',
			fallbackLocale: '{{config('app.fallback_locale')}}'
		};
		if ('serviceWorker' in navigator) {
			window.addEventListener('load', () => {
				navigator.serviceWorker.register('{{ config('app.url') . '/sw.js'}}')
					.then(reg => console.log('Registration succeeded. Scope is ' + reg.scope))
					.catch(registrationError => console.log('SW registration failed: ', registrationError));
			});
		}
    </script>
    <script src="{{ config('app.url') . '/js/manifest.js?v=' . config('app.version') }}" type="text/javascript" defer></script>
    <script src="{{ config('app.url') . '/js/vendor.js?v=' . config('app.version') }}" type="text/javascript" defer></script>
    <script src="{{ config('app.url') . '/js/app.js?v=' . config('app.version') }}" type="text/javascript" defer></script>
    <style type="text/css">{{ file_get_contents(config('app.root_folder') . '/public/css/app.css') }}</style>
</head>
<body>
<div class="dp-app"></div>
@include('icons')
</body>
</html>
