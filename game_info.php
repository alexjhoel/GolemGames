<?php
$navSelection = 1;

include_once("include/connect_session.php");
include_once("include/definitions.php");

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    //Consulta de datos de juego, se guarda en $data
    $query = "SELECT IFNULL(SUM(`like`),0) AS likes, foto_perfil, juegos.id as id, nombre as autor, id_desarrollador, titulo, descripcion, link_archivo_juego, link_descarga, es_publico, vistas  
        FROM juegos 
        INNER JOIN usuarios ON juegos.id_desarrollador = usuarios.id
        LEFT JOIN usuarios_ven_juegos on id_juego = juegos.id
        WHERE juegos.id = ? 
        AND juegos.borrado = FALSE 
        AND usuarios.borrado = FALSE
        GROUP BY juegos.id";
    $data = mysqli_fetch_assoc(db::mysqliExecuteQuery($query, "s", array($id)));
    if(count($data) == 0 || $data["es_publico"] == 0 && (!logged || $data["id_desarrollador"] != userId && access_level < 3)){
        
        session::info_message("No se encontró el juego", "danger");
        header("Location: home.php");
        exit();
    }

    //Consulta para obtener las paltaformas disponibles del juego, se guarda en $plataformas
    $query = "SELECT plataforma FROM plataformas_juegos WHERE id_juego = ?";
    $plataformas = db::mysqliExecuteQuery($query, "s", array($id));

    //Consulta para obtener las capturas de pantallas del juego, se guarda en $capturas
    $query = "SELECT link_captura FROM capturas_pantalla WHERE id_juego = ? AND borrado = FALSE";
    $capturas = db::mysqliExecuteQuery($query, "s", array($id));

    //Consulta para ver si el usuario logead dio like, se guarda en $visualizacion["like"],
    //1 si dio like el usuario, 0 si no dio like el usuario 
    if (logged) {
        $query = "CALL select_usuarios_ven_juegos (?, ?)";
        $visualizacion = mysqli_fetch_assoc(db::mysqliExecuteQuery($query, "ii", array(userId, $id)));
    }

    //Consulta para obtener los comentarios del juego, se guarda en $comentarios

    $query = "SELECT fecha, texto, nombre, foto_perfil 
        FROM comentarios INNER JOIN usuarios ON comentarios.id_usuario = usuarios.id WHERE id_juego = ?
        ORDER BY ";

    if (logged)
        $query .= "CASE WHEN id_usuario = '" . userId . "' THEN 0 ELSE 1 END, ";
    $query .= "fecha DESC";
    $comentarios = db::mysqliExecuteQuery($query, "s", array($id));

    $query = "SELECT * FROM categorias INNER JOIN juegos_pertenecen_categoria ON id = id_categoria WHERE id_juego = ?";
    $categorias = mysqli_fetch_all(db::mysqliExecuteQuery($query, "s", array($id)), MYSQLI_ASSOC);

    
    $canHighlight  = logged && access_level >= MODERATOR_REQUIRED;
    $canEdit = $canHide = logged && ($data["id_desarrollador"] == userId || access_level >= MODERATOR_REQUIRED);

    $showOptions = $canHide || $canEdit || $canHighlight;
} else {
    session::info_message("No se encontró el juego", "danger");
    header("Location: home.php");
    exit();
}

include ("include/header.php");

?>

<article class="container px-4 px-md-5 py-3 align-items-center d-flex flex-column gap-2">

    <h1>
        <?= $data["titulo"] ?>
        <?php if ($showOptions) {?>
        <button class="btn" data-bs-toggle="dropdown"><i
                class="fa-solid fa-ellipsis-vertical"></i></button>

        <ul class="dropdown-menu dropdown-menu-end px-2 py-1">
                <?php if($canEdit) {?>
                <li><a class="dropdown-item rounded my-1" href="game_upload.php?id=<?=$id?>"><i
                            class="fa-solid fa-pen"></i>&nbsp;&nbsp;Editar</a></li>
                <?php } if($canHighlight) {?>
                <li><a class="dropdown-item rounded my-1" href="php_tasks/game_highlight.php?id=<?=$id?>"><i
                            class="fa-solid fa-star"></i>&nbsp;&nbsp;Destacar</a></li>
                <?php } if($canHide) {?>
                <li><a class="dropdown-item rounded my-1" href="php_tasks/game_hide.php?id=<?=$id?>"><i
                            class="fa-solid fa-eye"></i>&nbsp;&nbsp;<?php if($data["es_publico"] == 1) {?>Ocultar<?php } else { ?> Mostrar <?php }?> </a></li>
                <?php } ?>
        </ul>
        <?php }?>
    </h1>
    <div class="d-flex justify-content-center gap-2"><?php foreach ($categorias as $cat) { ?>
            <a form="games-search" name="categoria" href="games.php?categoria=<?= $cat["id"] ?>"
                class="btn btn-primary rounded-5 shadow-sm"><?= $cat["nombre"] ?></a>
        <?php } ?>
    </div>
    <section class="d-flex flex-column gap-2 text-start align-self-center border rounded-5 p-4 container">

        <div class="d-flex flex-column justify-content-center">
            <div class="btn-group" role="group">
                <?php if ($data["link_archivo_juego"] != "") { ?>
                    <a type="button" class="btn btn-primary" style="border-radius:0px; border-top-left-radius:0.5rem;"
                        href="<?= $data["link_archivo_juego"] ?>"><i class="fa-solid fa-play"></i>
                        Jugar en línea
                    </a>
                <?php } ?>
                <a type="button" class="btn btn-success <?= $data["link_archivo_juego"] == "" ? "rounded-top-3" : "" ?>"
                    style="border-radius:0px; border-top-right-radius:0.5rem;" target="_blank"
                    href="<?= $data["link_descarga"] ?>"><i class="fa-solid fa-download"></i>
                    Descargar
                </a>
            </div>
            <div class="w-100 bg-secondary text-white text-end p-2 rounded-3 rounded-top-0">
                <?php
                while ($plat = mysqli_fetch_assoc($plataformas)) {
                    ?>
                    <i class="fa-brands fa-<?= $plat["plataforma"] ?>"></i>
                    <?php
                }
                ?>
            </div>
        </div>
        <h3 class="mt-2">Descripción:</h3>

        <p><?= $data["descripcion"] ?></p>
        <?php
        $imageScrollerObject = new ImagesScroller();

        while ($capt = mysqli_fetch_assoc($capturas)) {
            $imageScrollerObject->AddImage($capt["link_captura"]);
        }

        $imageScrollerObject->echo();
        ?>

        <br>

        <h4>Autor:</h4>
        <div class="d-flex flex-wrap justify-content-between">
            <a class="fw-bold text-reset text-decoration-none"
                href="profile_info.php?id=<?= $data["id_desarrollador"] ?>">
                <img class="rounded-circle overflow-hidden"
                    src="<?= $data["foto_perfil"] == "" ? default_profile_icon : $data["foto_perfil"] ?>?t=<?= time() ?>"
                    width="40" height="40">
                <?= $data["autor"] ?>
            </a>
            <!--Formulario de dar like-->
            <form action="php_tasks/comment.php?like=1" method="post">
                <?php if (logged) { ?> <input type="hidden" name="id_usuario" value="<?= userId ?>"><?php } ?>
                <input type="hidden" name="id_juego" value="<?= $id ?>">
                <div class="btn-group" role="group">
                    <button class="btn btn-outline-primary rounded-start-5 
                    <?php
                    //Mostrar botón coloreado si el usuario logeado le dio like
                    if (logged && $visualizacion["like"] == 1)
                        echo 'active' ?>" <?php //Si no está logeado, desactivar el submit del botón
                    if (!logged)
                        echo ' data-bs-toggle="tooltip" data-bs-title="Regístrate o inicia sesión para dar like" type="button"' ?>>
                            <i class="fa-solid fa-thumbs-up"></i>
                        <?= $data["likes"] ?>
                    </button>


                    <button type="button" class="btn btn-outline-success rounded-end-5" data-bs-toggle="modal"
                        data-bs-target="#share-modal">
                        Compartir <i class="fa-solid fa-share"></i>
                    </button>

                </div>
            </form>
        </div>
        <br>
        <h4>Comentarios: </h4>

        <form action="php_tasks/comment.php?" method="post">

            <?php if (logged) { ?><input type="hidden" name="id_usuario" value="<?= userId ?>"><?php } ?>
            <input type="hidden" name="id_juego" value="<?= $id ?>">
            <textarea id="comentario-textarea" name="texto" class="form-control"
                placeholder="Escribe un comentario aquí..."></textarea>

            <div class="mt-3 d-flex gap-2 justify-content-end">
                <button type="button" class="btn rounded-5"
                    onclick='document.querySelector("#comentario-textarea").value = ""'>Cancelar</button>
                <button class="btn btn-primary rounded-5" <?php if (!logged)
                    echo ' type="button" data-bs-toggle="modal" data-bs-target="#loginModal"' ?>><?php if (logged)
                    echo "Comentar";
                else
                    echo "Iniciar sesión para comentar"; ?></button>
            </div>
        </form>
        <!---Comentarios--->
        <div class="d-flex flex-wrap gap-3">
            <?php
            while ($coment = mysqli_fetch_assoc($comentarios)) {
                ?>
            <div class="d-flex gap-2">
                <img class="rounded-circle overflow-hidden"
                    src="<?= $coment["foto_perfil"] == "" ? default_profile_icon : $coment["foto_perfil"] ?>?t=<?= time() ?>"
                    width="40" height="40">
                <div class="flex-grow-1">
                    <a class="text-reset fw-bold text-decoration-none" href="#">
                        <?= $coment["nombre"] ?>
                    </a>
                    <span class="text-secondary" style="font-size: small;">
                        • Hace
                        <?= haceTiempo($coment["fecha"]) ?>
                    </span>
                    <br>

                    <span>
                        <?= $coment["texto"] ?>
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
<div id="share-modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">¡Comparte este juego!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex justify-content-center">
                <!-- AddToAny BEGIN -->
                <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                    <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
                    <a class="a2a_button_whatsapp"></a>
                    <a class="a2a_button_facebook"></a>
                    <a class="a2a_button_facebook_messenger"></a>
                    <a class="a2a_button_x"></a>
                    <a class="a2a_button_reddit"></a>
                    <a class="a2a_button_telegram"></a>
                    <a class="a2a_button_email"></a>
                </div>
                <script async src="https://static.addtoany.com/menu/page.js"></script>
                <!-- AddToAny END -->
            </div>
        </div>
    </div>
</div>


<style>
    .a2a_svg,
    .a2a_count {
        border-radius: 50% !important;
    }
</style>

<?php
include ("include/footer.php");
?>