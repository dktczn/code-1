<?php
// PHP built-in server router so pretty SEO URLs work locally without Apache/.htaccess.
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
if (str_starts_with($path, '/storage/private')) { http_response_code(403); exit('Forbidden'); }
$file = __DIR__ . $path;
if ($path !== '/' && is_file($file)) {
    return false;
}
$routes = [
    '#^/(gadgets|jersey|fashion|articles|docs|pages)/?$#' => function($m){ $_GET['type']=$m[1]; require __DIR__.'/archive.php'; },
    '#^/(gadgets|jersey|fashion|articles|docs|pages)/([^/]+)/?$#' => function($m){ $_GET['type']=$m[1]; $_GET['slug']=$m[2]; require __DIR__.'/content.php'; },
    '#^/product/([^/]+)/?$#' => function($m){ $_GET['slug']=$m[1]; require __DIR__.'/product.php'; },
    '#^/category/(gadgets|jersey|fashion)/([^/]+)/?$#' => function($m){ $_GET['niche']=$m[1]; $_GET['cat']=$m[2]; require __DIR__.'/category.php'; },
    '#^/contact/?$#' => fn()=>require __DIR__.'/contact.php',
    '#^/compare/?$#' => fn()=>require __DIR__.'/compare.php',
    '#^/sitemap\.xml$#' => fn()=>require __DIR__.'/sitemap.php',
];
foreach ($routes as $regex=>$handler) {
    if (preg_match($regex, $path, $m)) { $handler($m); return true; }
}
return false;
