<?php
include ("../include/connect_session.php");
include ("../include/definitions.php");



var_dump($_FILES);
try {
    if (logged && access_level >= ADMIN_REQUIRED && are_POST_set(["nombre", "id"])) {
        $query = "INSERT INTO categorias (id, nombre) VALUES ";
        $params = array();
        $types = "";
        for ($i = 0; $i < count($_POST["id"]) - 1; $i++) {
            $id = $_POST["id"][$i];
            $nombre = $_POST["nombre"][$i];

            $query .= "(?, ?), ";
            $types .= "ss";
            array_push($params, $id, $nombre);
        }
        $id = $_POST["id"][$i];
        $nombre = $_POST["nombre"][$i];

        $query .= "(?, ?) ";
        $types .= "ss";
        array_push($params, $id, $nombre);

        $query .= "ON DUPLICATE KEY UPDATE id=VALUES(id), nombre=VALUES(nombre)";

        db::mysqliExecuteQuery($query, $types, $params);

        if(is_POST_set("action") && $_POST["action"] == "add"){
            $query = "INSERT INTO categorias (nombre) VALUES ('Nueva categoría')";
            db::mysqliExecuteQuery($query, "", array());
        }

        if(is_POST_set("delete")){
            $query = "UPDATE categorias SET borrado = 1 WHERE id = ?";
            db::mysqliExecuteQuery($query, "s", array($_POST["delete"]));
        }
    } else {
        session::info_message("Acceso restringido", "danger");
    }
} catch (Exception $e) {
    echo $e->getMessage();
}


header("Location: ../edit_home.php#edit-categories");



