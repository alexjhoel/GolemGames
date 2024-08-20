<?php
include("../include/connect_session.php");
include ("../include/definitions.php");

    /**Validación de editar perfil*/
function validate($userId, $gameId, $isAdministrator){
    $output = false;

    try{
        if($isAdministrator){
            $query = "SELECT id FROM juegos WHERE id = ? AND NOT ? = -1";
        }else{
            $query = "SELECT id FROM juegos WHERE id = ? AND id_desarrollador = ?";
        }

        $output = mysqli_num_rows(db::mysqliExecuteQuery( $query, "ss", array($gameId, $userId))) == 1;

    }catch(Exception $exc){
        $output = false;
    }

    return $output;

}

session::info_message("Acceso restringido", "danger");
try{
    if(is_GET_set("id") && logged){
        
        
        if(validate(userId, $_GET["id"], access_level == 4)){
            $gameData = mysqli_fetch_assoc(db::mysqliExecuteQuery("SELECT link_descarga, link_archivo_juego FROM juegos WHERE id = ?", "s", array($_GET["id"])));
            $download_link = $gameData["link_descarga"];
            $player_link = $gameData["link_descarga"];

            if($download_link != "") unlink("../$download_link");
            if($player_link != "" && is_dir("../".$player_link)) rrmdir("../".$player_link);

            $query = "UPDATE juegos SET borrado = TRUE, es_publico = FALSE WHERE id = ?";
            db::mysqliExecuteQuery( $query, "s", array($_GET["id"]));

            
            
            session::info_message("Se ha eliminado correctamente el juego", "success");
        }
    }
}catch(Exception $exc){
    $output["error"] = "error";
}

header("Location: ../profile_info.php");
?>