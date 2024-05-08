<?php
    $navSelection = 1;
    include("include/header.php");
    if(isset($_GET["id"])){
        $id = $_GET["id"];

        $query = "SELECT IFNULL(SUM(`like`),0) AS likes, foto_perfil, juegos.id as id, nombre as autor, id_desarrollador, titulo, descripcion, link_archivo_juego, link_descarga, es_publico, vistas  
        FROM juegos 
        INNER JOIN usuarios ON juegos.id_desarrollador = usuarios.id
        LEFT JOIN usuarios_ven_juegos on id_juego = juegos.id
        WHERE juegos.id = ? 
        AND juegos.borrado = FALSE 
        AND juegos.es_publico = TRUE 
        AND usuarios.borrado = FALSE
        GROUP BY juegos.id";
        $data = mysqli_fetch_assoc(db::mysqliExecuteQuery($conn, $query, "s", array($id)));

        $query = "SELECT plataforma FROM plataformas_juegos WHERE id_juego = ?";
        $plataformas = db::mysqliExecuteQuery($conn, $query, "s", array($id));
        

        $query = "SELECT link_captura FROM capturas_pantalla WHERE id_juego = ?";
        $capturas = db::mysqliExecuteQuery($conn, $query, "s", array($id));

        if(logged){
            $query = "CALL select_usuarios_ven_juegos (?, ?)";
            $visualizacion = mysqli_fetch_assoc(db::mysqliExecuteQuery($conn, $query, "ii", array($userId, $id)));
        }

        $query = "SELECT fecha, texto, nombre, foto_perfil 
        FROM comentarios INNER JOIN usuarios ON comentarios.id_usuario = usuarios.id WHERE id_juego = ?
        ORDER BY
            CASE
                WHEN id_usuario = '$userId' THEN 0
                ELSE 1
            END, fecha DESC";
        $comentarios = db::mysqliExecuteQuery($conn, $query, "s", array($id));


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
        <h3 class="mt-2">Descripción:</h3>

        <p><?=$data["descripcion"]?></p>
        <div class="splide" id="screenshot-scroller">
            <div class="splide__arrows">
                <button class="splide__arrow splide__arrow--prev">
                    <i class="btn btn-primary rounded-circle fa-solid fa-arrow-left p-1"></i>
                </button>
                <button class="splide__arrow splide__arrow--next">

                    <i class="btn btn-primary rounded-circle fa-solid fa-arrow-right p-1"></i>
                </button>
            </div>
            <div class="splide__track">
                <ul class="splide__list">
                <?php
                while($capt = mysqli_fetch_assoc($capturas)){
                    ?>
                        <li class="splide__slide rounded-5 overflow-hidden">
                            <img src="<?=$capt["link_captura"]?>">
                        </li>
                    <?php
                }
                ?>
                </ul>
            </div>
        </div>
        
        <br>
        
        <h4>Autor:</h4>
        <div class="d-flex flex-wrap justify-content-between">
            <a class="fw-bold text-reset text-decoration-none" href="profile_info.php?id=<?=$data["id_desarrollador"]?>">
                <img src="<?=$data["foto_perfil"]== "" ? default_profile_icon : $data["foto_perfil"]?>" width="40" height="40">
                <?=$data["autor"]?>
            </a>
            <form action="php_tasks/comment.php?like=1" method = "post">
                <input type="hidden" name="id_usuario" value="<?=$userId?>">
                <input type="hidden" name="id_juego" value="<?=$id?>">
                <div class="btn-group" role="group">
                    <button class="btn btn-outline-primary rounded-start-5 <?php if ($visualizacion["like"] == 1) echo "active" ?>">
                        <i class="fa-solid fa-thumbs-up"></i>
                        <?=$data["likes"]?>
                    </button>
                        
                    
                    <button type="button" class="btn btn-outline-success rounded-end-5"  href="#">
                        Compartir <i class="fa-solid fa-share"></i>
                    </button>
                    
                </div>
            </form>
        </div>
        <br>
        <h4>Comentarios: </h4>

        <form action="php_tasks/comment.php?" method="post">
            
            <input type="hidden" name="id_usuario" value="<?=$userId?>">
            <input type="hidden" name="id_juego" value="<?=$id?>">
            <textarea id="comentario-textarea" name="texto" class="form-control" placeholder="Escribe un comentario aquí..."></textarea>
            
            <div class="mt-3 d-flex gap-2 justify-content-end">
                <button type="button" class="btn rounded-5" onclick='document.querySelector("#comentario-textarea").value = ""'>Cancelar</button>
                <button class="btn btn-primary rounded-5" <?php if(!logged) echo 'type="button" data-bs-toggle="modal" data-bs-target="#loginModal"'?>><?php if(logged) echo "Comentar"; else echo "Iniciar sesión para comentar";?></button>
            </div>
        </form>
        <!---Comentarios--->
        <div class="d-flex flex-wrap gap-3">
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
        </div>
        
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