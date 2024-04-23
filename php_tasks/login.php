<?php
include ("../include/connect.php");
include ("../include/session.php");


function loginCheck($conn, $usuario, $clave)
{
    //Se verifica la existencia del usuario y la validez de sus credenciales
    $output = array("ok", "ok", "ok");
    try{
        $result = db::mysqliExecuteQuery(
            $conn,
            "SELECT nombre, clave FROM usuarios WHERE nombre=? OR correo_electronico = ?",
            "ss",
            array($usuario, $usuario)
        );
    
        if (mysqli_num_rows($result) == 0) {
            //Usuario no existente
            $output[0] = "El usuario no existe";
        } else {
            $row = $result->fetch_assoc();
            if (!password_verify($clave, $row["clave"])) {
                $output[1] = "Contraseña incorrecta";
            }
        }
    }
    catch(Exception $e){
        $output[2] = $e->getMessage();
    }
    

    return $output;


}

function registerCheck($conn, $usuario, $correo, $clave, $terminos){
    $output = array("ok", "ok", "ok", "ok", "ok");
    try{
        //Chequeo para el registro

        if(strlen($usuario) > 32 || strlen($usuario) < 8){
            $output[0] = "El nombre de usuario no debe exceder los 32 caracteres y debe tener mas de 8 caracteres";
        }else {

            $result = db::mysqliExecuteQuery(
                $conn,
                "SELECT nombre FROM usuarios WHERE nombre=?",
                "s",
                array($usuario)
            );

            if(mysqli_num_rows($result) != 0){
                
                $output[0] = "Ya existe ese nombre de usuario";
            }
        }

        $result = db::mysqliExecuteQuery(
            $conn,
            "SELECT nombre FROM usuarios WHERE correo_electronico=?",
            "s",
            array($usuario)
        );

        if(mysqli_num_rows($result) != 0){
            $output[1] = "Este correo ya está en uso";
        }

        if(!filter_var($correo, FILTER_VALIDATE_EMAIL)){
            $output[1] = "Ingrese un email válido";
        }

        if(strlen($clave) < 8){
            $output[2] = "La contraseña debe tener al menos 8 caracteres";
        }

        if(!$terminos) $output[3] = "Debes aceptar los términos y condiciones";
    }
    catch(Exception $e){
        $output[4] = $e->getMessage();
    }
    

    return $output;

}


$previo = $_SERVER['HTTP_REFERER'];

if (isset ($_POST["login_check"])) {
    //Chequeo de usuario cuando intenta iniciar sesion
    $usuario = $_POST["usuario"];
    $correo = $_POST["usuario"];
    $clave = $_POST["clave"];

    $output = loginCheck($conn, $usuario, $clave);

    header("Content-Type: application/json");
    echo json_encode($output);
    exit();
}

if(isset($_POST["register_check"])){
    //Chequeo para el registro
    $usuario = $_POST["usuario"];
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];
    $terminos = isset($_POST["terminos"]) && $_POST["terminos"] == "true";

    $output = registerCheck($conn, $usuario, $correo, $clave, $terminos);

    header("Content-Type: application/json");
    echo json_encode($output);
    exit();

}

//Formulario de login enviado
if (isset ($_POST["login"]) && !$logged) {

    $usuario = $_POST["usuario"];
    $correo = $_POST["usuario"];
    $clave = $_POST["clave"];

    $loginResult = loginCheck($conn, $usuario, $clave);

    if(count(array_count_values($loginResult)) == 1){
        //Validación ok
        $_SESSION["usuario"] = $_POST["usuario"];
    }else{
        $_SESSION["message"] = $loginResult;
        $_SESSION["message_type"] = "danger";
    }
}

//Formulario de registro enviado
if (isset ($_POST["register"]) && !$logged) {
    $usuario = $_POST["usuario"];
    $correo = $_POST["correo"];
    $clave = $_POST["clave"];
    $terminos = isset($_POST["terminos"]) && $_POST["terminos"] == "true";
    $registerResult = registerCheck($conn, $usuario, $correo, $clave, $terminos);
    
    if(count(array_count_values($registerResult)) == 1){
        //Validación ok
        db::mysqliExecuteQuery($conn, "INSERT INTO Usuarios (nombre, correo_electronico, clave, fecha_registro) VALUES(?,?,?,NOW())","sss",
        array(
            $_POST["usuario"], $_POST["correo"], password_hash($_POST["clave"], PASSWORD_DEFAULT) 
        ));
        $_SESSION["usuario"] = $_POST["usuario"];
    }else{
        $_SESSION["message"] = $loginResult;
        $_SESSION["message_type"] = "danger";
    }
}


if (isset ($_GET["logoff"]) && $logged) {
    unset($_SESSION["usuario"]);
}



header('Location: ' . $previo);
?>