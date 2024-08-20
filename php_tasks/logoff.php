<?php 
include("../include/connect_session.php");
include ("../include/definitions.php");
if (logged) {
    session::unset("id_usuario");
}

header("Location: ../home.php");

?>
