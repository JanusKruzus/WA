<?php

session_start();
if(isset($_SESSION["uzivatel"])){
    header("Location: prihlaseni.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přihlášení</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="register_login.css">
</head>
<body>
    <div class="container">
        <?php
        if(isset($_POST["submit"])){

            $email = $_POST["email"];
            $heslo = $_POST["heslo"];

            require_once "databaze.php";
			$sql = "SELECT * FROM uzivatele WHERE email = '$email'";
			$vysledek = mysqli_query($spojeni, $sql);
			$uzivatel = mysqli_fetch_array($vysledek, MYSQLI_ASSOC);
            if($uzivatel){

                
                if(password_verify($heslo, $uzivatel["heslo"])){
                    //uživatel může být přihlášen
                    session_start();
                    $_SESSION["uzivatel"] = "ano";
                    header("Location: index.php");
                    die();
                }else{
                    echo "<div class='alert alert-danger'>Heslo se neshoduje</div>";
                }
            }else{
                    echo "<div class='alert alert-danger'>Email se neshoduje</div>";

            }
			


        }


        ?>
        <form action="prihlaseni.php" method="post">
        <h2 id="nadpis">Přihlášení</h2>

        <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Email:">
        </div>

        <div class="form-group">
            <input type="password" class="form-control" name="heslo" placeholder="Heslo:">
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="submit" value="Přihlásit se">
        </div>
        </form>
        <div id="odkaz"><p>Pokud se chceš zaregistrovat klikni <a id="link" href="registrace.php">SEM</a></p></div>
    </div>
</body>
</html>