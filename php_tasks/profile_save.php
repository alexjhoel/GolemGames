<?php
    include("../include/connect_session.php");
    include ("../include/definitions.php");

    /**Validación de editar perfil*/
function validate($usuario, $sobre_mi, $correo, $foto_perfil)
{
    $output = array("usuario" => "ok", "sobre_mi" => "ok", "correo" => "ok", "foto_perfil_feedback" => "ok", "ok");
    try {
        //Validación de usuario
        $maxUsuario = 16;
        $minUsuario = 8;
        if (strlen($usuario) > $maxUsuario || strlen($usuario) < $minUsuario) {
            $output["usuario"] = "El nombre de usuario no debe exceder los $maxUsuario caracteres y debe tener al menos $minUsuario caracteres";
        } else if(!preg_match('/^[A-Za-z][A-Za-z0-9]{'.($minUsuario - 1).','.($maxUsuario-1).'}$/', $usuario) ){
            $output["usuario"] = "El nombre de usuario debe ser una combinación de caracterés alfanuméricos que empiece con una letra";
        }else{
            $result = db::mysqliExecuteQuery(
                "SELECT nombre FROM usuarios WHERE nombre=? AND NOT nombre = ?",
                "ss",
                array($usuario, username)
            );

            if (mysqli_num_rows($result) != 0) {

                $output["usuario"] = "Ya existe ese nombre de usuario";
            }
        }

        
        //Validación de sobre mi
        if(strlen($sobre_mi) > 200) $output["sobre_mi"] = "Tu descripción no debe superar los 200 caracteres";

        $result = db::mysqliExecuteQuery(
            "SELECT nombre FROM usuarios WHERE correo_electronico=? AND NOT correo_electronico = ?",
            "ss",
            array($usuario, email)
        );

        if (mysqli_num_rows($result) != 0) {
            $output["correo"] = "Este correo ya está en uso";
        }

        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $output["correo"] = "Ingrese un email válido";
        }
        
        //Tamaño de la imagen
        $size=$_FILES[$foto_perfil]['size'];
        //Errores de carga
        $imageerror = $_FILES[$foto_perfil]['error'];
        //Nombre temporal de la imagen
        $imagetemp = $_FILES[$foto_perfil]['tmp_name'];

        //Error 4: no se subió ningún archivo
        if($imageerror != 4){
            //Error 0: no hubieron errores
            if($imageerror != 0) 
                $output["foto_perfil_feedback"] = "Ocurrió un error al subir la imagen";
            else if(getimagesize($imagetemp)==false) 
                $output["foto_perfil_feedback"] = "Verifique que el archivo sea de imagen";
            else{
                list($width, $height) = getimagesize($imagetemp);
    
                if($width > MAX_PROFILE_PICTURE_LENGTH || $height > MAX_PROFILE_PICTURE_LENGTH) $output["foto_perfil_feedback"] = "La imagen es muy grande. MAX: ".MAX_PROFILE_PICTURE_LENGTH."PX en ancho y largo";
                else if($size * BYTE_TO_MB > MAX_PROFILE_PICTURE_SIZE) $output["foto_perfil_feedback"] = "La imagen supera el tamaño máximo de ".MAX_PROFILE_PICTURE_SIZE;
            }
        }
    } catch (Exception $e) {
        $output[4] = $e->getMessage();
    }


    return $output;

}

if (logged && is_FILE_set("foto_perfil") && are_POST_set(["usuario", "correo", "sobre_mi"])) {
    $id = userId;
    $usuario = $_POST["usuario"];
    $correo = $_POST["correo"];
    $sobre_mi = $_POST["sobre_mi"];
        if (is_GET_set("validate")) {
            //Validación de editar perfil
    
            $output = validate($usuario, $sobre_mi, $correo, "foto_perfil");
            
            //Salida del programa
            header("Content-Type: application/json");
            echo json_encode($output);
            exit();
        } else {
            //Formulario de editar perfil enviado
    
            $validationResult = validate($usuario, $sobre_mi, $correo, "foto_perfil");
    
            $validationResultOK = true;
    
            foreach($validationResult as $r){
                $validationResultOK = $validationResultOK && $r == "ok";
            }
            
            if ($validationResultOK) {
                
                //Nombre del archivos
                $name = $_FILES["foto_perfil"]["name"];
                //Extensión del archivo
                $extension = end(((explode(".", $name))));
                //Tipo del archivo
                $imagetype = $_FILES['foto_perfil']['type'];
                //Tamaño de la imagen
                $size=$_FILES['foto_perfil']['size'];
                //Errores de carga
                $imageerror = $_FILES['foto_perfil']['error'];
                //Nombre temporal de la imagen
                $imagetemp = $_FILES['foto_perfil']['tmp_name'];
                
                
                //Ruta de la carpeta a guardar la imagen
                $imageFolderPath = "uploads/profiles";
                $imagePath = "$imageFolderPath/$id.".$extension;
        
    
                if(is_uploaded_file($imagetemp) && move_uploaded_file($imagetemp, "../".$imagePath)) {
                    $query = "UPDATE usuarios SET nombre = ?, correo_electronico = ?, sobre_mi = ?, foto_perfil = ? WHERE id = ?";
                    db::mysqliExecuteQuery( $query, "sssss", array($usuario, $correo, $sobre_mi, $imagePath, $id));
                }else{
                    $query = "UPDATE usuarios SET nombre = ?, correo_electronico = ?, sobre_mi =?  WHERE id = ?";
                    db::mysqliExecuteQuery( $query, "ssss", array($usuario, $correo,  $sobre_mi, $id));
                }

                session::info_message("Tu perfil ha sido actualizado", "success");

            } else {
                session::info_message($validationResult, "danger");
            }
    
            //Salida del programa
            header("Location: ../profile_edit.php");
            exit();
        }
}
    

die("0");

?>