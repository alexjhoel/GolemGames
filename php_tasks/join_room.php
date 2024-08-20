<?php
include("../include/connect_session.php");
include("../include/definitions.php");

//Unirse a una sala de chat
$output = "error";

if(logged && is_POST_set("id") && is_numeric($_POST["id"])){
    try{
        $query = "INSERT INTO usuarios_ingresan_salas (id_usuario, id_sala_chat)  VALUES(?, ?)";
        db::mysqliExecuteQuery($query, "ss", array(userId, $_POST["id"]));
        $output = "success";
    }catch(Exception $e){
        //$output = $e->getMessage();
    }
}

header("Content-Type: application/json");
echo json_encode($output);
?>