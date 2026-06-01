<?php
include "db.php";
if (ob_get_level()) ob_end_clean();
header("Content-Type: application/xml; charset=utf-8");

$xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

// 1. PÁGINAS ESTÁTICAS (Ficheiros PHP da tua lista que são páginas reais)
$paginas = [
    'index.php',
    'about.php',
    'musics.php',
    'podcasts.php',
    'suggestions.php',
    'search.php',
    'privacy.php',
    'terms.php',
    'cookies.php',
    'register.php', // O Google pode indexar a página de registo
    'login.php'      // O Google pode indexar a página de login
];

foreach ($paginas as $pg) {
    $xml .= "  <url><loc>https://joaocostart.com/$pg</loc><priority>0.8</priority></url>" . PHP_EOL;
}

// 2. CONTEÚDO DINÂMICO (Os teus posts, músicas e podcasts individuais)
// Posts (Blog)
$res_posts = $conn->query("SELECT id FROM posts");
while($row = $res_posts->fetch_assoc()) {
    $xml .= "  <url><loc>https://joaocostart.com/post.php?id=".$row['id']."</loc><priority>0.7</priority></url>" . PHP_EOL;
}

// Músicas (Páginas individuais de música)
$res_music = $conn->query("SELECT id FROM musics"); 
if($res_music) {
    while($row = $res_music->fetch_assoc()) {
        $xml .= "  <url><loc>https://joaocostart.com/view_music.php?id=".$row['id']."</loc><priority>0.6</priority></url>" . PHP_EOL;
    }
}

// Podcasts (Páginas individuais de podcast)
$res_pod = $conn->query("SELECT id FROM podcasts");
if($res_pod) {
    while($row = $res_pod->fetch_assoc()) {
        $xml .= "  <url><loc>https://joaocostart.com/view_podcast.php?id=".$row['id']."</loc><priority>0.6</priority></url>" . PHP_EOL;
    }
}

$xml .= '</urlset>';
echo $xml;
exit;
?>