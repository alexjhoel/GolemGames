<?php session_start(); 

define("logged", isset($_SESSION["usuario"]));
if(logged) define("username", $_SESSION["usuario"]);

?>
