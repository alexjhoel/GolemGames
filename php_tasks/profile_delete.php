<?php
    include("../include/connect_session.php");
    include ("../include/definitions.php");

//Verificación inicial, debe estar logeado
try{
    if (logged && is_GET_set("id")) {
        $id = $_GET["id"];
        if(access_level == 4 || $id == userId){
            $query = "UPDATE usuarios SET borrado = 1 WHERE id = ?";
            db::mysqliExecuteQuery( $query, "s", array($id));

            session::info_message("Usuario borrado con éxito", "success");
            if($id == userId){
                header("Location: ../home.php");
            }else{
                header("Location: ../profile_info.php");
            }

        }
    }
}catch(Exception $e){
    echo "error";
}

die("0");

?>