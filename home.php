<?php
$navSelection = 0;
include ("include/header.php");

$gameCardObject = new GameCards();

$maxRows = 12;

$query = "SELECT orden, id_categoria, link_imagen, nombre 
FROM categorias_destacadas 
INNER JOIN categorias 
ON id_categoria = id 
WHERE orden >= 1 AND orden <= 5 
ORDER BY orden ASC";

$popular_cats = mysqli_fetch_all(db::mysqliExecuteQuery($query, "", array()), MYSQLI_ASSOC);

$query = "SELECT 
juegos.id as id, 
titulo, 
usuarios.nombre as nombre_usuario,
IFNULL(GROUP_CONCAT(link_captura ORDER BY capturas_pantalla.id ASC SEPARATOR ', '),'') as capturas, 
IFNULL((SELECT SUM(`like`) FROM usuarios_ven_juegos as A WHERE A.id_juego = juegos.id GROUP BY A.id_juego), 0) as likes, 
IFNULL((SELECT COUNT(DISTINCT(A.id_usuario)) FROM usuarios_ven_juegos as A WHERE A.id_juego = juegos.id GROUP BY A.id_juego), 0) as visitas
FROM juegos
INNER JOIN juegos_destacados ON juegos.id = juegos_destacados.id_juego 
INNER JOIN usuarios ON juegos.id_desarrollador = usuarios.id
LEFT JOIN capturas_pantalla ON juegos.id = capturas_pantalla.id_juego AND capturas_pantalla.borrado = FALSE
WHERE juegos.borrado = FALSE AND usuarios.borrado = FALSE AND juegos_destacados.borrado = FALSE AND es_publico = TRUE
GROUP BY juegos.id
LIMIT 0, $maxRows";

$destacados = db::mysqliExecuteQuery(
    $query,
    "",
    array()
);

$query = "SELECT 
juegos.id as id, 
titulo, 
usuarios.nombre as nombre_usuario,
IFNULL(GROUP_CONCAT(link_captura ORDER BY capturas_pantalla.id ASC SEPARATOR ', '),'') as capturas, 
IFNULL((SELECT SUM(`like`) FROM usuarios_ven_juegos as A WHERE A.id_juego = juegos.id GROUP BY A.id_juego), 0) as likes, 
IFNULL((SELECT COUNT(DISTINCT(A.id_usuario)) FROM usuarios_ven_juegos as A WHERE A.id_juego = juegos.id GROUP BY A.id_juego), 0) as visitas
FROM juegos
INNER JOIN usuarios ON juegos.id_desarrollador = usuarios.id
LEFT JOIN capturas_pantalla ON juegos.id = capturas_pantalla.id_juego AND capturas_pantalla.borrado = FALSE
WHERE juegos.borrado = FALSE AND usuarios.borrado = FALSE AND es_publico = TRUE
GROUP BY juegos.id
ORDER BY likes desc
LIMIT 0, $maxRows";

$mejores = db::mysqliExecuteQuery(
    $query,
    "",
    array()
);

$query = "SELECT 
    juegos.id as id, 
    titulo, 
    usuarios.nombre as nombre_usuario,
    IFNULL(GROUP_CONCAT(link_captura ORDER BY capturas_pantalla.id ASC SEPARATOR ', '),'') as capturas, 
    IFNULL((SELECT SUM(`like`) FROM usuarios_ven_juegos as A WHERE A.id_juego = juegos.id GROUP BY A.id_juego), 0) as likes, 
    IFNULL((SELECT COUNT(DISTINCT(A.id_usuario)) FROM usuarios_ven_juegos as A WHERE A.id_juego = juegos.id GROUP BY A.id_juego), 0) as visitas
    FROM juegos
    INNER JOIN usuarios ON juegos.id_desarrollador = usuarios.id
    LEFT JOIN capturas_pantalla ON juegos.id = capturas_pantalla.id_juego AND capturas_pantalla.borrado = FALSE AND es_publico = TRUE
    WHERE juegos.borrado = FALSE AND usuarios.borrado = FALSE AND juegos.es_publico = TRUE
    GROUP BY juegos.id
    ORDER BY juegos.fecha desc
    LIMIT 0, $maxRows";

$ultimos = db::mysqliExecuteQuery(
    $query,
    "",
    array()
);

?>

<article class="container px-4 px-md-5 py-3 text-center">
    <!--Banner de home--->
    <section class="row p-5 shadow-sm align-items-center text-black rounded-5 img-background"
        style="background-image: linear-gradient(rgba(255,255,255,0.5), rgba(255,255,255,0.5)), url(https://images.unsplash.com/photo-1606160429008-751d8408a874?q=80&w=1000&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8N3x8cHM1JTIwY29udHJvbGxlcnxlbnwwfHwwfHx8MA%3D%3D)">
        <h3 class="mt-5"><strong>Encuentra tu juego favorito en Golem Games</strong></h2>
            <p class="mb-5">Descubre los mejores proyectos de videojuegos creados por la comunidad</p>
    </section>

    <!--Barra de busqueda de home--->
    <section class="mx-2 mx-lg-5 px-2 px-lg-5 py-1 home-search-bar">
        <form action="games.php" method="get">
            <div class="input-group rounded-5 shadow-sm bg-body overflow-hidden">
                <input type="text" name="search" class="form-control rounded-start border-0 shadow-none fs-5"
                    placeholder="¡Buscar entre cientos de juegos!" />
                <button type="submit" class="btn btn-primary border-0">
                    <i class="fas fa-search"></i>
                </button>

                <div class="collapse" id="search-filters">
                    <div class="container">
                        Some placeholder content for the collapse component. This panel is hidden by default but
                        revealed when the user activates the relevant trigger.
                    </div>
                </div>
            </div>
        </form>
    </section>

    <!--Categorias populares--->
    <section class="text-start py-2">
        <h3 class="ml-0"><i class="fas fa-star fa-sm"></i> Categorías populares</h3>
        <div class="row gap-2" style="height:300px">
            <a class="rounded-5 col-6 col-sm-4 col-md-3 d-flex align-items-end btn img-background"
                style="background-image: url(<?=$popular_cats[0]["link_imagen"]?>?t=<?=time()?>);"
                href="games.php?categoria=<?=$popular_cats[0]["id_categoria"]?>">
                <h5 class="rounded-5 bg-body p-1"><?=$popular_cats[0]["nombre"]?></h5>
            </a>
            <div class="row col-6 col-sm-4 col-md-3 gap-2">
                <a class="rounded-5 col-12 d-flex align-items-end btn img-background"
                    style="background-image: url(<?=$popular_cats[1]["link_imagen"]?>?t=<?=time()?>);"
                    href="games.php?categoria=<?=$popular_cats[1]["id_categoria"]?>">
                    <h5 class="rounded-5 bg-body p-1"><?=$popular_cats[1]["nombre"]?></h5>
                </a>
                <a class="rounded-5 col-12 d-flex align-items-end btn img-background"
                    style="background-image: url(<?=$popular_cats[2]["link_imagen"]?>?t=<?=time()?>);"
                    href="games.php?categoria=<?=$popular_cats[2]["id_categoria"]?>">
                    <h5 class="rounded-5 bg-body p-1"><?=$popular_cats[2]["nombre"]?></h5>
                </a>
            </div>
            <a class="rounded-5 d-none d-sm-flex col-4 col-md-3 align-items-end btn img-background"
                style="background-image: url(<?=$popular_cats[3]["link_imagen"]?>?t=<?=time()?>);"
                href="games.php?categoria=<?=$popular_cats[3]["id_categoria"]?>">
                <h5 class="rounded-5 bg-body p-1"><?=$popular_cats[3]["nombre"]?></h5>
            </a>
            <a class="rounded-5 col-3 d-none d-md-flex align-items-end btn img-background"
                style="background-image: url(<?=$popular_cats[4]["link_imagen"]?>?t=<?=time()?>);"
                href="games.php?categoria=<?=$popular_cats[4]["id_categoria"]?>">
                <h5 class="rounded-5 bg-body p-1"><?=$popular_cats[4]["nombre"]?></h5>
            </a>
        </div>
    </section>

    <!--Juegos populares--->
    <section class="text-start py-2 d-flex flex-column">
        <h3><i class="fas fa-star fa-sm"></i> Destacados</h3>

        <?php
        $scroller = new GamesScroller();

        foreach ($destacados as $destData) {
            $gameCardObject = new GameCards;
            $gameCardObject->id = $destData["id"];
            $gameCardObject->titulo = $destData["titulo"];
            $gameCardObject->autor = $destData["nombre_usuario"];
            $gameCardObject->vistas = $destData["visitas"];
            $gameCardObject->likes = $destData["likes"];
            $gameCardObject->linksCapturas = $destData["capturas"];

            $scroller->addGame($gameCardObject);
        }


        $scroller->echo();
        ?>
    </section>


    <!--Mejores juegos--->
    <section class="text-start py-2 d-flex flex-column">
        <h3><i class="fas fa-medal fa-sm"></i> Los mejores</h3>
        <?php

        $scroller = new GamesScroller();

        while ($mejorData = mysqli_fetch_assoc($mejores)) {
            $gameCardObject = new GameCards;
            $gameCardObject->id = $mejorData["id"];
            $gameCardObject->titulo = $mejorData["titulo"];
            $gameCardObject->autor = $mejorData["nombre_usuario"];
            $gameCardObject->vistas = $mejorData["visitas"];
            $gameCardObject->likes = $mejorData["likes"];
            $gameCardObject->linksCapturas = $mejorData["capturas"];

            $scroller->addGame($gameCardObject);
        }


        $scroller->echo();
        ?>
    </section>

    <!--Ultimos populares--->
    <section class="text-start py-2 d-flex flex-column">
        <h3><i class="fas fa-clock-rotate-left fa-sm"></i> Últimos lanzamientos</h3>
        <?php

        $scroller = new GamesScroller();

        foreach ($ultimos as $ultimoData) {
            
            $gameCardObject = new GameCards;
            $gameCardObject->id = $ultimoData["id"];
            $gameCardObject->titulo = $ultimoData["titulo"];
            $gameCardObject->autor = $ultimoData["nombre_usuario"];
            $gameCardObject->vistas = $ultimoData["visitas"];
            $gameCardObject->likes = $ultimoData["likes"];
            $gameCardObject->linksCapturas = $ultimoData["capturas"];

            $scroller->addGame($gameCardObject);
        }


        $scroller->echo();
        ?>
    </section>

</article>



<?php 
include ("include/footer.php");
?>