<?php
//Clase para consultas de Base de Datos
class db{
  
  //Base de datos
  public static $conn;
  public static function mysqliExecuteQuery($query, $paramsTypes, $params)
  {
    $stmt = self::$conn->prepare($query);

    if (count($params) > 0) $stmt->bind_param($paramsTypes, ...$params);

    $stmt->execute();

    return $stmt->get_result();
  }
}

db::$conn = mysqli_connect(
  //Host
  'localhost',
  //Username
  'u612317551_golem_admin',
  //Password
  'QrzRQ3K8k]',
  //DB
  'u612317551_golem_games'
);
?>