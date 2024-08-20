<?php
    $navSelection = 1;
    include("include/header.php");
    $maxPages = 10;
    $page = 1;
    $maxCategorias = 10;

    $gameCardObject = new GameCards();
    $searchQuery = "";
    if(isset($_GET["search"]) && $_GET["search"]!=''){
        $searchValue = $_GET["search"];
        $searchQuery .= " AND titulo LIKE '%$searchValue%' ";
    }
    if(isset($_GET["categoria"]) && is_numeric($_GET["categoria"]) && $_GET["categoria"] > 0){
        if($cat = mysqli_fetch_assoc(db::mysqliExecuteQuery( "SELECT * FROM categorias WHERE id = ".$_GET["categoria"]." AND borrado = FALSE", "", array()))){
            $idCategoria = $_GET["categoria"];
            $nombreCategoria = $cat["nombre"];
            $searchQuery .= " AND $idCategoria IN (SELECT id_categoria FROM juegos_pertenecen_categoria WHERE id_juego = juegos.id)";
        }
    }
    if(isset($_GET["desarrollador"]) && $_GET["desarrollador"]!=''){
        $desarrolladorValue = $_GET["desarrollador"];
        $searchQuery .= " AND nombre LIKE '%$desarrolladorValue%'";
    }

    $ordersQueries = array(
        "fecha DESC",
        "likes DESC",
        "visitas DESC",
        "titulo ASC"
    );

    $orderSelection = 0;
    if(isset($_GET["order"]) && is_numeric($_GET["order"]) && $_GET["order"] >= 0 && $_GET["order"] <= 3){
        $orderSelection = $_GET["order"];
    }

    $orderQuery = $ordersQueries[$orderSelection];

    $maxEntries = 12;
    $total = mysqli_fetch_all(db::mysqliExecuteQuery(
        "SELECT COUNT(juegos.id) as total 
        FROM juegos INNER JOIN usuarios ON juegos.id_desarrollador = usuarios.id 
        WHERE juegos.borrado = FALSE AND juegos.es_publico = TRUE AND usuarios.borrado = FALSE  AND es_publico = TRUE$searchQuery",
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
    LEFT JOIN capturas_pantalla ON juegos.id = capturas_pantalla.id_juego AND capturas_pantalla.borrado = FALSE
    WHERE juegos.borrado = FALSE AND juegos.es_publico = TRUE AND usuarios.borrado = FALSE AND es_publico = TRUE $searchQuery
    GROUP BY juegos.id
    ORDER BY $orderQuery
    LIMIT $start,$maxEntries";

    $data = db::mysqliExecuteQuery(
        $query,
        "s",
        array()
    );

    $query = "SELECT id, nombre FROM categorias WHERE borrado = FALSE";

    $categorias = db::mysqliExecuteQuery(
        $query,
        "s",
        array()
    );

    $catMostrar = array();



    function closeLink($name){
        $values = array(
            "search" => isset($GLOBALS['searchValue']) ? urlencode($GLOBALS['searchValue']) : NULL,
            "categoria" => isset($GLOBALS['idCategoria']) ? urlencode($GLOBALS['idCategoria']) : NULL,
            "desarrollador" => isset($GLOBALS['desarrolladorValue']) ? urlencode($GLOBALS['desarrolladorValue']) : NULL
        );
        $res = "";

        foreach ($values as $key => $value) {
            if(isset($value) && $name != $key)$res .= "$key=$value&";
        }

        $res.= "order=".$GLOBALS['orderSelection'];

        return $res;

    }

?>

<article class="container px-4 px-md-5 py-3 text-center d-flex flex-column gap-2">

    <!--Barra de busqueda de home--->
    <section class="mx-2 mx-lg-5 px-2 px-lg-5">
        <form id="games-search" method="get">
            <div class="input-group rounded-5 shadow-sm bg-body overflow-hidden">
                <input type="text" name="search" <?php if(isset($searchValue)) echo("value='$searchValue'"); ?> class="form-control rounded-start border-0 shadow-none fs-5" placeholder="Buscar entre cientos de juegos!" />
                <button type="button" class="btn border-0" onclick="window.location.href = 'games.php';">
                    <i class="fas fa-eraser"></i>
                </button>
                <button type="button" class="btn border-0" data-bs-toggle="collapse" data-bs-target="#search-filters">
                    <i class="fas fa-sliders"></i>
                </button>
                <button type="submit" class="btn btn-primary border-0">
                    <i class="fas fa-search"></i>
                </button>

                <div class="collapse w-100" id="search-filters">
                    <div class="container">
                        <div class="form-floating my-3 ">
                            <input name="desarrollador" type="text" class="form-control rounded-5" id="developerInput" value="<?= isset($_GET["desarrollador"]) ? $_GET["desarrollador"] : ""?>">
                            <label for="developerInput">Desarrollador</label>
                        </div>
                        
                        <div class="form-floating">
                            <select name="categoria" class="form-select rounded-5 mb-3" id="floatingSelect" aria-label="Floating label select example">
                                <option value="0" <?= !isset($idCategoria) ? "selected" : ""?>>Seleccione categoría</option>
                                <?php while(($cat = mysqli_fetch_assoc($categorias))){  if(count($catMostrar) < $maxCategorias) 
                                    array_push($catMostrar, $cat);?>
                                    <option value="<?=$cat["id"]?>" <?= isset($idCategoria) && $idCategoria == $cat["id"] ? "selected" : ""?>><?=$cat["nombre"]?></option>
                                <?php }?>
                            </select>
                            <label for="floatingSelect">Categoría</label>
                        </div>
                        <div>
                        </div>

                        
                        <div class="form-floating">
                            <select name="order" class="form-select rounded-5" id="floatingSelect" aria-label="Floating label select example">
                                <option value="0" <?= !is_GET_set("order") || $_GET["order"] == 0 ? "selected" : ""?>>Fecha</option>
                                <option value="1" <?= is_GET_set("order") && $_GET["order"] == 1 ? "selected" : ""?>>Likes</option>
                                <option value="2" <?= is_GET_set("order") && $_GET["order"] == 2 ? "selected" : ""?>>Visitas</option>
                                <option value="3" <?= is_GET_set("order") && $_GET["order"] == 3 ? "selected" : ""?>>Título</option>
                            </select>
                            <label for="floatingSelect">Ordenar por:</label>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </section>

    <section class="d-flex justify-content-start gap-2">
        <?php
        if(isset($desarrolladorValue)){?>
            <span class="btn btn-primary rounded-5 shadow-sm"><a href="?<?=closeLink("desarrollador") ?>"><i class="fa-solid fa-x"></i></a>&nbsp;<i class="fa-solid fa-user"></i>&nbsp;<?=$desarrolladorValue?></span>
        <?php }?>
        <?php
        if(isset($idCategoria)){?>
            <span class="btn btn-primary rounded-5 shadow-sm"><a href="?<?=closeLink("categoria") ?>"><i class="fa-solid fa-x text-light"></i></a>&nbsp;<?=$nombreCategoria?></span>
        <?php } else if(!isset($desarrolladorValue))
            foreach($catMostrar as $cat){ ?>
                <button form="games-search" name="categoria" value="<?=$cat["id"]?>" class="btn btn-primary rounded-5 shadow-sm"><?=$cat["nombre"]?></button>
            <?php }?>
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
                $gameCardObject->linksCapturas = $juego["capturas"];
                
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