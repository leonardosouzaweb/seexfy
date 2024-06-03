<?php
// Detecta o hostname
$hostname = gethostname();

if ($hostname === 'localhost' || $hostname === 'seu-hostname-de-desenvolvimento') {
    // Configuração para ambiente de desenvolvimento
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "seexfy";
} else {
    // Configuração para ambiente de produção
    $servername = "p3plzcpnl505377.prod.phx3.secureserver.net";
    $username = "seexfy";
    $password = "0A7B2LvP7mFx8Q4dDbo2Q9o";
    $dbname = "seexfy";
}

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
