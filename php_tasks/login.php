<?php

use function PHPSTORM_META\map;

include ("../include/connect_session.php");
include ("../include/definitions.php");

function validate($usuario, $clave)
{
    //Se verifica la existencia del usuario y la validez de sus credenciales
    $output = array("usuario" => "ok", "clave" => "ok","error"=> "ok");
    try{
        $result = db::mysqliExecuteQuery(
            "SELECT nombre, clave FROM usuarios WHERE (nombre=? OR correo_electronico = ?) AND borrado = FALSE",
            "ss",
            array($usuario, $usuario)
        );
    
        if (mysqli_num_rows($result) == 0) {
            //Usuario no existente
            $output["usuario"] = "El usuario no existe";
        } else {
            $row = $result->fetch_assoc();
            if (!password_verify($clave, $row["clave"])) {
                $output["clave"] = "Contraseña incorrecta";
            }
        }
    }
    catch(Exception $e){
        $output["error"] = $e->getMessage();
    }
    

    return $output;


}

if(are_POST_set(["usuario", "clave"])){
    $usuario = $_POST["usuario"];
    $correo = $_POST["usuario"];
    $clave = $_POST["clave"];

    if (is_GET_set("validate")) {
        //Chequeo de usuario cuando intenta iniciar sesion
        
        $output = validate($usuario, $clave);
    
        header("Content-Type: application/json");
        echo json_encode($output);
        exit();
    }else if (!logged) {
    
        $usuario = $_POST["usuario"];
        $clave = $_POST["clave"];
    
        $loginResult = validate($usuario, $clave);

        $loginResultOK = true;

        foreach($loginResult as $r){
            $loginResultOK = $loginResultOK && $r == "ok";
        }
    
        if($loginResultOK){
            //Validación ok, guarda el id de usuario en session, genera token de inicio de sesión
            db::mysqliExecuteQuery(
                "UPDATE usuarios SET token = uuid() WHERE nombre=? OR correo_electronico = ?",
                "ss",
                array($usuario, $usuario));

            $userData = mysqli_fetch_assoc(db::mysqliExecuteQuery(
                "SELECT id, token FROM usuarios WHERE nombre=? OR correo_electronico = ?",
                "ss",
                array($usuario, $usuario)
            ));

            session::set("id_usuario", $userData["id"]);
            
            session::set("token", $userData["token"]);    
        }else{
            session::info_message($loginResult,"danger");
        }
        //Salida del programa
        header("Location: ../home.php");
    }
}


die("0");
?>