<?php
$requesturi = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$pos = strpos($requesturi, "exploreazteka");

$hostname_excal = "localhost";
$database_excal = "azteka";
$username_excal = "root";
$password_excal = "";

$excal = mysql_pconnect($hostname_excal, $username_excal, $password_excal) or trigger_error(mysql_error(),E_USER_ERROR); 

?>
