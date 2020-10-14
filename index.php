<?php
$av = isset($_GET['av']) ? $_GET['av'] : '';
$otype = isset($_GET['otype']) ? $_GET['otype'] : 'json';

if ($av == '') {
    include './public/welcome.html';
    exit;
}

// ! 测试用
if ($otype == 'dplayer') {
    include './public/dplayer.html';
    exit;
}

$p = isset($_GET['p']) ? $_GET['p'] : 1;
$q = isset($_GET['q']) ? $_GET['q'] : 32;

include 'src/Bilibili.php';

use Injahow\Bilibili;

$video = new Bilibili('video');

// 缓存 1h
$video->cache(true);
$video->cache_time(3600);

$video->aid($av);
$video->page(intval($p));
$video->quality(intval($q));

if ($otype == 'json') {
    header('Content-type: application/json; charset=utf-8;');
    // 允许跨站
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET');

    echo json_encode(json_decode($video->video())[0]);
} else if ($otype == 'url') {
    echo $video->url();
}
