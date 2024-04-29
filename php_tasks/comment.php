<?php
include ("../include/connect.php");
include ("../include/session.php");

$previo = $_SERVER['HTTP_REFERER'];



if(isset($_POST["id_usuario"]) && isset($_POST["id_juego"])){
    $idUsuario = $_POST["id_usuario"];
    $idJuego = $_POST["id_juego"];
    if(isset($_GET["like"])){
        $idUsuario = $_POST["id_usuario"];
        $idJuego = $_POST["id_juego"];
        
        $query = "UPDATE usuarios_ven_juegos SET `like` = NOT `like` WHERE id_usuario = ? AND id_juego = ?";

        db::mysqliExecuteQuery($conn, $query, "ii", array($idUsuario, $idJuego));
    }else{
        $texto = $_POST["texto"];
        $query = "INSERT INTO comentarios (id_usuario, id_juego, texto, fecha) VALUES (?, ?, ?, NOW())";

        db::mysqliExecuteQuery($conn, $query, "sss", array($idUsuario, $idJuego, $texto));
    }
}

header('Location: ' . $previo);

?>