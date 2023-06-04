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
    <title>Registrace</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="register_login.css">
</head>
<body>
    <div class="container">
	<?php

		if(isset($_POST['submit'])){

			$jmeno = $_POST["jmeno"];
			$email = $_POST["email"];
			$heslo = $_POST["heslo"];
			$heslo_znova = $_POST["heslo_znova"];

			$heslo_hash = password_hash($heslo, PASSWORD_DEFAULT);
			$errors = array();

			if(empty($jmeno) OR empty($email) OR empty($heslo) OR empty($heslo_znova)){
				array_push($errors,"Všechny pole musí být vyplněné");
			}
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				array_push($errors,"Špatně zadáný email");
			}
			if(strlen($heslo) < 8){
				array_push($errors,"Heslo musí být alespoň 8 znaků dlouhé");
			}
			if($heslo !== $heslo_znova){
				array_push($errors,"Heslo se neshodují");
			}

			require_once "databaze.php";
			$sql = "SELECT * FROM uzivatele WHERE email = '$email'";

			$vysledek = mysqli_query($spojeni, $sql);
			$pocet_radku = mysqli_num_rows($vysledek);
			if($pocet_radku > 0){

				array_push($errors,"Email už existuje");
			}

			if(count($errors) > 0){
				foreach($errors as $error){
					echo "<div class='alert alert-danger'>$error</div>";
				}
			}
			else{

				$sql = "INSERT INTO uzivatele(jmeno, email, heslo) VALUES ( ?, ?, ? )";
				$stmt = mysqli_stmt_init($spojeni);
				$prepareStmt = mysqli_stmt_prepare($stmt,$sql);
				if($prepareStmt){
					mysqli_stmt_bind_param($stmt,"sss",$jmeno,$email,$heslo_hash);
					mysqli_stmt_execute($stmt);
					echo "<div class='alert alert-success'>Byli jste úspěšně zaregistrováni.</div>";
				}
				else{
					die("Šéfe mě se asi něco nepovedlo. Já jsem přesekl nějaký kabel.");
				}


			}

		}

	?>
        <form action="registrace.php" method="post">

		<h2 id="nadpis">Registrace</h2>
            <div class="form-group">
                <input type="text" class="form-control" name="jmeno" placeholder="Jméno:">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="heslo" placeholder="Heslo:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="heslo_znova" placeholder="Heslo znova:">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Registrovat" name="submit">
            </div>
        </form>
        <div id="odkaz"><p>Pokud se chceš přihlásit klikni <a id="link" href="prihlaseni.php">SEM</a></p></div>
    </div>
</body>
</html>