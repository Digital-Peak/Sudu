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
	<meta name="description" content="{{ config('app.name') }}">
	<meta name="theme-color" content="#004576"/>
	<link rel="manifest" href="{{ config('app.url')}}/_manifest">
	<link rel="apple-touch-icon" href="{{ config('app.url')}}/public/icons/manifest/icon-152.png">
	<link rel="icon" href="{{ config('app.url') . mix('/favicon.ico') }}" type="image/x-icon"/>
	<title>{{ config('app.name') }}</title>
	<link rel="preload" href="{{ config('app.url') . mix('/js/manifest.js') }}" as="script">
	<link rel="preload" href="{{ config('app.url') . mix('/js/vendor.js') }}" as="script">
	<link rel="preload" href="{{ config('app.url') . mix('/js/app.js') }}" as="script">
	<script>
		var CONFIG = {
			name: '{{ config('app.name') }}',
			webBase: '{{ !empty(parse_url(config('app.url'))['path']) ? parse_url(config('app.url'))['path'] : '/' }}',
			webImageFolder: '{{ config('app.web_images_folder') }}',
			locale: '{{ config('app.locale') }}',
			fallbackLocale: '{{ config('app.fallback_locale') }}'
		};
		if ('serviceWorker' in navigator) {
			window.addEventListener('load', () => navigator.serviceWorker.register('{{ config('app.url') . mix('/sw.js') }}'));
		}
	</script>
	<script src="{{ config('app.url') . mix('/js/manifest.js') }}" type="text/javascript" defer></script>
	<script src="{{ config('app.url') . mix('/js/vendor.js') }}" type="text/javascript" defer></script>
	<script src="{{ config('app.url') . mix('/js/app.js') }}" type="text/javascript" defer></script>
	<style type="text/css">{{ file_get_contents(config('app.root_folder') . '/public/css/app.css') }}</style>
</head>
<body>
<div class="dp-app"></div>
@include('icons')
</body>
</html>
