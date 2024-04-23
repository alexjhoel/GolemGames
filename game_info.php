<?php
    $navSelection = 1;
    include("include/header.php");

    if(isset($_GET["id"])){
        $query = "SELECT foto_perfil, juegos.id, nombre as autor, id_desarrollador, titulo, descripcion, link_archivo_juego, link_descarga, es_publico, vistas  
        FROM juegos INNER JOIN usuarios ON juegos.id_desarrollador = usuarios.id
        WHERE juegos.id = ? AND juegos.borrado = FALSE AND juegos.es_publico = TRUE AND usuarios.borrado = FALSE";

        $data = mysqli_fetch_assoc(db::mysqliExecuteQuery($conn, $query, "s", array($_GET["id"])));
    }

    if(isset($_GET["id"])){
        $query = "SELECT juegos.id, IFNULL(SUM(`like`),0) as likes FROM juegos LEFT JOIN usuarios_ven_juegos on id_juego = id WHERE usuarios_ven_juegos.borrado = FALSE AND id_juego = ? GROUP BY juegos.id";

        $likes = mysqli_fetch_assoc(db::mysqliExecuteQuery($conn, $query, "s", array($_GET["id"])));
    }

    

    if(isset($_GET["id"])){
        $query = "SELECT plataforma FROM plataformas_juegos WHERE id_juego = ?";

        $plataformas = db::mysqliExecuteQuery($conn, $query, "s", array($_GET["id"]));
    }

    if(isset($_GET["id"])){
        $query = "SELECT link_captura FROM capturas_pantalla WHERE id_juego = ?";

        $capturas = db::mysqliExecuteQuery($conn, $query, "s", array($_GET["id"]));
    }

    if(isset($_GET["id"])){
        $query = "SELECT fecha, texto, nombre, foto_perfil 
        FROM comentarios INNER JOIN usuarios ON comentarios.id_usuario = usuarios.id WHERE id_juego = ?";

        $comentarios = db::mysqliExecuteQuery($conn, $query, "s", array($_GET["id"]));
    }
?>



<article class="container px-4 px-md-5 py-3 align-items-center d-flex flex-column gap-2">

    <h1><?=$data["titulo"]?></h1>

    <section class="d-flex flex-column gap-2 text-start align-self-center border rounded-5 p-4 container">

        <div class="d-flex flex-column justify-content-center">
            <div class="btn-group" role="group">
                <a type="button" class="btn btn-primary" style="border-radius:0px; border-top-left-radius:0.5rem;"  href="uploads/games/luigi-casino/index.html"><i class="fa-solid fa-play"></i>
                            Jugar en linea
                </a>
                <a type="button" class="btn btn-success" style="border-radius:0px; border-top-right-radius:0.5rem;" href="#"><i class="fa-solid fa-download"></i>
                            Descargar (XX MB)
                </a>
            </div>
            <div class="w-100 bg-secondary text-white text-end p-2 rounded-3 rounded-top-0">
                <?php
                while($plat = mysqli_fetch_assoc($plataformas)){
                    ?>
                        <i class="fa-brands fa-<?=$plat["plataforma"]?>"></i>
                    <?php
                }
                ?>
            </div>    
        </div>
        <p><?=$data["descripcion"]?></p>
        <h4>Capturas de pantalla:</h4>
        <div class="gap-1 d-flex flex-row align-items-center">
            <i class="btn btn-primary rounded-circle fa-solid fa-arrow-left p-1"></i>
            <div class="d-flex flex-row gap-2 overflow-x-scroll flex-grow-1 scroller pb-3 px-2" data-scrolling-value=238>
                <?php
                while($capt = mysqli_fetch_assoc($capturas)){
                    ?>
                        <img class="bg-body rounded-4 col-3"  src="<?=$capt["link_captura"]?>" style="width:230px">
                    <?php
                }
                ?>
            </div>
            <i class="btn btn-primary rounded-circle fa-solid fa-arrow-right p-1"></i>
        </div>
        
        <br>
        
        <h4>Autor:</h4>
        <div class="d-flex justify-content-between">
            <a class="fw-bold text-reset text-decoration-none" href="profile_info.php?id=<?=$data["id_desarrollador"]?>">
                <img src="<?=$data["foto_perfil"]== "" ? default_profile_icon : $data["foto_perfil"]?>" width="40" height="40">
                <?=$data["autor"]?>
            </a>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-primary rounded-start-5" href="uploads/games/luigi-casino/index.html">
                    <i class="fa-solid fa-thumbs-up"></i>
                    <?=$likes["likes"]?>
                </button>
                <button type="button" class="btn btn-outline-success rounded-end-5"  href="#">
                             Compartir <i class="fa-solid fa-share"></i>
                </button>
            </div>
        </div>
        <br>
        <h4>Comentarios: </h4>
        <div>
            <textarea class="form-control" placeholder="Escribe un comentario aquí..."></textarea>
        </div>
        <br>

        <!---Comentarios--->
        <?php
        while($coment = mysqli_fetch_assoc($comentarios)){
            ?>
            <div class="d-flex gap-2">
                <img src="<?=$data["foto_perfil"]== "" ? default_profile_icon : $data["foto_perfil"]?>" width="40" height="40">
                <div class="flex-grow-1">
                    <a class="text-reset fw-bold text-decoration-none" href="#"><?=$coment["nombre"]?></a>
                    <span class="text-secondary" style="font-size: small;">
                        • Hace 
                        <?=haceTiempo($coment["fecha"])?>
                    </span>
                    <br>

                    <span>
                    <?=$coment["texto"]?>
                    </span>
                    <!--
                    <div>
                        <i class="btn btn-lg  fa-solid fa-thumbs-up p-0 border-0" data-bs-toggle="button"></i>
                        <i class="btn btn-lg fa-solid fa-flag p-0 border-0" data-bs-toggle="button"></i>
                    </div>
                    -->
                </div>
            </div>
            <?php
        }
        ?>
        <!--
        
        <div class="d-flex gap-2">
            <div class="bg-white" style="width:40px; height:40px;"></div>
            <div class="flex-grow-1">
                <a class="placeholder-glow" href="#">
                <span class="placeholder col-7"></span>
                </a>
                <br>

                <span class="placeholder-glow">
                    <span class="placeholder col-7"></span>
                    <span class="placeholder col-4"></span>
                    <span class="placeholder col-4"></span>
                    <span class="placeholder col-6"></span>
                    <span class="placeholder col-8"></span>
                </span>
                <div>
                    <i class="btn btn-lg  fa-solid fa-thumbs-up p-0 border-0" data-bs-toggle="button"></i>
                    <i class="btn btn-lg fa-solid fa-flag p-0 border-0" data-bs-toggle="button"></i>
                </div>
            </div>
        </div>
        -->
        
    </section>
    
</article>

<?php
    include("include/footer.php");
?>