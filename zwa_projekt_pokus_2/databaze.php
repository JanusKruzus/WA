<?php

$host_name = "localhost";
$db_uzivatel = "root";
$db_heslo = "";
$db_jmeno = "login_register";

$spojeni = mysqli_connect($host_name,$db_uzivatel,$db_heslo,$db_jmeno);

if(!$spojeni){
    die("Šéfe mě se asi něco nepovedlo. Já jsem přesekl nějaký kabel.");

}


?> 