<?php
$loggedUserId = $_SESSION['user_id'];

function calculateDistance($origin, $destination) {
    $apiKey = 'AIzaSyBdpWnU3SpD_Tk3wT2QF0Myo6U-TiUmQRg';
    $origin = urlencode($origin);
    $destination = urlencode($destination);
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=$origin&destinations=$destination&key=$apiKey";
    $data = json_decode(file_get_contents($url), true);

    if ($data['status'] == 'OK') {
        return $data['rows'][0]['elements'][0]['distance']['text'];
    } else {
        return false;
    }
}

$sqlLocation = "SELECT address FROM user_locations WHERE user_id = ?";
$stmtLocation = $conn->prepare($sqlLocation);
$stmtLocation->bind_param("i", $loggedUserId);
$stmtLocation->execute();
$resultLocation = $stmtLocation->get_result();
$userLocation = $resultLocation->fetch_assoc();
$stmtLocation->close();

if ($userLocation && isset($userLocation['address'])) {
    $userAddress = $userLocation['address'];

    $sql = "SELECT users.id, users.username, users.city, users.maritalStatus, users.avatar, user_locations.address AS user_address FROM users INNER JOIN user_locations ON users.id = user_locations.user_id WHERE users.id != ? AND user_locations.address IS NOT NULL";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $loggedUserId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<div class="scroll">';
        while ($row = $result->fetch_assoc()) {
            $distance = calculateDistance($userAddress, $row['user_address']);
            if ($distance !== false) {
                echo '<div class="user" data-id="' . $row["id"] . '">';
                echo '<img src="'. $base_url .'assets/uploads/users/' . $row["username"] . '/'. $row["avatar"] . '">';
                echo '<div class="info">';
                echo '<span>' . $row["username"] . '</span>';
                echo '<small>' . $distance . '</small>';
                echo '</div>';
                echo '<div class="mask"></div>';
                echo '</div>';
            } else {
                echo "<p>Não foi possível calcular a distância.</p>";
            }
        }
        echo '</div>';
        echo '<div class="space"></div>';
    } else {
        echo "<p>Nenhum usuário próximo a você</p>";
    }
} else {
    echo "<p>Você precisa ativar sua localização para ver outros usuários</p>";
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
