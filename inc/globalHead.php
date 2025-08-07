<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = $_SERVER['HTTP_HOST'] ?? 'localhost';

if ($host == 'localhost') {
    $base_url = "http://localhost/seexfy";
} else {
    $base_url = "https://leonardosouza.com.br/seexfy";
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title>Seexfy | Rede de encontros e descobertas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

    <!-- Phosphor Icons -->
    <link
      rel="stylesheet"
      type="text/css"
      href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css"
    />
    <link
      rel="stylesheet"
      type="text/css"
      href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/fill/style.css"
    />

    <link rel="icon" type="image/png" href="<?php echo $base_url; ?>/images/favicon.png">

    <!-- STYLE -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/css/register.css">
</head>
<body>
