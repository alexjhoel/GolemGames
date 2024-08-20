<?php
    include("../include/connect_session.php");
    include ("../include/definitions.php");

    /**Validación de editar perfil*/
function validate($titulo, $descripcion, $imagenes, $descarga, $web, $catCount)
{
    $output = array("titulo" => "ok", "descripcion" => "ok", "imagenes_agregar_feedback" => "ok", "archivo_descarga" => "ok", "archivo_web" => "ok", "categorias_feedback" => "ok");
    try {
        //Validación de título
        $maxTitulo = 64;
        $minTitulo = 8;
        if (strlen($titulo) > $maxTitulo || strlen($titulo) < $minTitulo) {
            $output["titulo"] = "El título no debe exceder los $maxTitulo caracteres y debe tener al menos $minTitulo caracteres";
        } else if(!preg_match('/^[A-zÀ-ú\w\-\s]{'.($minTitulo - 1).','.($maxTitulo-1).'}$/', $titulo) ){
            $output["titulo"] = "El titulo debe ser una combinación de caracterés alfanuméricos que empiece con una letra";
        }

        //Validación de descripcion
        $maxDesc = 200;
        $minDesc = 0;
        if (strlen($descripcion) > $maxDesc || strlen($descripcion) < $minDesc) {
            $output["titulo"] = "La descripción no debe exceder los $maxDesc";
        }

        //Validación de imagenes a agregar
        if($imagenes){
            for ($i=0; $i < count($_FILES["imagenes_agregar"]['name']); $i++) { 
                //Tamaño de la imagen
                $size=$_FILES["imagenes_agregar"]['size'][$i];
                //Errores de carga
                $imageerror = $_FILES["imagenes_agregar"]['error'][$i];
                //Nombre temporal de la imagen
                $imagetemp = $_FILES["imagenes_agregar"]['tmp_name'][$i];

                //Error 4: no se subió ningún archivo 
                //Error 0: no hubieron errores
                if($imageerror == 4 || $imageerror != 0 || !getimagesize($imagetemp)){ 
                    $output["imagenes_agregar_feedback"] = "Ocurrió un error al subir imágenes";
                    break;
                }
                
                list($width, $height) = getimagesize($imagetemp);
                
                if($width > MAX_GAME_SCREENSOT_WIDTH || $height > MAX_GAME_SCREENSOT_HEIGHT){ $output["imagenes_agregar_feedback"] = "Una imagen es muy grande. MAX: ".MAX_GAME_SCREENSOT_WIDTH ."X".MAX_GAME_SCREENSOT_HEIGHT."PX"; break;}
                
                if($size * BYTE_TO_MB > MAX_GAME_SCREENSOT_SIZE) {$output["imagenes_agregar_feedback"] = "Una imagen supera el tamaño máximo de ".MAX_GAME_SCREENSOT_SIZE; break;}
            }
        }

        if($descarga){
            //Validación del archivo de descarga
            $archivoDescarga = "archivo_descarga";
            if(!isset($_FILES[$archivoDescarga]) || $_FILES[$archivoDescarga]["error"] == 4){
                $output[$archivoDescarga] = "Se debe subir un archivo";
            }else{
                //Tamaño del archivo
                $size=$_FILES[$archivoDescarga]['size'];
                //Errores de carga
                $fileError = $_FILES[$archivoDescarga]['error'];
                //Nombre temporal del archivo
                $fileTemp = $_FILES[$archivoDescarga]['tmp_name'];
                //Nombre del archivo
                $name = $_FILES[$archivoDescarga]['name'];

                //Extensión del archivo
                $extension = pathinfo($name, PATHINFO_EXTENSION);

                //Error 4: no se subió ningún archivo 
                //Error 0: no hubieron errores
                if($fileError != 0){ 
                    $output[$archivoDescarga] = "Ocurrió un error al subir el archivo";
                }else if($extension != "zip"){
                    $output[$archivoDescarga] = "El archivo no es de extensión .zip";
                }else if($size * BYTE_TO_MB > MAX_GAME_DOWNLOAD_FILE_SIZE){ 
                    $output[$archivoDescarga] = "El archivo supera los ".MAX_GAME_DOWNLOAD_FILE_SIZE."MB";}

            } 
            
        }
        
        if($web){
            //Validación del archivo para juego web
            $archivoWeb = "archivo_web";
            if(!isset($_FILES[$archivoWeb]) || $_FILES[$archivoWeb]["error"] == 4){
                $output[$archivoWeb] = "Se debe subir un archivo";
            }else{
                //Tamaño del archivo
                $size=$_FILES[$archivoWeb]['size'];
                //Errores de carga
                $fileError = $_FILES[$archivoWeb]['error'];
                //Nombre temporal del archivo
                $fileTemp = $_FILES[$archivoWeb]['tmp_name'];
                //Nombre del archivo
                $name = $_FILES[$archivoWeb]['name'];

                //Extensión del archivo
                $extension = pathinfo($name, PATHINFO_EXTENSION);

                //Error 4: no se subió ningún archivo 
                //Error 0: no hubieron errores
                if($fileError == 4 || $fileError != 0)
                    $output[$archivoWeb] = "Ocurrió un error al subir el archivo";
                else if($extension != "zip")
                    $output[$archivoWeb] = "El archivo no es de extensión .zip";
                else if($size * BYTE_TO_MB > MAX_GAME_DOWNLOAD_FILE_SIZE)
                    $output[$archivoWeb] = "El archivo supera los ".MAX_GAME_DOWNLOAD_FILE_SIZE."MB";
                else{
                    $za = new ZipArchive(); 

                    $za->open($fileTemp); 
                    $output[$archivoWeb] = "No se encontró el archivo de inicio 'index.html'";
                    for( $i = 0; $i < $za->numFiles; $i++ ){ 
                        $f = $za->statIndex( $i ); 
                        if(basename( $f['name'] == "index.html")){
                            $output["archivo_web"] = "ok";
                            break;
                        }
                    }
                }
            }
            
        }

        $output["categorias_feedback"] = $catCount >= 0 && $catCount <= 4 ? "ok" : "Error";
        

    }
        
    catch (Exception $e) {
        $output["error"] = "error";
    }


    return $output;

}



//Verificación inicial, debe estar logeado
if (logged && are_POST_set(["titulo", "descripcion"])) {
    $id = userId;
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];

    if(isset($_POST["id_categoria"])){
        $id_categorias = $_POST["id_categoria"];
        
        $cat_count = count($id_categorias);
    }else{
        $cat_count = 0;
    }
    
    try{
        if(is_POST_set("edit")){
            /**************************
             EDITAR UN JUEGO
             ************************/
            
            $gameId = $_POST["edit"];

            //Verificar que existe el juego
            $query = "SELECT id_desarrollador, link_archivo_juego, link_descarga FROM juegos WHERE id= ?";
            $result = db::mysqliExecuteQuery( $query, "s", array($gameId));

            
            //Si no existe, terminar
            if(mysqli_num_rows($result) == 0) die("0"); 
            
            $gameData = mysqli_fetch_assoc($result);

            //Validación completa del título, la descripción y los archivos subidos
            $output = validate($titulo, $descripcion, is_FILE_set("imagenes_agregar"), is_FILE_set("archivo_descarga") && is_uploaded_file($_FILES["archivo_descarga"]["tmp_name"]), is_POST_set("web") && is_FILE_set("archivo_web") && is_uploaded_file($_FILES["archivo_web"]["tmp_name"]), $cat_count);
            //Contar la cantidad de "ok" devuelta por la validación
            $validation_ok = count(array_unique(array_values($output))) === 1;

            //Validación correcta, todo ok
            if($validation_ok){
                //Titulo y descripción
                db::mysqliExecuteQuery( "UPDATE juegos SET titulo = ?, descripcion = ? WHERE id = ?", "sss", array($titulo, $descripcion, $gameId));

                //Reset de plataformas
                db::mysqliExecuteQuery( "DELETE FROM plataformas_juegos WHERE id_juego = ?", "s", array($gameId));
                if(is_POST_set("plataforma")){
                    foreach ($_POST["plataforma"] as $key => $value) {
                        db::mysqliExecuteQuery( "INSERT INTO plataformas_juegos (plataforma, id_juego) VALUES(?, ?)", "ss", array($value, $gameId));
                    }
                }

                //Asignar archivos de imágenes
                if(is_FILE_set("imagenes_agregar")){
                    for ($i=0; $i < count($_FILES["imagenes_agregar"]['name']); $i++) { 
                        $scId = mysqli_fetch_assoc(db::mysqliExecuteQuery( "SELECT IFNULL(MAX(id),0) as id FROM capturas_pantalla","", array()))["id"] + 1;
                        $extension = pathinfo($_FILES["imagenes_agregar"]['name'][$i], PATHINFO_EXTENSION);
                        
                        $imageFolderPath = "uploads/screenshots";
                        $imagePath = "$imageFolderPath/$scId.$extension";
                        $imagetemp = $_FILES["imagenes_agregar"]['tmp_name'][$i];
        
                        move_uploaded_file($imagetemp, "../".$imagePath);
        
                        db::mysqliExecuteQuery( "INSERT INTO capturas_pantalla (link_captura, id_juego) VALUES(?, ?)", "ss", array($imagePath, $gameId));
                    }
                }
                
                //Borrar archivos de imágenes
                if(is_POST_set("imagenes_remover")){
                    foreach($_POST["imagenes_remover"] as $key => $imgPath){
                        if(file_exists("../$imgPath")){
                            unlink("../$imgPath");
                        }
                        db::mysqliExecuteQuery( "UPDATE capturas_pantalla SET borrado = TRUE WHERE link_captura = ?", "s", array($imgPath));
                    }
                }
                
                //Actualización de archivo de descarga
                if(is_FILE_set("archivo_descarga") && is_uploaded_file($_FILES["archivo_descarga"]["tmp_name"])){
                    $filePath = $gameData["link_descarga"];
                    if($filePath != "" && file_exists("../$filePath")) unlink("../$filePath");
                    
                    $fileName = $_FILES["archivo_descarga"]['name'];
                    $fileTemp = $_FILES["archivo_descarga"]["tmp_name"];
    
                    $extension = ".zip";
                    $fileFolderPath = "uploads/games_downloads/$gameId";
                    $filePath = "$fileFolderPath/$fileName";
                    
                    if(!file_exists("../".$fileFolderPath)){
                        mkdir("../".$fileFolderPath);
                    }

                    move_uploaded_file($fileTemp, "../".$filePath);
    
                    db::mysqliExecuteQuery( "UPDATE juegos SET link_descarga = ? WHERE id = ?", "ss", array($filePath,$gameId));
                }

                //Actualización de archivo WEB
                if(is_POST_set("web") && is_FILE_set("archivo_web") && is_uploaded_file($_FILES["archivo_web"]["tmp_name"])){
                    //Asignar o actualizar un archivo para poder jugar en web
                    $linkPath = $gameData["link_archivo_juego"];
                    if($linkPath != "" && file_exists("../$linkPath")){
                        rrmdir("../$linkPath") ;
                    }
                    
                    $fileTemp = $_FILES["archivo_web"]['tmp_name'];

                    $zip = new ZipArchive();
                    
                    if($zip->open($fileTemp)){
                        $fileFolderPath = "uploads/games_players/$gameId";
                        if(!file_exists("../$fileFolderPath"))
                            mkdir("../$fileFolderPath");
                        $zip->extractTo("../$fileFolderPath/");
                        $zip->close();
                        db::mysqliExecuteQuery( "UPDATE juegos SET link_archivo_juego = ? WHERE id = ?", "ss", array($fileFolderPath, $gameId));
                    }
                }else if(!is_POST_set("web")){
                    //Borrar un archivo para poder jugar en web
                    $linkPath = $gameData["link_archivo_juego"];
                    if($linkPath != ""){
                        rrmdir("../$linkPath");
                        
                        db::mysqliExecuteQuery( "UPDATE juegos SET link_archivo_juego = ? WHERE id = ?", "ss", array("",$gameId));
                    }
                }

                db::mysqliExecuteQuery( "DELETE FROM juegos_pertenecen_categoria WHERE id_juego = ?", "s", array($gameId));

                for ($i=0; $i < $cat_count; $i++) { 
                    db::mysqliExecuteQuery( "INSERT juegos_pertenecen_categoria (id_juego, id_categoria) VALUES (?,?)", "ss", array($gameId, $id_categorias[$i]));
                }
                db::mysqliExecuteQuery( "UPDATE juegos SET es_publico = ? WHERE id = ?", "ss", array(is_POST_set("publico"), $gameId));

                session::info_message("Se ha editado tu juego con éxito, <a href='game_info.php?id=$gameId'>mira los cambios aquí</a>", "success");
            }


        }else{
            /**************************
             NUEVO JUEGO
             ************************/
            $output = validate($titulo, $descripcion, is_FILE_set("imagenes_agregar"), true, is_POST_set("web") && is_FILE_set("archivo_web"), $cat_count);
    
            $validation_ok = count(array_unique(array_values($output))) === 1;
    
            if($validation_ok){
                


                db::mysqliExecuteQuery( "INSERT INTO juegos (titulo, descripcion, fecha, link_archivo_juego, link_descarga, id_desarrollador) 
                VALUES(?, ?, NOW(), '', '', ?)", "sss", array(
                    $titulo,
                    $descripcion,
                    userId
                ));
    
                $gameId = mysqli_insert_id(db::$conn);

                if(is_POST_set("plataforma")){
                    foreach ($_POST["plataforma"] as $key => $value) {
                        db::mysqliExecuteQuery( "INSERT INTO plataformas_juegos (plataforma, id_juego) VALUES(?, ?)", "ss", array($value, $gameId));
                    }
                }
                if(is_FILE_set("imagenes_agregar")){
                    for ($i=0; $i < count($_FILES["imagenes_agregar"]['name']); $i++) { 
                        $scId = mysqli_fetch_assoc(db::mysqliExecuteQuery( "SELECT IFNULL(MAX(id),0) as id FROM capturas_pantalla","", array()))["id"] + 1;
                        $extension = pathinfo($_FILES["imagenes_agregar"]['name'][$i], PATHINFO_EXTENSION);
                        
                        $imageFolderPath = "uploads/screenshots";
                        $imagePath = "$imageFolderPath/$scId.$extension";
                        $imagetemp = $_FILES["imagenes_agregar"]['tmp_name'][$i];

                        move_uploaded_file($imagetemp, "../".$imagePath);
        
                        db::mysqliExecuteQuery( "INSERT INTO capturas_pantalla (link_captura, id_juego) VALUES(?, ?)", "ss", array($imagePath, $gameId));
                    }
                }

                $fileTemp = $_FILES["archivo_descarga"]['tmp_name'];
                $fileName = $_FILES["archivo_descarga"]['name'];

                $extension = ".zip";
                $fileFolderPath = "uploads/games_downloads/$gameId";
                $filePath = "$fileFolderPath/$fileName";

                if(!file_exists("../$fileFolderPath"))
                    mkdir("../$fileFolderPath");
               
                move_uploaded_file($fileTemp, "../".$filePath);

                db::mysqliExecuteQuery( "UPDATE juegos SET link_descarga = ? WHERE id = ?", "ss", array($filePath, $gameId));


                if(is_POST_set("web")){
                    $fileTemp = $_FILES["archivo_web"]['tmp_name'];

                    $zip = new ZipArchive();
                    
                    if($zip->open($fileTemp)){
                        $fileFolderPath = "uploads/games_players/$gameId";
                        mkdir("../$fileFolderPath");
                        $zip->extractTo("../$fileFolderPath/");
                        $zip->close();
                        db::mysqliExecuteQuery( "UPDATE juegos SET link_archivo_juego = ? WHERE id = ?", "ss", array($fileFolderPath, $gameId));
                    }
                }

                for ($i=0; $i < $cat_count; $i++) { 
                    db::mysqliExecuteQuery( "INSERT juegos_pertenecen_categoria (id_juego, id_categoria) VALUES (?,?)", "ss", array($gameId, $id_categorias[$i]));
                }
                
                db::mysqliExecuteQuery( "UPDATE juegos SET es_publico = ? WHERE id = ?", "ss", array(is_POST_set("publico"), $gameId));
                session::info_message("Se ha subido tu nuevo juego con éxito, <a href='game_info.php?id=$gameId'>miralo aquí</a>", "success");
            }
            
        }
    }catch(Exception $e){
        $output["error"] = $e->getMessage();
    }

    
    
    //Salida del programa
    header("Content-Type: application/json");
    echo json_encode($output);
    exit();
}
    

die("0");

?>