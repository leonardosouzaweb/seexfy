<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Seexfy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
</head>
<body>
    <div class="home">
        <div class="wrapper">
            <div class="top">
                <div class="logo">
                    <a href="home.php"><img src="assets/images/logo.svg" alt="Logo Seexyfy"></a>
                </div>

                <div class="navTop">
                    <div>
                        <img src="assets/images/icons/iconFilter.svg">
                    </div>
                    <div>
                        <img src="assets/images/icons/iconSearch.svg">
                    </div>
                    <div>
                        <div class="avatar"></div>
                    </div>
                </div>
            </div>

            <div class="content">
                <h1>Chat</h1>
                <?php 
                    //include_once 'includes/events.php'
                ?>
            </div>


            <div class="navMenu">
                <?php 
                    include_once 'includes/menu.php';
                ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/functions.js"></script>
</body>
</html>