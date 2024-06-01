<?php
//Base de datos

$conn = mysqli_connect(
  //Host
  '127.0.0.1',
  //Username
  'golem_admin',
  //Password
  'ex^Z4]VOn52W',
  //DB
  'golem_games'
);

if (!$conn || $conn->connect_error) {
  die("Error en la conexión: " . mysqli_connect_error());
}

//Clase para consultas de Base de Datos
class db{
  public static function mysqliExecuteQuery($conn, $query, $paramsTypes, $params)
  {
    $stmt = $conn->prepare($query);

    if (count($params) > 0) $stmt->bind_param($paramsTypes, ...$params);

    $stmt->execute();

    return $stmt->get_result();
  }
}

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

  public static function isSet($id){
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
}

define("logged", session::isSet("id_usuario"));
if (logged) {
  define("userId", session::get("id_usuario"));
  $result = db::mysqliExecuteQuery($conn, "SELECT nombre FROM usuarios WHERE id=?", "s", array(userId));
  define("username", mysqli_fetch_assoc($result)["nombre"]);
}
