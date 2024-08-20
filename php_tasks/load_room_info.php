<?php
    include("../include/connect_session.php");
    include("../include/definitions.php");

//Devolver informacion importante de la sala

$output = array();
try{
    if (logged && is_POST_set("id")) {
        $roomId = $_POST["id"];

        //Datos de sala de chat
        $query = "SELECT COUNT(id_usuario) as cantidad_miembros, tema, descripcion, id_creador 
                    FROM salas_chat 
                    LEFT JOIN usuarios_ingresan_salas ON salas_chat.id = id_sala_chat
                    LEFT JOIN usuarios ON id_usuario = usuarios.id
                    WHERE oculto = 0 
                    AND salas_chat.borrado = 0
                    AND salas_chat.id = ?
                    GROUP BY salas_chat.id";
        $res = db::mysqliExecuteQuery($query, "s", array($roomId));

        if (mysqli_num_rows($res) != 0){
            $query = "SELECT id, nombre 
            FROM usuarios_ingresan_salas 
            INNER JOIN usuarios ON id_usuario = id 
            WHERE usuarios.borrado = 0 AND id_sala_chat = ?";
            $members = mysqli_fetch_all(db::mysqliExecuteQuery($query, "s", array($roomId)), MYSQLI_ASSOC);

            $output = mysqli_fetch_all($res, MYSQLI_ASSOC)[0];
            $output["members"] = $members;
        } 
    }
    
}catch(Exception $e){
    $output = array();
}

//Salida del programa
header("Content-Type: application/json");
echo json_encode($output);

?>