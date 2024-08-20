<?php

include ("../include/connect_session.php");
include ("../include/definitions.php");


/**Validación de registro*/
function validate($usuario, $correo, $clave, $terminos)
{
    $output = array("usuario" => "ok", "clave" => "ok", "correo" => "ok", "terminos" => "ok", "ok");
    try {

        if (strlen($usuario) > 16 || strlen($usuario) < 8) {
            $output["usuario"] = "El nombre de usuario no debe exceder los 16 caracteres y debe tener al menos 8 caracteres";
        } else if(!preg_match('/^[A-Za-z][A-Za-z0-9]{7,17}$/', $usuario) ){
            $output["usuario"] = "El nombre de usuario debe ser una combinación de caracterés alfanuméricos que empiece con una letra";
        }else{

            $result = db::mysqliExecuteQuery(
                "SELECT nombre FROM usuarios WHERE nombre=?",
                "s",
                array($usuario)
            );

            if (mysqli_num_rows($result) != 0) {

                $output["usuario"] = "Ya existe ese nombre de usuario";
            }
        }

        $result = db::mysqliExecuteQuery(
            "SELECT nombre FROM usuarios WHERE correo_electronico=?",
            "s",
            array($correo)
        );

        if (mysqli_num_rows($result) != 0) {
            $output["correo"] = "Este correo ya está en uso";
        }

        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $output["correo"] = "Ingrese un email válido";
        }

        if (strlen($clave) < 8) {
            $output["clave"] = "La contraseña debe tener al menos 8 caracteres";
        }

        if (!$terminos)
            $output["terminos"] = "Debes aceptar los términos y condiciones";
    } catch (Exception $e) {
        $output[4] = $e->getMessage();
    }


    return $output;

}

if (are_POST_set(["usuario", "correo", "clave"])) {

    $usuario = $_POST["usuario"];
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];
    $terminos = is_POST_set("terminos") && $_POST["terminos"] == "on";

    if (is_GET_set("validate")) {
        //Validación de registro

        $output = validate($usuario, $correo, $clave, $terminos);
        
        //Salida del programa
        header("Content-Type: application/json");
        echo json_encode($output);
        exit();
    } else if (!logged) {
        //Formulario de registro enviado, solo si es un usuario no logeado

        $registerResult = validate($usuario, $correo, $clave, $terminos);

        $registerResultOK = true;

        foreach($registerResult as $r){
            $registerResultOK = $registerResultOK && $r == "ok";
        }
        if ($registerResultOK) {
            //Validación ok, guarda el id de usuario en session
            db::mysqliExecuteQuery(
                "INSERT INTO usuarios (nombre, correo_electronico, clave, fecha_registro) VALUES(?,?,?,NOW())",
                "sss",
                array(
                    $usuario,
                    $correo,
                    password_hash($clave, PASSWORD_DEFAULT)
                )
            );
            session::set("id_usuario", db::$conn->insert_id);

            $userData = mysqli_fetch_assoc(db::mysqliExecuteQuery(
                "SELECT id, token FROM usuarios WHERE nombre=? AND correo_electronico = ?",
                "ss",
                array($usuario, $correo)
            ));
            
            session::set("token", $userData["token"]);    
        } else {
            session::info_message($registerResult, "danger");
        }

        //Salida del programa
        header("Location: ../home.php");
        exit();
    }
}



?>