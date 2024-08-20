<?php
    include("../include/connect_session.php");
    include ("../include/definitions.php");

//Verificación inicial, debe estar logeado
try{
    if (logged && access_level == 4) {

        $id = $_GET["id"];
        if(is_GET_set("moderator")){
            $query = "UPDATE usuarios SET nivel_acceso = 3 WHERE id = ?";
            db::mysqliExecuteQuery( $query, "s", array($id));

            session::info_message("Usuario promovido a moderador con éxito", "success");
        }else if (is_GET_set("developer")){
            $query = "UPDATE usuarios SET nivel_acceso = 2 WHERE id = ?";
            db::mysqliExecuteQuery( $query, "s", array($id));

            session::info_message("Usuario descendido a desarrollador con éxito", "success");
        }

        
        header("Location: ../profile_info.php?id=$id");
        exit();
    }
}catch(Exception $e){
    echo "error";
}

header("Location: ../home.php");

?>