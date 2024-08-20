<?php
    include("../include/connect_session.php");
    include ("../include/definitions.php");

//Verificación inicial, debe estar logeado
try{
    if (logged && is_GET_set("id")) {
        $id = $_GET["id"];

        $query = "SELECT id FROM salas_chat WHERE id = ? ";
        if(access_level <= 3) $query.= "AND id_creador = ". userId;
        if(mysqli_num_rows(db::mysqliExecuteQuery( $query, "s", array($id))) == 1){
            $query = "UPDATE salas_chat SET borrado = 1 WHERE id = ?";
            db::mysqliExecuteQuery( $query, "s", array($id));

            session::info_message("Sala borrada con éxito", "success");
            header("Location: ../chats.php");

        }
    }
}catch(Exception $e){
    echo "error";
}

?>