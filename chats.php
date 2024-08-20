<?php
include_once ("include/connect_session.php");
include_once ("include/definitions.php");

$navSelection = 2;
$access_level_required = LOGGED_REQUIRED;

include ("include/header.php");


$query = "SELECT nombre, sobre_mi, foto_perfil, correo_electronico FROM usuarios WHERE id=?";
$usuarioData = mysqli_fetch_assoc(db::mysqliExecuteQuery($query, "s", array(userId)));

$query = "SELECT * FROM( 
(SELECT id, tema, fecha_creado, salas_chat.borrado FROM salas_chat INNER JOIN usuarios_ingresan_salas ON salas_chat.id = id_sala_chat AND oculto = 0 AND id_usuario = ?)
UNION 
(SELECT id, tema, fecha_creado, borrado FROM salas_chat WHERE id_creador = ?)) as A WHERE borrado = 0  ORDER BY fecha_creado;";
$salasChat = mysqli_fetch_all(db::mysqliExecuteQuery($query, "ss", array(userId, userId)), MYSQLI_ASSOC);

$id = "";
if(is_GET_set("id")) $id = $_GET["id"];

?>

<article class="container px-4 px-md-5 gap-2 flex-fill">
    <div class="row h-100">
        <div class="col-sm-4 col-md-3 py-3">
            <nav id="config-navbar" class="flex-column align-items-stretch pe-4">
                <h4>Mis salas de chats</h4>
                <div class="row gap-2 px-2 pb-2">
                    <button class="btn btn-primary rounded-5" data-bs-toggle="modal" data-bs-target="#add-room-modal"><i class="fa-solid fa-plus"></i>&nbsp;Crear nueva sala</button>
                    <a href="join_chats.php" class="btn btn-primary rounded-5"><i class="fa-solid fa-search"></i>&nbsp;Buscar salas</a>
                </div>
                <nav class="nav nav-pills flex-column">
                    <?php foreach ($salasChat as $salas) { ?>
                        <a class="nav-link rounded-5 room-button" data-room-id="<?= $salas["id"] ?>" data-bs-toggle="tab"
                            data-bs-target="#tab-<?= $salas["id"] ?>" type="button" role="tab"><?= $salas["tema"] ?></a>
                    <?php } ?>
                </nav>
            </nav>
        </div>

        <div class="col-sm-8 col-md-9 tab-content">

            <?php foreach ($salasChat as $salas) { ?>
                <div class="tab-pane" id="tab-<?= $salas["id"] ?>" role="tabpanel">
                    <div class="d-flex bg-primary rounded-5 p-3 mt-3 text-light">
                        <div class="d-none d-md-inline flex-fill text-start"></div>
                        <div class="flex text-end"><i data-room-id="<?= $salas["id"] ?>" class="room-info-button btn fa-solid fa-ellipsis-vertical text-light"></i></div>
                    </div>
                    <div class="d-flex flex-column" style="height: 80vh;">
                        <div class="flex-fill d-flex flex-column justify-content-end overflow-auto">
                            <div id="chat-container-<?= $salas["id"] ?>" class="d-flex flex-column py-2 gap-2 overflow-auto">
                                <div class="align-self-end text-end" style="max-width:75%">
                                    <a href="#">Usuario dice</a>
                                    <div class="bg-secondary text-light rounded-5 p-3 text-start mb-1"
                                        style="word-wrap: break-word;">
                                        Holsadddasasdddssssssssssssssaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaasssssssssssssssssssssssss
                                    </div>
                                    <div class="bg-secondary text-light rounded-5 p-3 text-start mb-1"
                                        style="word-wrap: break-word;">
                                        Holsadddasasdddssssssssssssssaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaasssssssssssssssssssssssss
                                    </div>
                                </div>

                                <div class="align-self-start" style="max-width:75%">
                                    <a href="#">Usuario dice</a>
                                    <div class="bg-primary text-light rounded-5 p-3 text-start mb-1"
                                        style="word-wrap: break-word;">
                                        Holsadddasasdddssssssssssssssaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaasssssssssssssssssssssssss
                                    </div>
                                </div>

                            </div>
                        </div>
                        
                        <form method="post" class="flex-shrink-1 pt-3 d-flex gap-2 align-items-center chat-form"
                                data-room-id="<?= $salas["id"] ?>">
                                <input name="room" value="<?= $salas["id"] ?>" hidden>
                                <textarea class="form-control rounded-5" name="text" cols="40" rows="1"
                                    style="resize: none;"></textarea>
                                <button type="submit" class="btn btn-primary rounded-circle" style="height: 40px;"><i
                                        class="fa-solid fa-paper-plane"></i></button>
                        </form>
                    </div>
                </div>
            <?php } ?>

            <div class="modal fade" id="spinner-modal" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered" style="width:fit-content;">
                    <div class="modal-content">
                        <div class="modal-body d-flex justify-content-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="room-info-modal" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 id="room-info-title" class="modal-title">Tema</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body d-flex flex-column gap-2">
                            <p id="room-info-description">Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                                Obcaecati mollitia voluptatem eveniet tempora veritatis 
                                consectetur esse amet facilis? Neque eaque enim, earum 
                                veniam unde culpa praesentium saepe molestiae sit? Eaque.
                            </p>
                            
                            <h4>Miembros&nbsp;&nbsp;<i class="fa-solid fa-user"></i>&nbsp;<span id="room-members-quantity">10</span></h4>
                            <div id="room-members-container" class="d-flex flex-column gap-2">
                            </div>
                            <div class="d-flex justify-content-center gap-2">
                                <button id="leave-room-button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#leave-room-modal"><i class="fa-solid fa-right-from-bracket"></i>&nbsp;Salir de la sala</button>
                                <button id="delete-room-button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-room-modal"><i class="fa-solid fa-trash"></i>&nbsp;Borrar sala</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="add-room-modal" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Crea tu nueva sala de chat</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="create-room-form" 
                            class="form-validator modal-body d-flex flex-column gap-2"
                            method="post"
                            action="php_tasks/room_create.php"
                            validate-method="post"
                            validate-action="php_tasks/room_create.php?validate=1">

                            <div class="form-floating">
                                <input id="tituloInput" name="titulo" class="form-control rounded-5" type="text" placeholder="Escribe aqui un titulo">
                                <label for="tituloInput">Tema/Título</label>
                                <div class="invalid-feedback"></div>
                            </div>
                            
                            <div class="form-floating">
                                <input id="descripcionInput" name="descripcion" class="form-control rounded-5" type="text" placeholder="Escribe aqui una descripcion">
                                <label for="descripcionInput">Descripción</label>
                                <div class="invalid-feedback"></div>
                            </div>
                            <!--
                            <div class="form-check form-switch">
                                <input name="oculto" class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                <label class="form-check-label" for="flexSwitchCheckDefault">Sala privada(solo con invitación)</label>
                            </div>
                            -->
                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary rounded-5" data-bs-dismiss="modal">Descartar</button>
                            <button type="submit" form="create-room-form" class="btn btn-primary rounded-5">Crear</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="delete-room-modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Confirmar eliminación</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Vas a eliminar este sala, ya no podrá ser accesible ni por ti no por sus miembros.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <a id="confirm-delete-room-button" type="button" class="btn btn-danger" href="php_tasks/room_delete.php?id="><i class="fa-solid fa-trash"></i>&nbsp;CONFIRMAR</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="leave-room-modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Confirmar salida</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Vas a salir de esta, se quitará de tu lista de salas de chats.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <a id="confirm-leave-room-button" type="button" class="btn btn-success" href="php_tasks/room_leave.php?id="><i class="fa-solid fa-check"></i>&nbsp;Confirmar</a>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

</article>
<?php
$footer_disabled = true;
include ("include/footer.php");
?>

<script type="text/javascript" src="assets/js/autogrow_textareas.js?t=<?= time() ?>"></script>
<script>

    //$('#chat_form').parsley();

    //$('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);

    var loadChats = () => {}
    var timer;

    $('.chat-form').submit(function (event) {
        
        event.preventDefault();

        var data = new FormData(event.target);

        $(this).children("textarea").val("");

        $.ajax({
            url: "php_tasks/send_chat.php",
            type: "post",
            data: data ,
            processData:false,
            contentType:false,
            success: function (data) {
                //console.log(data);

            },
            error: function (error) {
                //console.log(error);
            },


        })

        return false;
    });

    $('.room-button').click(async function () {

        let container = $("#chat-container-" + $(this).attr("data-room-id"));
        container.html("<div class='d-flex justify-content-center'><button class='btn btn-secondary rounded-5'>Cargar más</button></div>");

        
        let roomId = $(this).attr("data-room-id");

        container.children().children().click(async function(e){
            var parent = $(this).parent().detach()
            $("#spinner-modal").modal("show")

            await $.ajax({
                url: "php_tasks/load_chats.php",
                type: "post",
                data: { id: roomId , before: container.children().first().children("div").first().attr("data-id")},
                success: function (data) {
                    if(timer) clearTimeout(timer);
                    setTimeout(function () {
                        var subContainer = jQuery('<div>')
                        data.forEach(element => {
                            addChat(subContainer, element["id"], element["id_usuario"], element["nombre"], element["texto"])
                        });
                        container.html( subContainer.html() + container.html() )
                        container.prepend(parent)
                        $("#spinner-modal").modal("hide")
                        timer = setTimeout(loadChats, 1500)
                    }, 500)

                },
                error: function (error) {
                    console.log(error);
                }
            })

        })
        $("#spinner-modal").modal("show");

        await $.ajax({
            url: "php_tasks/load_chats.php",
            type: "post",
            data: { id: roomId },
            success: function (data) {
                console.log(data);
                setTimeout(function () {
                    data.forEach(element => {
                        addChat(container, element["id"], element["id_usuario"], element["nombre"], element["texto"])
                    });
                    container.scrollTop(container.scroll()[0].scrollHeight)
                    $("#spinner-modal").modal("hide")
                }, 500)

            },
            error: function (error) {
                //console.log(error);
            },


        })

        if(timer) clearTimeout(timer);

        loadChats = async function (){
            await $.ajax({
            url: "php_tasks/load_chats.php",
            type: "post",
            data: { id: roomId, after: container.children().last().children().last().attr("data-id")},
            success: function (data) {
                //console.log(data);
                
                const scrollDown = data.length > 0 && Math.ceil(container[0].scrollTop + container[0].clientHeight + 15) >= container[0].scrollHeight;
                
                data.forEach(element => {
                        addChat(container, element["id"], element["id_usuario"], element["nombre"], element["texto"])
                });

                if(scrollDown) container.scrollTop(container[0].scrollHeight);
                
                timer = setTimeout(loadChats, 1500)
            },
            error: function (error) {
                //console.log(error);
            },
            })
        }

        setTimeout(loadChats,1500);

    });

    $(".room-info-button").click(async function(){
        const roomId = $(this).attr("data-room-id");
        
        $("#spinner-modal").modal("show")

        await $.ajax({
            url: "php_tasks/load_room_info.php",
            type: "post",
            data: { id: roomId },
            success: function (data) {
                console.log(data);

                setTimeout(function () {
                    $("#spinner-modal").modal("hide")

                    $("#room-info-title").html(data["tema"]);
                    $("#room-info-description").html(data["descripcion"]);
                    $("#room-members-container").html("")
                    $("#room-members-quantity").html(data["cantidad_miembros"])

                    if(data.members){
                        data.members.forEach((member)=>{
                            $("#room-members-container").append("<a href='profile_info.php?id="+member["id"]+"'><i class='fa-solid fa-user'></i>"+member["nombre"]+"</a>")
                        })
                    }

                    if(<?=userId?>==data["id_creador"]){
                        $("#delete-room-button").show();
                        $("#leave-room-button").hide();
                    }
                    else{
                        $("#delete-room-button").hide();
                        $("#leave-room-button").show();
                    }

                    <?php if(access_level == 4) {?>
                        $("#delete-room-button").show();
                    <?php } ?>

                    

                    $("#confirm-delete-room-button").attr("href", "php_tasks/room_delete.php?id=" + roomId)
                    $("#confirm-leave-room-button").attr("href", "php_tasks/room_leave.php?id=" + roomId)


                    $("#room-info-modal").modal("show")
                }, 500)

            },
            error: function (error) {
                //console.log(error);
            },


        })
    })


    function addChat(container, id, userId, username, text) {
        let chatSet = container.children().last();
        if (chatSet.attr("data-user-id") != userId) {
            if (userId == <?= userId ?>) {
                container.append("<div class='align-self-end text-end d-flex flex-column align-items-end' style='max-width:75%' data-user-id="+userId+"></div>");
            } else {
                container.append("<div class='align-self-start' style='max-width:75%' data-user-id="+userId+"></div>");
            }
            chatSet = container.children().last();
            chatSet.append("<a href='profile_info.php?id=" + userId + "'>" + username + " dice</a>");
        }

        if (userId == <?= userId ?>) {
            chatSet.append("<div data-id='"+id+"' class='bg-primary text-light rounded-5 p-3 text-start mb-1' style='word-wrap: break-word; width: fit-content;'>" + text + "</div>");
        } else {
            chatSet.append("<div data-id='"+id+"' class='bg-secondary text-light rounded-5 p-3 text-start mb-1' style='word-wrap: break-word; width: fit-content;'>" + text + "</div>");
        }
    }

    $(document).on("DOMContentLoaded", function(){
        $(".room-button[data-room-id='<?=$id?>']").click()
        $(".room-button[data-room-id='<?=$id?>']").addClass("active")
        $("#tab-<?=$id?>").addClass("active")
    })

</script>