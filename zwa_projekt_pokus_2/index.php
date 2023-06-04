<?php

session_start();
if(!isset($_SESSION["uzivatel"])){
    header("Location: prihlaseni.php");
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Horolog</title>
        <script defer src="app.js"></script>
        <link rel="stylesheet" href="index_styl.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    </head>
    <body>
            <nav>
                <h2 class="main_logo">Horolog</h2>
                <ul>
                    <li><a href="index.php">Domovská stránka</a></li>
                    <li><a href="galerie.php">Fotografie</a></li>
                    <li><a href="odhlaseni.php" class="btn btn-warning" id="odhlaseni">Odhlásit se</a></li>
                </ul>
            </nav>
            
            <div id="foto">
                <img src="images/foto_siroke.jpg" alt="české hory">
            </div>

            
            <section class="hidden right_sec">
                <div class="content">
                    <h1>K čemu je tato stránka</h1>
                    <div class="logo hidden"><p>Tato stránka vám dovoluje podělit se o svoje fotografie s dalšíma lidma.<br>Stačí se jen zaregistrovat, přihlásit a nahrát vaši fotografii, která tak bude zvěčněna na internetu.</p></div>
                </div>
            </section>
    </body>
</html>















