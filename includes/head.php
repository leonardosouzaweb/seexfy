<?php
    $base_url = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $base_url .= "://$_SERVER[HTTP_HOST]";
    $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
?>
<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="HandheldFriendly" content="true">
    <title>Seexfy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="icon" type="image/png" href="<?php echo $base_url; ?>assets/images/favicon.png">

    <link rel="manifest" href="<?php echo $base_url; ?>manifest.json">
    <meta name="theme-color" content="#ffffff">
    <meta name="description" content="Seexy">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Seexfy">
    <link rel="apple-touch-icon" href="<?php echo $base_url; ?>assets/images/favicon.png">
    <meta name="msapplication-TileImage" content="<?php echo $base_url; ?>assets/images/favicon.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
