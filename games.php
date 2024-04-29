<?php
    $navSelection = 1;
    include("include/header.php");
    $maxPages = 10;
    $page = 1;

    $gameCardObject = new GameCards();
    
    $searchQuery = "AND true";
    $searchValue = "";
    if(isset($_GET["search"])){
        $searchValue = $_GET["search"];
        $searchQuery = "AND CONCAT(titulo,' ', nombre) LIKE '%$searchValue%'";
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
        "SELECT COUNT(id) as total FROM juegos WHERE juegos.borrado = FALSE $searchQuery",
        "",
        array()
    ), MYSQLI_ASSOC)[0]["total"];

    $maxPages = ceil($total / $maxRows);
    $page = max(min(isset($_GET["page"]) ? $_GET["page"] : 1, $maxPages),1);
    $start = $maxRows * ($page - 1);

    $query = "SELECT 
    juegos.id as id, 
    titulo, 
    usuarios.nombre as nombre_usuario,
    IFNULL(GROUP_CONCAT(link_captura SEPARATOR ', '),'') as capturas, 
    IFNULL(SUM(`like`), 0) as likes, 
    IFNULL(COUNT(usuarios_ven_juegos.id_juego),0) as visitas
    FROM juegos 
    INNER JOIN usuarios ON juegos.id_desarrollador = usuarios.id
    LEFT JOIN usuarios_ven_juegos ON juegos.id = usuarios_ven_juegos.id_juego
    LEFT JOIN capturas_pantalla ON juegos.id = capturas_pantalla.id_juego
    WHERE juegos.borrado = FALSE $searchQuery
    GROUP BY juegos.id
    ORDER BY $orderQuery, capturas_pantalla.id asc 
    LIMIT $start, $maxRows";

    $data = db::mysqliExecuteQuery(
        $conn,
        $query,
        "s",
        array()
    );

?>

<article class="container px-4 px-md-5 py-3 text-center d-flex flex-column gap-2">

    <!--Barra de busqueda de home--->
    <section class="mx-2 mx-lg-5 px-2 px-lg-5">
        <form action="" method="get">
            <div class="input-group rounded-5 shadow-sm bg-body overflow-hidden">
                <input type="text" class="form-control rounded-start border-0 shadow-none fs-5" placeholder="Buscar entre cientos de juegos!" />
                <button type="button" class="btn border-0" data-bs-toggle="collapse" data-bs-target="#search-filters">
                    <i class="fas fa-sliders"></i>
                </button>
                <button type="submit" class="btn btn-primary border-0">
                    <i class="fas fa-search"></i>
                </button>

                <div class="collapse" id="search-filters">
                    <div class="container">
                    Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.
                    </div>
                </div>
            </div>
        </form>
    </section>

    <section class="text-start align-self-center">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-2">
            <!--Display de juegos--->
            <?php while ($juego = mysqli_fetch_assoc($data)) {

                $gameCardObject->id = $juego["id"];
                $gameCardObject->titulo = $juego["titulo"];
                $gameCardObject->autor = $juego["nombre_usuario"];
                $gameCardObject->vistas = $juego["visitas"];
                $gameCardObject->likes = $juego["likes"];
                $gameCardObject->linksCapturas = explode(", ", $juego["capturas"]);

                $gameCardObject->echo();
            }?>
        </div>
    </section>
    
</article>

<nav class="container d-flex justify-content-center">
    <ul class="pagination justify-content-center shadow-sm " style="width:fit-content;">
        <li class="page-item   <?=$page < 2 ? 'disabled' : ''?>">
            <button type="submit" form="clients-search" class="page-link border-0 rounded-start-pill" name="page" value=<?=$page - 1?>><i class="fa-solid fa-caret-left fa-xl"></i>&nbsp;</button>
        </li>
        <?php for ($i=1; $i < $maxPages + 1; $i++) { ?>
            <li class="page-item <?= $i==$page ? 'active' : '' ?>">
                <button type="submit" form="clients-search" class="page-link border-0" name="page" value=<?=$i?>>
                    <?=$i?>
                </button>
            </li>
        <?php }?>
        <li class="page-item <?=$page < $maxPages ? '' : 'disabled'?>">
            <button type="submit" form="clients-search" class="page-link border-0 rounded-end-circle" name="page" value=<?=$page + 1?>>&nbsp;<i class="fa-solid fa-caret-right fa-xl"></i></button>
        </li>
    </ul>
</nav>

<?php
    include("include/footer.php");
?>