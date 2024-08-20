<?php
include ("../include/connect_session.php");
include ("../include/definitions.php");

$previo = $_SERVER['HTTP_REFERER'];

if(is_POST_set("id_usuario","id_juego")){
    
    $idUsuario = $_POST["id_usuario"];
    $idJuego = $_POST["id_juego"];
    if(is_GET_set("like")){
        
        $query = "UPDATE usuarios_ven_juegos SET `like` = NOT `like` WHERE id_usuario = ? AND id_juego = ?";

        db::mysqliExecuteQuery( $query, "ii", array($idUsuario, $idJuego));
    }else{
        $texto = $_POST["texto"];
        $query = "INSERT INTO comentarios (id_usuario, id_juego, texto, fecha) VALUES (?, ?, ?, NOW())";

        db::mysqliExecuteQuery( $query, "sss", array($idUsuario, $idJuego, $texto));
    }
}

header('Location: ' . $previo);

?>