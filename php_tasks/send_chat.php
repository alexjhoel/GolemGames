<?php
include_once ("../include/connect_session.php");
include_once ("../include/definitions.php");


if (!logged || !are_POST_set(["room", "text"])  || strlen(trim($_POST["text"])) == 0) return;

try{
    //Existencia de sala de chat
    $query = "SELECT id FROM salas_chat INNER JOIN usuarios_ingresan_salas 
    WHERE oculto = 0 
    AND salas_chat.borrado = 0 
    AND salas_chat.id = ? 
    AND id_usuario = ?";
    if (mysqli_num_rows(\db::mysqliExecuteQuery($query, "ss", array($_POST["room"], userId))) == 0) return;

    $query = "INSERT INTO mensajes (fecha, texto, id_sala_chat, id_usuario) VALUES(NOW(),?,?,?)";
    \db::mysqliExecuteQuery($query, "sss", array($_POST["text"], $_POST["room"], userId));
}catch(Exception $e){
    echo "error";
}



