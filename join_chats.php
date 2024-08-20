<?php
    $navSelection = 2;
    $access_level_required = 1;
    include("include/header.php");
    $maxPages = 10;
    $page = 1;
    $maxCategorias = 10;

    $gameCardObject = new GameCards();
    $searchQuery = "";
    if(isset($_GET["search"]) && $_GET["search"]!=''){
        $searchValue = $_GET["search"];
        $searchQuery .= " AND tema LIKE '%$searchValue%' ";
    }

    if(isset($_GET["creador"]) && $_GET["creador"]!=''){
        $creadorValue = $_GET["creador"];
        $searchQuery .= " AND nombre LIKE '%$creadorValue%'";
    }

    $ordersQueries = array(
        "fecha_creado DESC",
        "miembros DESC",
        "tema ASC"
    );

    $orderSelection = 0;
    if(isset($_GET["order"]) && is_numeric($_GET["order"]) && $_GET["order"] >= 0 && $_GET["order"] <= 2){
        $orderSelection = $_GET["order"];
    }

    $orderQuery = $ordersQueries[$orderSelection];

    $maxEntries = 12;
    $total = mysqli_fetch_all(db::mysqliExecuteQuery(
        "SELECT COUNT(salas_chat.id) as total 
        FROM salas_chat 
        INNER JOIN usuarios ON id_creador = usuarios.id
        WHERE oculto = 0 AND salas_chat.borrado = 0 AND salas_chat.id NOT IN (SELECT id_sala_chat FROM usuarios_ingresan_salas WHERE id_usuario = ?)  
        $searchQuery",
        "s",
        array(userId)
    ), MYSQLI_ASSOC)[0]["total"];

    $maxPages = ceil(($total) / $maxEntries);
    $page = max(min(isset($_GET["page"]) ? $_GET["page"] : 1, $maxPages),1);
    $start = $maxEntries * ($page - 1);

    //Datos de sala de chat
    $query = "SELECT salas_chat.id as id, COUNT(id_usuario) as miembros, tema, descripcion, id_creador, nombre, fecha_creado 
    FROM salas_chat 
    LEFT JOIN usuarios_ingresan_salas ON salas_chat.id = id_sala_chat
    LEFT JOIN usuarios ON id_creador = usuarios.id
    WHERE oculto = 0 
    AND salas_chat.borrado = 0
    AND salas_chat.id NOT IN (SELECT id_sala_chat FROM usuarios_ingresan_salas WHERE id_usuario = ?)
    $searchQuery
    GROUP BY salas_chat.id
    ORDER BY $orderQuery
    LIMIT $start,$maxEntries";

    $data = mysqli_fetch_all(db::mysqliExecuteQuery(
        $query,
        "s",
        array(userId)
    ), MYSQLI_ASSOC);

    function closeLink($name){
        $values = array(
            "search" => isset($GLOBALS['searchValue']) ? urlencode($GLOBALS['searchValue']) : NULL,
            "creador" => isset($GLOBALS['creadorValue']) ? urlencode($GLOBALS['creadorValue']) : NULL
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
                <input type="text" name="search" <?php if(isset($searchValue)) echo("value='$searchValue'"); ?> class="form-control rounded-start border-0 shadow-none fs-5" placeholder="Buscar salas" />
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
                            <input name="creador" type="text" class="form-control rounded-5" id="developerInput" value="<?= isset($_GET["creador"]) ? $_GET["creador"] : ""?>">
                            <label for="developerInput">Creador</label>
                        </div>
                        
                        <div class="form-floating">
                            <select name="order" class="form-select rounded-5" id="floatingSelect" aria-label="Floating label select example">
                                <option value="0" <?= !is_GET_set("order") || $_GET["order"] == 0 ? "selected" : ""?>>Fecha de creación</option>
                                <option value="1" <?= is_GET_set("order") && $_GET["order"] == 1 ? "selected" : ""?>>Cantidad de miembros</option>
                                <option value="2" <?= is_GET_set("order") && $_GET["order"] == 2 ? "selected" : ""?>>Título</option>
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
        if(isset($creadorValue)){?>
            <span class="btn btn-primary rounded-5 shadow-sm"><a href="?<?=closeLink("creador") ?>"><i class="fa-solid fa-x"></i></a>&nbsp;<i class="fa-solid fa-user"></i>&nbsp;<?=$creadorValue?></span>
        <?php }?>
    </section>

    <section class="align-self-center w-100">
        <?php $i = 0; foreach ($data as $d) { ?>
            <div class="d-flex bg-<?= $i % 2 == 0 ? "primary text-light" : "body"?> rounded-5 p-2">
                <div class="text-start flex-fill text-truncate lh-lg">
                    <span><?=$d["tema"]?> -</span>
                    <a class="text-start text-truncate" href="profile_info.php?id=<?=$d["id_creador"]?>"><?=$d["nombre"]?></a>
                </div>
                <div class="text-end">
                    <?=$d["miembros"]?>
                    <i class="fa-solid fa-user "></i>
                    <button class="btn btn-success rounded-5 join-room-button" data-id="<?=$d["id"]?>"><i class="fa-solid fa-user-plus"></i></button>
                </div>
            </div>
        <?php $i++;}?>

        
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

<script>
    $(".join-room-button").click(async function(){
        let btn = $(this);
        btn.addClass("disabled");
        btn.click(null);
        await $.ajax({
                url: "php_tasks/join_room.php",
                type: "post",
                data: { id: btn.attr("data-id") },
                success: function (data) {
                    console.log(data);
                    if(data == "success"){
                    btn.removeClass("btn-success")
                    btn.removeClass("disabled")
                    btn.addClass("btn-secondary")
                    btn.click(function(){window.location.href = "chats.php?id=" + $(this).attr("data-id")})
                    btn.html("<i class='fa-solid fa-comment'></i>")
                    }


                },
                error: function (error) {
                    console.log(error);
                }
            })
    })
</script>