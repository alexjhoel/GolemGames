<?php
    $host 	= '127.0.0.1';
    $nombre 	= 'golem_admin';
    $pass 	= 'ex^Z4]VOn52W';
    $db 	= 'golem_games';
    
    $conn = mysqli_connect(
      $host,
      $nombre,
      $pass,
      $db
    );

    if (!$conn || $conn->connect_error) 
    {
          die("Error en la conexión: " . mysqli_connect_error());
            
    }
    class db{
    
      public static function mysqliExecuteQuery($conn,$query, $paramsTypes, $params){
        
        
        $stmt = $conn -> prepare($query);

        if(count($params) > 0) $stmt->bind_param($paramsTypes, ...$params);

        $stmt -> execute();

        return $stmt->get_result();
      }
    }
    
?>
