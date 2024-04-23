<?php
    //Variable que almacena el link para la imagen por defecto de perfil
    define("default_profile_icon","./assets/images/default_profile_icon.png");

    function haceTiempo($date) {
        $timestamp = strtotime($date);	
        
        $strTime = array("segundo", "minuto", "hora", "dia", "mes", "año");
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
?>