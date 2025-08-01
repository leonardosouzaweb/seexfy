<?php
session_start();

// Destroi a sessão
$_SESSION = [];
session_unset();
session_destroy();

// Redireciona para a página inicial
header("Location: ../");
exit;
