<?php
include("../include/definitions.php");
include("../include/connect_session.php");

try{
    if(logged && is_GET_set("id") && is_numeric($_GET["id"])){
        $id = $_GET["id"];
        $query = "UPDATE juegos SET es_publico = NOT es_publico WHERE id = ?";
        if(access_level < 3){
            $query .= " AND id_desarrollador = ".userId;
        }
        db::mysqliExecuteQuery($query, "s", array($id));
    
        header("Location: ../game_info.php?id=$id");
        session::info_message("Cambios realizados con éxito", "success");
        exit();
    }
    
    
}catch(Exception $exc){
}

session::info_message("Acceso denegado", "danger");
header("Location: ../home.php");
exit();
