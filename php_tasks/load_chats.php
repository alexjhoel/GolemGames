<?php
    include("../include/connect_session.php");
    include("../include/definitions.php");

//Devolver lista de chats dado un id de sala

$output = array();
try{
    if (logged && is_POST_set("id")) {
        $roomId = $_POST["id"];

        //Existencia de sala de chat
        $query = "SELECT id FROM salas_chat INNER JOIN usuarios_ingresan_salas 
        WHERE oculto = 0 
        AND salas_chat.borrado = 0 
        AND salas_chat.id = ? 
        AND id_usuario = ?";
        if (mysqli_num_rows(\db::mysqliExecuteQuery($query, "ss", array($roomId, userId))) != 0){
            $query = "SELECT * FROM (SELECT mensajes.id as id, texto, fecha, nombre, id_usuario FROM mensajes INNER JOIN usuarios ON id_usuario = usuarios.id WHERE id_sala_chat = ? AND oculto = 0 AND mensajes.borrado = 0 ";
            if(is_POST_set("after") && is_numeric($_POST["after"])) {
                $startId = $_POST["after"];
                $endId = $_POST["after"] + MAX_CHAT_LOAD; 
                $query .= "AND mensajes.id > $startId AND mensajes.id <= $endId";
            }else if(is_POST_set("before") && is_numeric($_POST["before"])){
                $endId = $_POST["before"]; 
                $startId = $_POST["before"] - MAX_CHAT_LOAD;
                $query .= "AND mensajes.id > $startId AND mensajes.id < $endId";
            }else{
                $maxRows = MAX_CHAT_LOAD;
                $query .= "ORDER BY mensajes.id DESC LIMIT 0, $maxRows";
            }

            $query .= ") a ORDER BY a.id ASC";

            $output = mysqli_fetch_all(db::mysqliExecuteQuery($query, "s", array($roomId)), MYSQLI_ASSOC);
        } 
    }
}catch(Exception $e){
    $output = array();
}

//Salida del programa
header("Content-Type: application/json");
echo json_encode($output);

?>