<?php
    /**Constante que almacena el link para la imagen por defecto de perfil*/
    define("default_profile_icon","./assets/images/default_profile_icon.png");

    /**Constante que indica el maximo tamaño de las capturas de pantalla en MB*/
    define("MAX_GAME_SCREENSOT_SIZE", 10);
    /**Constante que indica el maximo tamaño ancho de las capturas de pantalla en PX*/
    define("MAX_GAME_SCREENSOT_WIDTH", 1024);
    /**Constante que indica el maximo tamaño alto de las capturas de pantalla en PX*/
    define("MAX_GAME_SCREENSOT_HEIGHT", 720);
    /**Constante que indica el maximo tamaño de los archivos de descarga de juegos en MB*/
    define("MAX_GAME_DOWNLOAD_FILE_SIZE", 250);
    /**Constante que indica el maximo tamaño de ancho y largo de las fotos de perfil en PX*/
    define("MAX_PROFILE_PICTURE_LENGTH", 1024);
    /**Constante que indica el maximo tamaño de las fotos de perfil en MB*/
    define("MAX_PROFILE_PICTURE_SIZE", 10);
    /**Constante de conversión de bytes a MB*/
    define("BYTE_TO_MB", 0.00000095367432);

    
     define("LOGGED_REQUIRED", 1);
     define("DEVELOPER_REQUIRED", 2);
     define("MODERATOR_REQUIRED", 3);
     define("ADMIN_REQUIRED", 4);

     define("MAX_CHAT_LOAD", 40);


    function haceTiempo($date) {
        $timestamp = strtotime($date);	
        
        $strTime = array("segundo", "minuto", "hora", "día", "mes", "año");
        $length = array("60","60","24","30","12","10");
 
        $currentTime = time();
        if($currentTime >= $timestamp) {
             $diff     = time()- $timestamp;
             for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
             $diff = $diff / $length[$i];
             }
 
             $diff = round($diff);
             return $diff . " " . $strTime[$i] . "(s)";
        }
     }
     /**Returns true if is set the POST value referenced by index*/
     function is_POST_set(String $index):Bool{
          return isset($_POST[$index]);
     }
     /**Returns true if the POST values referenced by the indexes Array are set*/
     function are_POST_set(Array $indexes):Bool{
          $result = true;
          foreach($indexes as $i){
               $result = $result && is_POST_set($i);
          }
          return $result;
     }
     /**Returns true if is set the GET value referenced by index*/
     function is_GET_set(String $index):Bool{
          return isset($_GET[$index]);
     }
     /**Returns true if the GET values referenced by the indexes Array are set*/
     function are_GET_set(Array $indexes):Bool{
          $result = true;
          foreach($indexes as $i){
               $result = $result && is_GET_set($i);
          }
          return $result;
     }

     function is_FILE_set(string $index):Bool{
          return isset($_FILES[$index]);
     }

     /**Remueve un directorio y sus archivos */
     function rrmdir($src) {
          $dir = opendir($src);
          while(false !== ( $file = readdir($dir)) ) {
          if (( $file != '.' ) && ( $file != '..' )) {
               $full = $src . '/' . $file;
               if ( is_dir($full) ) {
                    rrmdir($full);
               }
               else {
                    unlink($full);
               }
          }
          }
          closedir($dir);
          rmdir($src);
     }
 
?>