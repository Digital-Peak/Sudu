<?php
/**
 * @package   Sudu
 * @copyright Copyright (C) 2021 Digital Peak GmbH. <https://www.digital-peak.com>
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

$data                     = [];
$data['short_name']       = config('app.name');
$data['name']             = 'Fast image gallery';
$data['description']      = 'A slim and fast image gallery.';
$data['start_url']        = rtrim(config('app.url'), '/') . '/';
$data['display']          = 'standalone';
$data['orientation']      = 'portrait';
$data['theme_color']      = '#004576';
$data['background_color'] = '#004576';
$data['icons']            = [
	['src' => 'icons/manifest/icon.svg', 'sizes' => '144x144'],
	['src' => 'icons/manifest/icon-192.svg', 'sizes' => '192x192', 'type' => 'image/png'],
	['src' => 'icons/manifest/icon-512.svg', 'sizes' => '512x512', 'type' => 'image/png', 'purpose' => 'any maskable']
];

echo json_encode($data);
