<?php
    include_once 'includes/head.php';
    session_start(); 

    if (!isset($_SESSION['user_id'])) {
        header("Location: ./entrar");
        exit(); 
    }

    include_once 'config/db.php';

    $user_id = $_SESSION['user_id'];
    $sqlUser = "SELECT maritalStatus, username, avatar FROM users WHERE id = ?";
    $stmt = $conn->prepare($sqlUser);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    $stmt->close();
    $conn->close();
?>

<body>
    <div class="empty">
        <img src="<?php echo $base_url; ?>assets/images/logo.svg">
    </div>
    <?php include_once 'includes/topMenu.php'; ?>
    <div class="home">
        <div class="wrapper">
            <div class="content">
                <h1>Pesquisar</h1>
                <input type="text" id="searchInput" class="form-control" placeholder="Buscar perfil...">
                <div id="searchResults"></div>
            </div>
        </div>
    </div>
    <?php include_once 'includes/bottomMenu.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $base_url; ?>assets/js/functions.js"></script>
    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            const query = this.value;
            const base_url = "<?php echo $base_url; ?>";

            if (query.length > 2) {
                fetch(`api/searchUser.php?query=${query}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        const resultsContainer = document.getElementById('searchResults');
                        resultsContainer.innerHTML = '';

                        if (data.error) {
                            console.error('Error:', data.error);
                            resultsContainer.innerHTML = `
                                <div class="emptySearch">
                                    <img src="${base_url}assets/images/icons/iconEmpty.svg">
                                    <h3>Oops!</h3>
                                    <p>${data.error}</p>
                                </div>
                            `;
                        } else if (data.length > 0) {
                            data.forEach(user => {
                                const userElement = document.createElement('div');
                                userElement.classList.add('listUser');
                                userElement.innerHTML = `
                                    <div>
                                        <div class="listAvatar">
                                            <img src="${base_url}assets/uploads/${user.avatar}" alt="${user.username}">
                                        </div>
                                        <div class="listInfo">
                                            <span>${user.username} <small>${user.age ? user.age + ' anos, ' : ''}${user.maritalStatus}</small></span>
                                        </div>
                                    </div>
                                    <a href="./perfil/${user.username}"><img src="${base_url}assets/images/icons/iconNavProfile.svg" class="navGoUser"></a>
                                `;
                                resultsContainer.appendChild(userElement);
                            });
                        } else {
                            resultsContainer.innerHTML = `
                                <div class="emptySearch">
                                    <img src="${base_url}assets/images/icons/iconEmpty.svg">
                                    <h3>Oops!</h3>
                                    <p>Nenhum resultado encontrado.</p>
                                </div>
                            `;
                        }
                    })
                    .catch(error => console.error('Erro:', error));
            } else if (query.length === 0) {
                document.getElementById('searchResults').innerHTML = '';
            }
        });
        </script>
</body>
</html>