<?php
$loggedUserId = $_SESSION['user_id'];

// Obter localização do usuário logado
$sqlLocationLoggedUser = "SELECT latitude, longitude FROM user_locations WHERE user_id = ? ORDER BY created_at DESC LIMIT 1";
$stmt = $conn->prepare($sqlLocationLoggedUser);
$stmt->bind_param("i", $loggedUserId);
$stmt->execute();
$resultLocationLoggedUser = $stmt->get_result();
$locationLoggedUser = $resultLocationLoggedUser->fetch_assoc();
$stmt->close();

if ($locationLoggedUser) {
    $latitudeLoggedUser = $locationLoggedUser['latitude'];
    $longitudeLoggedUser = $locationLoggedUser['longitude'];

    $sql = "SELECT u.id, u.username, u.city, u.maritalStatus, u.avatar, ul.latitude, ul.longitude
            FROM users u
            LEFT JOIN (
                SELECT user_id, latitude, longitude
                FROM user_locations
                WHERE created_at IN (
                    SELECT MAX(created_at)
                    FROM user_locations
                    GROUP BY user_id
                )
            ) ul ON u.id = ul.user_id
            WHERE u.id != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $loggedUserId);
    $stmt->execute();
    $result = $stmt->get_result();

    $users = [];

    while ($row = $result->fetch_assoc()) {
        $distance = "N/A";
        if ($row['latitude'] && $row['longitude']) {
            $distance = haversineGreatCircleDistance($latitudeLoggedUser, $longitudeLoggedUser, $row['latitude'], $row['longitude']);
            $distance = round($distance, 2) . ' km';
        }
        $row['distance'] = $distance;
        $users[] = $row;
    }
    $stmt->close();
    $conn->close();

    usort($users, function($a, $b) {
        return $a['distance'] <=> $b['distance'];
    });

    if (count($users) > 0) {
        echo '<div class="scroll">';
        foreach ($users as $user) {
            echo '<div class="user" data-id="' . $user["id"] . '">';
            echo '<img src="'. $base_url .'assets/uploads/' . $user["avatar"] . '">';
            echo '<div class="info">';
            echo '<span>' . $user["username"] . '</span>';
            echo '<small>' . $user["city"] . '</small>';
            echo '<small>Distância: ' . $user['distance'] . ' km</small>';
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
    echo "<p>Localização do usuário logado não disponível</p>";
}

function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371) {
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);

    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;

    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
      cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
    return $angle * $earthRadius;
}
?>

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
