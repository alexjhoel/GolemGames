<?php
include("connect.php");

//Clase de Criptografía
//Para encriptar y desencriptar
class criptografia
{

  //Opciones de encriptación y desencriptación
  public static $ciphering;
  public static $encryption_key;
  public static $options;
  public static $encryption_iv;

  //Genera un string encriptado con OpenSSL
  public static function encriptar($src)
  {
    return openssl_encrypt(
      $src,
      criptografia::$ciphering,
      criptografia::$encryption_key,
      criptografia::$options,
      criptografia::$encryption_iv
    );
  }
  //Desencripta un string generado con OpenSSL
  public static function desencriptar(String $src)
  {
    return openssl_decrypt(
      $src,
      criptografia::$ciphering,
      criptografia::$encryption_key,
      criptografia::$options,
      criptografia::$encryption_iv
    );
  }

}

//Opciones globales de encriptación

criptografia::$ciphering = "AES-128-CTR";
criptografia::$options = 0;
criptografia::$encryption_iv = '1234567891011121';

//Clave de encriptación
criptografia::$encryption_key = 'GMKey3sINLfp21F';


//Manejo de session
//Especificación de session: Los identificadores y valores son encriptados con
//la clase Criptografía

session_start();

//Clase para guardar y obtener datos de session
class session{

  public static function is_set($id){
    return isset($_SESSION[criptografia::encriptar($id)]);
  }

  //Establecer valor dado por $val en el campo $id
  public static function set($id, $val){
    $_SESSION[criptografia::encriptar($id)] = criptografia::encriptar($val);
  }

  //Obtener el valor en el campo $id
  public static function get($id){
    try{
      $val = criptografia::desencriptar($_SESSION[criptografia::encriptar($id)]);
      return $val;
    }catch(Exception $exc){
      return NULL;
    }
  }

  public static function unset($id){
    unset($_SESSION[criptografia::encriptar($id)]);
  }

  public static function info_message($text, $type){
    session::set("message", "$text");
    session::set("message_type", "$type");
  }
}

define("logged", session::is_set("id_usuario") && session::is_set("token") && mysqli_num_rows(db::mysqliExecuteQuery( "SELECT token FROM usuarios WHERE id=? AND token=? AND borrado = FALSE", "ss", array(session::get("id_usuario"), session::get("token")))) == 1);
if (logged) {
  define("userId", session::get("id_usuario"));
  $userData = mysqli_fetch_assoc(db::mysqliExecuteQuery( "SELECT token, nombre, correo_electronico, nivel_acceso FROM usuarios WHERE id=?", "s", array(userId)));
  define("username", $userData["nombre"]);
  define("email", $userData["correo_electronico"]);
  define("access_level", $userData["nivel_acceso"]);
  define("token", $userData["token"]);
}