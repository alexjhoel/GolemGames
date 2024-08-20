<?php
include("../include/definitions.php");
include("../include/connect_session.php");

if(logged && is_GET_set("id") && is_numeric($_GET["id"]) && access_level >= 3){
    $id = $_GET["id"];
    $query = "INSERT INTO juegos_destacados (id_juego, fecha, id_administrador) VALUES (?, NOW(), ?)
    ON DUPLICATE KEY UPDATE fecha = NOW(), id_administrador = VALUE(id_administrador), borrado = IF(borrado, 0, 1)";
    db::mysqliExecuteQuery($query, "ss", [$id, userId]);

    header("Location: ../game_info.php?id=$id");
    session::info_message("Cambios realizados con éxito", "success");
    exit();
}

session::info_message("Acceso denegado", "danger");
header("Location: ../home.php?id=$id");