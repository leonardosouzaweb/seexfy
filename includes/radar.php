<?php
$loggedUserId = $_SESSION['user_id'];

// Obter a latitude e longitude do usuário logado
$sqlLocation = "SELECT latitude, longitude FROM user_locations WHERE user_id = ?";
$stmtLocation = $conn->prepare($sqlLocation);
$stmtLocation->bind_param("i", $loggedUserId);
$stmtLocation->execute();
$resultLocation = $stmtLocation->get_result();
$userLocation = $resultLocation->fetch_assoc();
$stmtLocation->close();

// Verificar se o usuário possui localização registrada
if ($userLocation && isset($userLocation['latitude'], $userLocation['longitude'])) {
    $userLatitude = $userLocation['latitude'];
    $userLongitude = $userLocation['longitude'];

    $sql = "SELECT id, username, city, maritalStatus, avatar FROM users WHERE id != ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $loggedUserId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<div class="scroll">';
        while ($row = $result->fetch_assoc()) {
            // Calcular a distância entre os usuários
            $distance = calculateDistance($userLatitude, $userLongitude, $row['latitude'], $row['longitude']);
            echo '<div class="user" data-id="' . $row["id"] . '">';
            echo '<img src="'. $base_url .'assets/uploads/users/' . $row["username"] . '/'. $row["avatar"] . '">';
            echo '<div class="info">';
            echo '<span>' . $row["username"] . '</span>';
            echo '<small>' . number_format($distance, 1) . ' KM</small>';
            echo '</div>';
            echo '<div class="mask"></div>';
            echo '</div>';
        }
        echo '</div>';
        echo '<div class="space"></div>';
    } else {
        echo "<p>Nenhum usuário encontrado</p>";
    }
} else {
    echo "<p>Você precisa ativar sua localização para ver outros usuários</p>";
}

function calculateDistance($lat1, $lon1, $lat2, $lon2) {
    $earth_radius = 6371; // Raio da Terra em quilômetros
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    $distance = $earth_radius * $c; // Distância em quilômetros
    return $distance;
}
?>
<div id="customModal" class="modal">
    <div class="modal-dialog modal-dialog-centered">
        <div id="modal-content" class="modal-content"></div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $('.user').click(function(){
        var userId = $(this).data('id');
        $.ajax({
            url: 'api/getUserDetail.php',
            method: 'post',
            data: {id: userId},
            success: function(response){
                $('#modal-content').html(response);
                $('#customModal').show();
            }
        });
    });

    $('.close').click(function(){
        $('#customModal').hide();
    });
});
</script>
