<?php
include_once '../api/db.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['age']) && isset($_POST['orientation']) && isset($_POST['sign']) && isset($_POST['height']) && isset($_POST['smokes']) && isset($_POST['drink']) && isset($_POST['experience']) && isset($_POST['description'])) {
        $age = $_POST['age'];
        $orientation = $_POST['orientation'];
        $sign = $_POST['sign'];
        $height = $_POST['height'];
        $smokes = $_POST['smokes'];
        $drink = $_POST['drink'];
        $experience = $_POST['experience'];
        $description = $_POST['description'];

        $user_id = $_SESSION['user_id'];

        var_dump($age, $orientation, $sign, $height, $smokes, $drink, $experience, $description, $user_id);

        $sql = "UPDATE users SET age=?, sexualOrientation=?, sign=?, height=?, smokes=?, drink=?, experience=?, description=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssi", $age, $orientation, $sign, $height, $smokes, $drink, $experience, $description, $user_id);
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
