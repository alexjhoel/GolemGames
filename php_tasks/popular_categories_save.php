<?php
include ("../include/connect_session.php");
include ("../include/definitions.php");



var_dump($_FILES);
try {
    if (logged && access_level >= ADMIN_REQUIRED) {
        for ($i = 1; $i <= 5; $i++) {
            if (is_POST_set("id_categoria_popular_$i")) {
                $query = "UPDATE categorias_destacadas SET id_categoria = ? WHERE orden = $i";
                db::mysqliExecuteQuery($query, "s", [$_POST["id_categoria_popular_$i"]]);
            }
            if (!isset($_FILES["imagen_categoria_popular_$i"]) || $_FILES["imagen_categoria_popular_$i"]["error"] != 0)
                continue;

            $fileData = $_FILES["imagen_categoria_popular_$i"];
            $temp = $fileData["tmp_name"];
            $name = $fileData["name"];
            $ext = pathinfo($name, PATHINFO_EXTENSION);

            //checking if file with same name already exists
            if (file_exists("../uploads/categories/$i.$ext"))
                unlink("../uploads/categories/$i.$ext");

            //upload file now using the move_uploaded_file()
            move_uploaded_file($temp, "../uploads/categories/$i.$ext");

            $query = "UPDATE categorias_destacadas SET link_imagen = ? WHERE orden = $i";
            db::mysqliExecuteQuery($query, "s", ["../uploads/categories/$i.$ext"]);

        }
    } else {
        session::info_message("Acceso restringido", "danger");
    }
} catch (Exception $e) {
    echo $e->getMessage();
}

header("Location: ../edit_home.php");



