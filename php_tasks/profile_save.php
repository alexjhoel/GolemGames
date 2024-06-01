<?php
    include("../include/connect_session.php");

    $id = $_POST["id"];

    if(logged && userId == $id){
        $name = $_FILES["foto_perfil"]["name"];
        $extension = end(((explode(".", $name))));
        //Stores the filetype e.g image/jpeg
        $imagetype = $_FILES['foto_perfil']['type'];
        //Stores any error codes from the upload.
        $imageerror = $_FILES['foto_perfil']['error'];
        //Stores the tempname as it is given by the host when uploaded.
        $imagetemp = $_FILES['foto_perfil']['tmp_name'];

        //The path you wish to upload the image to
        $imageFolderPath = "uploads/profiles";
        $imagePath = "$imageFolderPath/$id.".$extension;
        
        if(is_uploaded_file($imagetemp) && move_uploaded_file($imagetemp, "../".$imagePath)) {
            $query = "UPDATE Usuarios SET nombre = ?, correo_electronico = ?, sobre_mi = ?, foto_perfil = ? WHERE id = ?";
            db::mysqliExecuteQuery($conn, $query, "sssss", array($_POST["usuario"], $_POST["email"], $_POST["sobre_mi"], $imagePath, $id));
        }else{
            $query = "UPDATE Usuarios SET nombre = ?, correo_electronico = ?, sobre_mi =?  WHERE id = ?";
            db::mysqliExecuteQuery($conn, $query, "ssss", array($_POST["usuario"], $_POST["email"],  $_POST["sobre_mi"], $id));
        }

        header("Location: ../profile_info.php?id=$id");
        return;
    }

    
    
    header("Location: ../home.php");
?>