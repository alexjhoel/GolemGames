<?php
    $navSelection = 1;
    include("include/header.php");
    $maxPages = 10;
    $page = 1;

    $gameCardObject = new GameCards();
    $searchQuery = "";
    if(isset($_GET["search"]) && $_GET["search"]!=''){
        $searchValue = $_GET["search"];
        $searchWords = preg_replace('/\s+/','|' , $searchValue);
        $searchQuery = "AND (titulo REGEXP '$searchWords' OR nombre REGEXP '$searchWords')";
    }else if(isset($_GET["categoria"])){
        $idCategoria = $_GET["categoria"];
        $nombreCategoria = mysqli_fetch_assoc(db::mysqliExecuteQuery($conn, "SELECT * FROM categorias WHERE id = $idCategoria && borrado = FALSE", "", array()))["nombre"];
        $searchQuery = "AND $idCategoria IN (SELECT id_categoria FROM juegos_pertenecen_categoria WHERE id_juego = juegos.id)";
    }

    $ordersQueries = array(
        "vistas ASC, likes DESC",
        "likes ASC",
        "titulo ASC",
        "titulo DESC"
    );

    $orderSelection = 0;
    if(isset($_GET["order"])){
        $orderSelection = $_GET["order"];
    }

    $orderQuery = $ordersQueries[$orderSelection];

    $maxEntries = 12;
    $total = mysqli_fetch_all(db::mysqliExecuteQuery(
        $conn,
        "SELECT COUNT(juegos.id) as total 
        FROM juegos INNER JOIN usuarios ON juegos.id_desarrollador = usuarios.id 
        WHERE juegos.borrado = FALSE AND juegos.es_publico = TRUE AND usuarios.borrado = FALSE $searchQuery",
        "",
        array()
    ), MYSQLI_ASSOC)[0]["total"];

    $maxPages = ceil(($total) / $maxEntries);
    $page = max(min(isset($_GET["page"]) ? $_GET["page"] : 1, $maxPages),1);
    $start = $maxEntries * ($page - 1);

    $query = "SELECT juegos.id as id, titulo, usuarios.nombre as nombre_usuario,
    IFNULL(GROUP_CONCAT(link_captura ORDER BY capturas_pantalla.id ASC SEPARATOR ', '),'') as capturas, 
    IFNULL((SELECT SUM(`like`) FROM usuarios_ven_juegos as A WHERE A.id_juego = juegos.id GROUP BY A.id_juego), 0) as likes, 
    IFNULL((SELECT COUNT(DISTINCT(A.id_usuario)) FROM usuarios_ven_juegos as A WHERE A.id_juego = juegos.id GROUP BY A.id_juego), 0) as visitas
    FROM juegos INNER JOIN usuarios ON juegos.id_desarrollador = usuarios.id 
    LEFT JOIN capturas_pantalla ON juegos.id = capturas_pantalla.id_juego
    WHERE juegos.borrado = FALSE AND juegos.es_publico = TRUE AND usuarios.borrado = FALSE $searchQuery
    GROUP BY id
    ORDER BY $orderQuery
    LIMIT $start,$maxEntries";

    $data = db::mysqliExecuteQuery(
        $conn,
        $query,
        "s",
        array()
    );

    $query = "SELECT id, nombre FROM categorias WHERE borrado = FALSE";

    $categorias = db::mysqliExecuteQuery(
        $conn,
        $query,
        "s",
        array()
    );

?>

<article class="container px-4 px-md-5 py-3 text-center d-flex flex-column gap-2">

    <!--Barra de busqueda de home--->
    <section class="mx-2 mx-lg-5 px-2 px-lg-5">
        <form id="games-search" method="get">
            <div class="input-group rounded-5 shadow-sm bg-body overflow-hidden">
                <input type="text" name="search" <?php if(isset($searchValue)) echo("value='$searchValue'"); ?> class="form-control rounded-start border-0 shadow-none fs-5" placeholder="Buscar entre cientos de juegos!" />
                <button type="button" class="btn border-0" data-bs-toggle="collapse" data-bs-target="#search-filters">
                    <i class="fas fa-sliders"></i>
                </button>
                <button type="submit" class="btn btn-primary border-0">
                    <i class="fas fa-search"></i>
                </button>

                <div class="collapse w-100" id="search-filters">
                    <div class="container">
                        Hola_
                    </div>
                </div>
            </div>
        </form>
    </section>

    <section class="d-flex justify-content-start gap-2">
        <?php
        if(isset($idCategoria)){?>
            <span class="btn btn-primary rounded-5 shadow-sm"><a href="?"><i class="fa-solid fa-x"></i></a>&nbsp;<?=$nombreCategoria?></span>
        <?php }
        else if(!isset($searchValue))
            while($cat = mysqli_fetch_assoc($categorias)){?>
                <button form="games-search" name="categoria" value="<?=$cat["id"]?>" class="btn btn-primary rounded-5 shadow-sm"><?=$cat["nombre"]?></button>
            <?php }
        ?>
    </section>

    <section class="text-start align-self-center w-100">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-2">
            <!--Display de juegos--->
                
            <?php while ($juego = mysqli_fetch_assoc($data)) {

                $gameCardObject->id = $juego["id"];
                $gameCardObject->titulo = $juego["titulo"];
                $gameCardObject->autor = $juego["nombre_usuario"];
                $gameCardObject->vistas = $juego["visitas"];
                $gameCardObject->likes = $juego["likes"];
                $gameCardObject->linksCapturas = explode(", ", $juego["capturas"]);
                
                ?><div><?php
                $gameCardObject->echo();
                ?>
                </div>
                <?php }?>
            </div>
        </div>
    </section>
    
</article>

<nav class="container d-flex justify-content-center">
    <ul class="pagination justify-content-center shadow-sm " style="width:fit-content;">
        <li class="page-item   <?=$page < 2 ? 'disabled' : ''?>">
            <button type="submit" form="games-search" class="page-link border-0 rounded-start-pill" name="page" value=<?=$page - 1?>><i class="fa-solid fa-caret-left fa-xl"></i>&nbsp;</button>
        </li>
        <?php for ($i=1; $i < $maxPages + 1; $i++) { ?>
            <li class="page-item <?= $i==$page ? 'active' : '' ?>">
                <button type="submit" form="games-search" class="page-link border-0" name="page" value=<?=$i?>>
                    <?=$i?>
                </button>
            </li>
        <?php }?>
        <li class="page-item <?=$page < $maxPages ? '' : 'disabled'?>">
            <button type="submit" form="games-search" class="page-link border-0 rounded-end-circle" name="page" value=<?=$page + 1?>>&nbsp;<i class="fa-solid fa-caret-right fa-xl"></i></button>
        </li>
    </ul>
</nav>

<?php
    include("include/footer.php");
?>