<?php
session_start();
if(!isset($_SESSION["uzivatel"])){
    header("Location: prihlaseni.php");
}
?>

<?php
require "databaze.php";

if(isset($_POST["submit"])){
    $jmeno = $_POST["jmeno"];
    if($_FILES["obrazek"]["error"] === 4){
        echo "<script>alert('Obrazek neexistuje'); </script>";
    }else{
        $jmeno_souboru = $_FILES["obrazek"]["name"];
        $velikost_souboru = $_FILES["obrazek"]["size"];
        $docasne_jmeno_souboru = $_FILES["obrazek"]["tmp_name"];

        $povolene_koncovky = ['jpg', 'jpeg', 'png'];
        $koncovka_obrazku = explode(".",$jmeno_souboru);
        $koncovka_obrazku = strtolower(end($koncovka_obrazku));

        if(!in_array($koncovka_obrazku,$povolene_koncovky)){
            echo "<script>alert('Špatná koncovka obrázku $koncovka_obrazku'); </script>";
            
        }elseif($velikost_souboru > 1000000){
            echo "<script>alert('Obrázek je moc velký UwU'); </script>";
        }else{
            $nove_jmeno_obrazku = uniqid();
            $nove_jmeno_obrazku .= '.' . $koncovka_obrazku;
            move_uploaded_file($docasne_jmeno_souboru, 'uploads/' . $nove_jmeno_obrazku);
            $sql = "INSERT INTO upload VALUES('', '$jmeno', '$nove_jmeno_obrazku')";
            mysqli_query($spojeni,$sql);
            echo "<script>alert('Obrázek byl úspěšně přidán'); </script>";
        }
    

    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Galerie</title>
        <link rel="stylesheet" href="galerie_styl.css">
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
            <div class="container">
                <form action="galerie.php" method="post" enctype = "multipart/form-data">
                    <div class="form-group">
                        <label for="jmeno">Jméno: </label>
                        <input type="text" name="jmeno" id="jmeno" class="form-control" required><br>
                    </div>

                    <div class="form-group">
                        <label for="obrazek">Obrazek: </label>
                        <input type="file" name="obrazek" id="obrazek" accept=".jpg, .jpeg, .png" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <input type="submit" name="submit" value="Nahrát" class="btn btn-warning">
                    </div>
                </form>
            </div> 

        <table border = 1 cellspacing = 0 cellpadding = 10>
            <tr>
                <td>#</td>
                <td>Jméno</td>
                <td>Obrázek</td>
            </tr>
            <?php
            $i = 1;
            $rows = mysqli_query($spojeni, "SELECT * FROM upload ORDER BY id DESC")
            ?>

            <?php foreach ($rows as $row) : ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $row["jmeno"]; ?></td>
                <td> <img src="uploads/<?php echo $row["obrazek"];?>" width = 200 title="<?php echo $row["obrazek"]; ?>"> </td>
            </tr>
      <?php endforeach; ?>
    </table>
    </body>
</html>