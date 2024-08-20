<?php
    include("../include/connect_session.php");
    include ("../include/definitions.php");

//Verificación inicial, debe estar logeado
try{
    if (logged && is_GET_set("id") && is_numeric($_GET["id"])) {
        $id = $_GET["id"];

        $query = "SELECT id FROM salas_chat WHERE id = ?";
        if(mysqli_num_rows(db::mysqliExecuteQuery( $query, "s", array($id))) == 1){
            $query = "DELETE FROM usuarios_ingresan_salas WHERE id_usuario = ? AND id_sala_chat = ?";
            db::mysqliExecuteQuery( $query, "ss", array(userId, $id));

            session::info_message("Has salido de la sala con éxito", "success");
            header("Location: ../chats.php");
            exit();

        }
    }
}catch(Exception $e){
    $output = "error";
}

header("Location: ../home.php");

die("0");

?>