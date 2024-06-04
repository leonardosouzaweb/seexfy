<?php
// LOCAL
// $servername = "localhost";  
// $username = "root";        
// $password = "root";            
// $dbname = "seexfy";

// PROD
$servername = "p3plzcpnl505377.prod.phx3.secureserver.net";
$username = "seexfy";
$password = "0A7B2LvP7mFx8Q4dDbo2Q9o";
$dbname = "seexfy";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
