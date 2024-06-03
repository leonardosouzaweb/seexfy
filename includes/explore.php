<?php
    // Inclui a coluna avatar na consulta SQL
    $sql = "SELECT username, city, maritalStatus, avatar FROM users";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<div class="scroll">';
        while ($row = $result->fetch_assoc()) {
            echo '<div data-bs-toggle="modal"';
            if ($row["maritalStatus"] == "Solteiro" || $row["maritalStatus"] == "Solteira") {
                echo ' data-bs-target="#single"';
            } elseif ($row["maritalStatus"] == "Casado" || $row["maritalStatus"] == "Casada") {
                echo ' data-bs-target="#couple"';
            }
            echo '>';
            // Usa o avatar do banco de dados
            echo '<img src="' . $row["avatar"] . '">';
            echo '<div class="info">';
            echo '<span>' . $row["username"] . '</span>';
            echo '<small>' . $row["city"] . '</small>';
            echo '</div>';
            echo '<div class="mask"></div>';
            echo '</div>';
        }
        echo '</div>';
        echo '<div class="space"></div>';
    } else {
        echo "Nenhum resultado encontrado.";
    }
?>
