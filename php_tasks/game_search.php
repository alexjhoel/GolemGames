<?php $searchQuery = "AND true";
$searchValue = "";
if(isset($_GET["search"])){
    $searchValue = $_GET["search"];
    $searchQuery = "AND CONCAT(nombre,' ', apellido) LIKE '%$searchValue%'";
}

$ordersQueries = array(
    "nombre ASC",
    "nombre DESC",
    "ult_visita ASC",
    "ult_visita DESC",
    "deuda DESC",
);

$orderSelection = 0;
if(isset($_GET["order"])){
    $orderSelection = $_GET["order"];
}

$orderQuery = $ordersQueries[$orderSelection];

$maxRows = 7;
$total = mysqli_fetch_all(db::mysqliExecuteQuery(
    $conn,
    "SELECT COUNT(id_cliente) as total FROM clientes WHERE clientes.borrado = FALSE $searchQuery",
    "",
    array()
), MYSQLI_ASSOC)[0]["total"];

$maxPages = ceil($total / $maxRows);
$page = max(min(isset($_GET["page"]) ? $_GET["page"] : 1, $maxPages),1);
$start = $maxRows * ($page - 1);
$data = mysqli_fetch_all(db::mysqliExecuteQuery(
    $conn,
    "SELECT id_cliente, 
        CONCAT(nombre,' ', apellido) as nombre, 
        IFNULL(DATE_FORMAT(MAX(fecha),'%d/%m/%Y'),'Sin visitas') as ult_visita, 
        FLOOR(IFNULL(SUM(cobro) - SUM(pago),0)) as deuda 
        FROM clientes LEFT JOIN (SELECT * FROM visitas WHERE visitas.borrado = FALSE) as visitas 
        ON id_cliente_visita = id_cliente
        WHERE clientes.borrado = FALSE $searchQuery
        GROUP BY id_cliente
        ORDER BY $orderQuery 
        LIMIT $start, $maxRows",
    "",
    array()
), MYSQLI_ASSOC);
?>