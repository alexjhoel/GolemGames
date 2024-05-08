<?php
$navSelection = 0;
include ("include/header.php");

$gameCardObject = new GameCards();

$maxRows = 12;

$query = "SELECT 
    juegos.id as id, 
    titulo, 
    usuarios.nombre as nombre_usuario,
    IFNULL(GROUP_CONCAT(link_captura SEPARATOR ', '),'') as capturas, 
    IFNULL(SUM(`like`), 0) as likes, 
    IFNULL(COUNT(usuarios_ven_juegos.id_juego),0) as visitas
    FROM juegos
    INNER JOIN juegos_destacados ON juegos.id = juegos_destacados.id_juego 
    INNER JOIN usuarios ON juegos.id_desarrollador = usuarios.id
    LEFT JOIN usuarios_ven_juegos ON juegos.id = usuarios_ven_juegos.id_juego
    LEFT JOIN capturas_pantalla ON juegos.id = capturas_pantalla.id_juego
    WHERE juegos.borrado = FALSE
    GROUP BY juegos.id
    ORDER BY capturas_pantalla.id asc 
    LIMIT 0, $maxRows";

$destacados = db::mysqliExecuteQuery(
        $conn,
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
        <form action="" method="get">
            <div class="input-group rounded-5 shadow-sm bg-body overflow-hidden">
                <input type="text" class="form-control rounded-start border-0 shadow-none fs-5"
                    placeholder="¡Buscar entre cientos de juegos!" />
                <button type="button" class="btn border-0" data-bs-toggle="collapse" data-bs-target="#search-filters">
                    <i class="fas fa-sliders"></i>
                </button>
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
                style="background-image: url(https://articles-images.sftcdn.net/wp-content/uploads/sites/2/2018/02/android-accion.jpg);"
                href="">
                <h5 class="rounded-5 bg-body p-1">Acción</h5>
            </a>
            <div class="row col-6 col-sm-4 col-md-3 gap-2">
                <a class="rounded-5 col-12 d-flex align-items-end btn img-background"
                    style="background-image: url(https://blog.uptodown.com/wp-content/uploads/mejores-juegos-carreras-android.jpg);"
                    href="">
                    <h5 class="rounded-5 bg-body p-1">Carreras</h5>
                </a>
                <a class="rounded-5 col-12 d-flex align-items-end btn img-background"
                    style="background-image: url(https://offloadmedia.feverup.com/madridsecreto.co/wp-content/uploads/2022/10/27170504/arcade-bar-malasana-Credito-editorial_-Atmosphere1-_-Shutterstock.com_-1024x683.jpg);"
                    href="">
                    <h5 class="rounded-5 bg-body p-1">Arcade</h5>
                </a>
            </div>
            <a class="rounded-5 d-none d-sm-flex col-4 col-md-3 align-items-end btn img-background"
                style="background-image: url(https://cdn01.x-plarium.com/browser/content/blog/common/widget/mobile/raid_aside.webp);"
                href="">
                <h5 class="rounded-5 bg-body p-1">Juegos de rol</h5>
            </a>
            <a class="rounded-5 col-3 d-none d-md-flex align-items-end btn img-background"
                style="background-image: url(https://phantom-elmundo.unidadeditorial.es/647dfec588ecbc704118394a2da06a54/crop/153x0/759x404/resize/414/f/jpg/assets/multimedia/imagenes/2020/03/30/15855939110237.jpg);"
                href="">
                <h5 class="rounded-5 bg-body p-1">Aventura</h5>
            </a>
        </div>
    </section>

    <!--Juegos populares--->
    <section class="text-start py-2 d-flex flex-column">
        <h3><i class="fas fa-star fa-sm"></i> Destacados</h3>

        <?php
        $scroller = new GamesScroller();

        foreach ($destacados as $destData) {
            $gameCardObject->id = $destData["id"];
            $gameCardObject->titulo = $destData["titulo"];
            $gameCardObject->autor = $destData["nombre_usuario"];
            $gameCardObject->vistas = $destData["visitas"];
            $gameCardObject->likes = $destData["likes"];
            $gameCardObject->linksCapturas = explode(", ", $destData["capturas"]);

            $scroller->addGame($gameCardObject);
        }

        
        $scroller->echo();
        ?>
    </section>


    <!--Mejores juegos--->
    <section class="text-start py-2">
        <h3><i class="fas fa-medal fa-sm"></i> Los mejores</h3>
        <?php
        $scroller = new GamesScroller();

        for ($i = 1; $i < 10; $i++) {
            $gameCardObject = new GameCards();
            $gameCardObject->id = $i;
            $gameCardObject->titulo = "Juego de ejemplo #" . $i;
            $gameCardObject->autor = "Por juegos sosa" . $i;
            $gameCardObject->vistas = 999;
            $gameCardObject->likes = 999;
            $gameCardObject->linksCapturas = array("https://img.freepik.com/foto-gratis/equipo-videojuegos-futurista-iluminado-ia-generativa-discoteca_188544-32105.jpg?size=626&ext=jpg&ga=GA1.1.1880011253.1700524800&semt=ais");

            $scroller->addGame($gameCardObject);
        }

        
        $scroller->echo();
        ?>
    </section>

    <!--Ultimos populares--->
    <section class="text-start py-2">
        <h3><i class="fas fa-clock-rotate-left fa-sm"></i> Últimos lanzamientos</h3>
        <?php
        $scroller = new GamesScroller();

        for ($i = 1; $i < 10; $i++) {
            $gameCardObject = new GameCards();
            $gameCardObject->id = $i;
            $gameCardObject->titulo = "Juego de ejemplo #" . $i;
            $gameCardObject->autor = "Por juegos sosa" . $i;
            $gameCardObject->vistas = 999;
            $gameCardObject->likes = 999;
            $gameCardObject->linksCapturas = array("https://img.freepik.com/foto-gratis/equipo-videojuegos-futurista-iluminado-ia-generativa-discoteca_188544-32105.jpg?size=626&ext=jpg&ga=GA1.1.1880011253.1700524800&semt=ais");

            $scroller->addGame($gameCardObject);
        }

        
        $scroller->echo();
        ?>
    </section>

</article>

<?php
include ("include/footer.php");
?>