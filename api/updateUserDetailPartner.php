<?php
include_once '../api/db.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['agePartner']) && isset($_POST['sexualOrientationPartner']) && isset($_POST['signPartner']) && isset($_POST['heightPartner']) && isset($_POST['smokesPartner']) && isset($_POST['drinkPartner']) && isset($_POST['experiencePartner'])) {
        $agePartner = $_POST['agePartner'];
        $sexualOrientationPartner = $_POST['sexualOrientationPartner'];
        $signPartner = $_POST['signPartner'];
        $heightPartner = $_POST['heightPartner'];
        $smokesPartner = $_POST['smokesPartner'];
        $drinkPartner = $_POST['drinkPartner'];
        $experiencePartner = $_POST['experiencePartner'];

        $user_id = $_SESSION['user_id'];

        var_dump($agePartner, $sexualOrientationPartner, $signPartner, $heightPartner, $smokesPartner, $drinkPartner, $experiencePartner, $user_id);

        $sql = "UPDATE users SET agePartner=?, sexualOrientationPartner=?, signPartner=?, heightPartner=?, smokesPartner=?, drinkPartner=?, experiencePartner=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssi", $agePartner, $sexualOrientationPartner, $signPartner, $heightPartner, $smokesPartner, $drinkPartner, $experiencePartner, $user_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Dados atualizados com sucesso.";
        } else {
            echo "Erro ao atualizar os dados.";
        }
    } else {
        echo "Dados incompletos.";
    }
} else {
    echo "Método de solicitação inválido.";
}
?>
