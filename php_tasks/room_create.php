<?php
    include("../include/connect_session.php");
    include ("../include/definitions.php");

    /**Validación de crear sala de chat*/
function validate($titulo, $descripcion)
{
    $output = array("titulo" => "ok", "descripcion" => "ok");
    try {
        //Validación de título
        $maxTitulo = 64;
        $minTitulo = 1;
        if (strlen($titulo) > $maxTitulo || strlen($titulo) < $minTitulo) {
            $output["titulo"] = "El título no debe exceder los $maxTitulo caracteres y debe tener al menos $minTitulo caracteres";
        }

        //Validación de descripcion
        $maxDesc = 200;
        $minDesc = 0;
        if (strlen($descripcion) > $maxDesc || strlen($descripcion) < $minDesc) {
            $output["titulo"] = "El título no debe exceder los $maxDesc";
        }
        

    }  
    catch (Exception $e) {
        $output["error"] = $e->getMessage();
    }


    return $output;

}



//Verificación inicial, debe estar logeado
try{
    if (logged && are_POST_set(["titulo", "descripcion"])) {
        $titulo = trim($_POST["titulo"]);
        $descripcion = trim($_POST["descripcion"]);
    
        if (is_GET_set("validate")) {
            //Chequeo de usuario cuando intenta iniciar sesion
            
            $output = validate($titulo, $descripcion);
        
            header("Content-Type: application/json");
            echo json_encode($output);
            exit();
        }else{
            //Validación completa del título, la descripción y los archivos subidos
            $output = validate($titulo, $descripcion);
            //Contar la cantidad de "ok" devuelta por la validación
            $validation_ok = count(array_unique(array_values($output))) === 1;
            if($validation_ok){
                $query = "INSERT INTO salas_chat (tema, descripcion, oculto, id_creador) VALUES(?,?,?,?)";
                db::mysqliExecuteQuery( $query, "ssss", array($titulo, $descripcion, 0, userId));
                $query = "INSERT INTO usuarios_ingresan_salas (id_sala_chat, id_usuario) VALUES(?,?)";
                db::mysqliExecuteQuery( $query, "ss", array(mysqli_insert_id(db::$conn) , userId));
                
                session::info_message("Sala creada con éxito", "success");
                header("Location: ../chats.php?id=".mysqli_insert_id(db::$conn));
            }
        }
    }
}catch(Exception $e){
    echo $e->getMessage();
    $output["error"] = "error";
}

die("0");

?>