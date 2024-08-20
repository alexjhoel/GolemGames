<?php
    $navSelection = 1;
    include("include/header.php");
    $maxPages = 10;
    $page = 1;

    if(!is_GET_set("id")){
        if(logged) $redirect = "profile_info.php?id=".userId;
        else $redirect = "home.php";
        ?>
        <script>window.location.href = "<?=$redirect?>";</script>
        <?php
        exit();
    }
    
    $id = $_GET["id"];

    $query = "SELECT nombre, sobre_mi, foto_perfil, nivel_acceso FROM usuarios WHERE id=?";
    $userData = mysqli_fetch_assoc(db::mysqliExecuteQuery( $query,"s",array($id)));

    $maxRows = 30;
    $query = "SELECT 
    juegos.id as id, 
    titulo, 
    usuarios.nombre as nombre_usuario, es_publico,
    IFNULL(GROUP_CONCAT(link_captura ORDER BY capturas_pantalla.id ASC SEPARATOR ', '),'') as capturas, 
    IFNULL((SELECT SUM(`like`) FROM usuarios_ven_juegos as A WHERE A.id_juego = juegos.id GROUP BY A.id_juego), 0) as likes, 
    IFNULL((SELECT COUNT(DISTINCT(A.id_usuario)) FROM usuarios_ven_juegos as A WHERE A.id_juego = juegos.id GROUP BY A.id_juego), 0) as visitas
    FROM juegos
    INNER JOIN usuarios ON juegos.id_desarrollador = usuarios.id
    LEFT JOIN capturas_pantalla ON juegos.id = capturas_pantalla.id_juego AND capturas_pantalla.borrado = FALSE
    WHERE juegos.borrado = FALSE ". (logged && $id == userId ? "" : "AND juegos.es_publico = TRUE ") . "AND usuarios.id = ?
    GROUP BY juegos.id
    LIMIT 0, $maxRows";
    $gamesData = db::mysqliExecuteQuery( $query,"s",array($id));
?>

<article class="container px-4 px-md-5 py-3 align-items-center d-flex flex-column gap-2">
    
    <section class="card d-flex flex-column gap-2 text-start align-self-center rounded-5 p-4 container overflow-hidden">
        <!---Información de usuario--->
        <div class="d-flex gap-3">
            <img class="rounded-circle overflow-hidden" width="150" height="150" src="<?=$userData["foto_perfil"]?>?t=<?=time()?>">
            <div>
                <div class="row">
                     <h1 class="m-0 col-auto">
                     <?php if($userData["nivel_acceso"] == 3) { ?> <i class="fa-solid fa-user-gear"></i> <?php } else if($userData["nivel_acceso"] == 4) { ?> <i class="fa-solid fa-crown"></i> <?php }?>
                     <?=$userData["nombre"]?>
                     <?php if(logged && access_level == 4 && $id != userId) {
                        if($userData["nivel_acceso"] == 2) { ?>
                            <a class="btn btn-primary" href="php_tasks/user_access.php?id=<?=$id?>&moderator=1"><i class="fa-solid fa-arrow-up"></i></a></h1>
                        <?php } else if ($userData["nivel_acceso"] == 3) {?>
                            <a class="btn btn-primary" href="php_tasks/user_access.php?id=<?=$id?>&developer=1"><i class="fa-solid fa-arrow-down"></i></a></h1> 
                    <?php }}?>
                </div>
            </div>
        </div>
        <h4>Sobre mí:</h4>
            <p><?=$userData["sobre_mi"]?></p>
            <?php if(logged && userId == $id) { ?>
            <a class="btn btn-primary position-absolute top-0 end-0 rounded-5 rounded-top-0 rounded-end-0 ps-4 pe-4 py-2" 
                href="profile_edit.php?id=<?=$id?>">
                <i class="fa-solid fa-pen"></i>
            </a>
            <?php } ?>
    </section>
    <?php if(mysqli_num_rows($gamesData) != 0){?>
    <section class="text-start py-2 container">
        <h3><i class="fas fa-gamepad fa-sm"></i>&nbsp;Mis juegos</h3>
        <?php
            $scroller = new GamesScroller();

            foreach ($gamesData as $gameData) {
                if($gameData["es_publico"] == 1 || access_level < 3){
                    $gameCardObject = new GameCards;
                    $gameCardObject->id = $gameData["id"];
                    $gameCardObject->titulo = $gameData["titulo"];
                    $gameCardObject->autor = $gameData["nombre_usuario"];
                    $gameCardObject->vistas = $gameData["visitas"];
                    $gameCardObject->likes = $gameData["likes"];
                    $gameCardObject->linksCapturas = $gameData["capturas"];
                    $scroller->addGame($gameCardObject);
                }
            }

            
            $scroller->echo();
        ?>
        </div>
    </section>
    <?php }?>
    
</article>
<?php
    include("include/footer.php");
?>