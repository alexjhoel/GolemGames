<?php
include_once ("include/connect_session.php");
include_once ("include/definitions.php");

$navSelection = 0;
$access_level = DEVELOPER_REQUIRED;

$isEdit = is_GET_set("id");

if ($isEdit) {
    $id = $_GET["id"];

    //Consulta de datos de juego, se guarda en $data
    $query = "SELECT foto_perfil, juegos.id as id, nombre as autor, id_desarrollador, titulo, descripcion, link_archivo_juego, link_descarga, es_publico, vistas  
        FROM juegos 
        INNER JOIN usuarios ON juegos.id_desarrollador = usuarios.id
        LEFT JOIN usuarios_ven_juegos on id_juego = juegos.id
        WHERE juegos.id = ? 
        AND juegos.borrado = FALSE 
        AND usuarios.borrado = FALSE
        GROUP BY juegos.id";
    
    $juegoData = mysqli_fetch_assoc(db::mysqliExecuteQuery( $query, "s", array($id)));
    if(!logged || !$juegoData || (access_level <= 2 && $juegoData["id_desarrollador"] != userId)){
        session::info_message("No se encontró el juego", "danger");
        header("Location: home.php");
        exit();
    }

    //Consulta para obtener las paltaformas disponibles del juego, se guarda en $plataformas
    $query = "SELECT plataforma FROM plataformas_juegos WHERE id_juego = ?";
    $result = db::mysqliExecuteQuery( $query, "s", array($id));
    $plataformas = array();

    while ($plat = mysqli_fetch_assoc($result)) {
        array_push($plataformas, $plat["plataforma"]);
    }

    //Consulta para obtener las capturas de pantallas del juego, se guarda en $capturas
    $query = "SELECT id, link_captura FROM capturas_pantalla WHERE id_juego = ? && borrado = FALSE";
    $capturas = db::mysqliExecuteQuery( $query, "s", array($id));

    $query = "SELECT id, nombre FROM categorias INNER JOIN juegos_pertenecen_categoria AS b ON categorias.id = b.id_categoria WHERE categorias.borrado = FALSE AND id_juego = ?";
    $categoriasJuego = mysqli_fetch_all(db::mysqliExecuteQuery( $query, "s", [$id]), MYSQLI_ASSOC);
}



include ("include/header.php");

$imageScrollerObject = new ImagesScroller();
$imageScrollerObject->addEnabled = true;

if ($isEdit)
    while ($capt = mysqli_fetch_assoc($capturas)) {
        $imageScrollerObject->AddImage($capt["link_captura"]);
        $imageScrollerObject->AddId($capt["link_captura"]);
    }

$categorias = db::mysqliExecuteQuery( "SELECT id, nombre FROM categorias WHERE borrado = FALSE", "", array());




?>

<article class="container px-4 px-md-5 py-3 gap-2 flex-grow-1">

    <form class="form-validator show-progress d-flex flex-column gap-2 text-start" method="POST"
        redirect-action="./profile_info.php?id=<?= userId ?>" validate-method="POST"
        validate-action="./php_tasks/game_save.php" novalidate enctype='multipart/form-data'>

        <?php if ($isEdit) { ?><input type="hidden" name="edit" value="<?= $id ?>"> <?php } ?>

        <div class="form-floating">
            <input type="text" class="form-control rounded-5" id="titleInput" name="titulo"
                value="<?= $isEdit ? $juegoData["titulo"] : "" ?>">
            <label for="titleInput">Título del juego</label>
            <div class="invalid-feedback"></div>
        </div>
        <div class="tab-pane active" id="tab-1" role="tabpanel">
            <?php $imageScrollerObject->echo(); ?>
            <div id="images-to-add-container">

            </div>
            <div id="images-to-remove-container">

            </div>

            <div class="alert" role="alert" style="display: none;"></div>
            <input name="imagenes_agregar_feedback" hidden>
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-floating">
            <textarea class="form-control rounded-4" placeholder="Leave a comment here" id="descripcionInput"
                maxlength="201" style="height: 100px"
                name="descripcion"><?= $isEdit ? $juegoData["descripcion"] : "" ?></textarea>
            <label for="descripcionInput">Descripción:</label>
            <div class="invalid-feedback"></div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="rounded-3 border d-flex flex-column gap-3 p-3 justify-content-center">
                <label for="download-file-upload">Archivo de descarga:</label>
                <div class="input-group">
                    <input class="form-control" id="donwload-file-upload" type="file" accept=".zip"
                        name="archivo_descarga">
                    <a class="btn btn-info fs-5 text-white pt-2" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-custom-class="custom-tooltip"
                        data-bs-title="250MB MAX (.zip) Haz click para obtener ayuda" href="game_upload_help.php"
                        target="_blank">
                        <i class="fa-solid fa-circle-question"></i><br>
                    </a>
                </div>
                <label for="file-upload">Plataformas:</label>
                <div class="btn-group btn-group-lg" role="group" aria-label="Basic radio toggle button group">
                    <input type="checkbox" class="btn-check" name="plataforma[]" value="windows" id="btnradio1"
                        autocomplete="off" <?= $isEdit && in_array("windows", $plataformas) ? "checked" : "" ?>>
                    <label class="btn btn-outline-primary rounded-start-5" for="btnradio1"><i
                            class="fa-brands fa-windows"></i></label>

                    <input type="checkbox" class="btn-check" name="plataforma[]" value="linux" id="btnradio2"
                        autocomplete="off" <?= $isEdit && in_array("linux", $plataformas) ? "checked" : "" ?>>
                    <label class="btn btn-outline-primary" for="btnradio2"><i class="fa-brands fa-linux"></i></label>

                    <input type="checkbox" class="btn-check" name="plataforma[]" value="apple" id="btnradio3"
                        autocomplete="off" <?= $isEdit && in_array("apple", $plataformas) ? "checked" : "" ?>>
                    <label class="btn btn-outline-primary" for="btnradio3"><i class="fa-brands fa-apple"></i></label>

                    <input type="checkbox" class="btn-check" name="plataforma[]" value="android" id="btnradio4"
                        autocomplete="off" <?= $isEdit && in_array("android", $plataformas) ? "checked" : "" ?>>
                    <label class="btn btn-outline-primary rounded-end-5" for="btnradio4"><i
                            class="fa-brands fa-android"></i></label>
                </div>

                <input type="checkbox" class="btn-check" name="web" value="web" id="btnradio5" autocomplete="off"
                    <?= $isEdit && $juegoData["link_archivo_juego"] != "" ? "checked" : "" ?>>

                <label class="btn btn-outline-primary rounded-5" for="btnradio5" data-bs-toggle="collapse"
                    href="#fileCollapse"><i class="fa-solid fa-globe"></i>&nbsp;Disponible para jugar en WEB</label>


                <div class="input-group collapse <?= $juegoData["link_archivo_juego"] != "" ? "in show" : "" ?>"
                    id="fileCollapse">
                    <input class="form-control" id="web-file-upload" name="archivo_web" type="file" accept=".zip">
                    <a class="btn btn-info fs-5 text-white pt-2" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-custom-class="custom-tooltip"
                        data-bs-title="250MB MAX (.zip) Click para ver todos los requisitos" href="game_upload_help.php"
                        target="_blank">
                        <i class="fa-solid fa-circle-question"></i><br>
                    </a>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column p-3 gap-3 rounded-4 border">
            <span>Categorías:</span>
            <div id="category-container" class="d-flex flex-wrap gap-2">
                <?php if ($isEdit)
                    foreach ($categoriasJuego as $cat) { ?>
                        <input id="category-<?= $cat["id"] ?>" type='number' name='id_categoria[]' value='<?= $cat["id"] ?>' hidden>
                        <span data-id='<?= $cat["id"] ?>' class='btn btn-primary rounded-5 shadow-sm'><?= $cat["nombre"] ?></span>
                    <?php } ?>
            </div>
            <div class="input-group dropdown ">
                <button id="add-category-button" type="button" class="btn btn-primary"><i
                        class="fa-solid fa-plus"></i></button>
                <input id="category-name-input" type="text" value="" class="form-control">
                <button id="category-toggler" type="button"
                    class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end w-100">
                    <?php while ($cat = mysqli_fetch_assoc($categorias)) { ?>
                        <li>
                            <a class="dropdown-item category-select-option" data-id="<?= $cat["id"] ?>">
                                <?= $cat["nombre"] ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>

        <div class="rounded-4 border p-3">
            <p>Privacidad:</p>
            <div class="form-check form-switch">
                <input class="form-check-input" name="publico" type="checkbox" role="switch" id="flexSwitchCheckChecked"
                    <?= !$isEdit || $juegoData["es_publico"] == 1 ? "checked" : "" ?>>
                <label class="form-check-label" for="flexSwitchCheckChecked">Público</label>
            </div>
        </div>

        <button type="submit " class="btn btn-primary rounded-5 submit-button"><i
                class="fa-solid fa-<?= $isEdit ? "save" : "upload" ?>"></i>&nbsp;<?= $isEdit ? "Guardar" : "Subir y publicar" ?></button>
        <?php if ($isEdit) { ?>
            <a class="btn btn-danger rounded-5" data-bs-toggle="modal" data-bs-target="#deleteModal"><i
                    class="fa-solid fa-trash"></i>&nbsp;Eliminar</a>

            <div class="modal fade" id="deleteModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Confirmar eliminación</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Vas a eliminar este juego, sus datos y archivos, esta acción no se puede deshacer.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <a type="button" class="btn btn-danger" href="php_tasks/game_delete.php?id=<?=$id?>"><i class="fa-solid fa-trash"></i>&nbsp;CONFIRMAR</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="progress rounded-5" role="progressbar" aria-label="Animated striped example" aria-valuenow="75"
            aria-valuemin="0" aria-valuemax="100">
            <div id="form-progress-bar" class="progress-bar progress-bar-striped progress-bar-animated"
                style="width: 0%">Subiendo</div>
        </div>

        <input type="file" id="image-upload" name="" accept="image/*" hidden>
    </form>

</article>
<div class="modal fade" id="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="crop">Crop</button>
            </div>
        </div>
    </div>
</div>


<script>
    var i = 1;

    window.addEventListener('DOMContentLoaded', function () {
        var image = document.getElementById('image');
        var input = document.getElementById('image-upload');
        var $progress = $('.progress');
        var $progressBar = $('.progress-bar');
        var $alert = $('.alert');
        var $modal = $('#modal');
        var cropper;

        $('[data-toggle="tooltip"]').tooltip();

        input.addEventListener('change', function (e) {
            var files = e.target.files;
            var done = function (url) {
                input.value = '';
                image.src = url;
                $alert.hide();
                $modal.modal('show');
            };
            var reader;
            var file;
            var url;

            if (files && files.length > 0) {
                file = files[0];

                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function (e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });

        $modal.on('shown.bs.modal', function () {
            cropper = new Cropper(image, {
                aspectRatio: 16 / 9,
                viewMode: 2,
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });

        document.getElementById('crop').addEventListener('click', function () {
            var initialAvatarURL;
            var canvas;

            $modal.modal('hide');

            if (cropper) {
                canvas = cropper.getCroppedCanvas({
                    width: 1024,
                    height: 1024
                });
                screenshotScroller.add("<li class='splide__slide rounded-5 overflow-hidden'><img class='' src='" + canvas.toDataURL() + "'></li>");
                let newA = document.createElement("a")
                newA.setAttribute("type", "button")
                newA.setAttribute("class", "position-absolute top-0 end-0 fs-5 pt-3 pe-3")
                newA.innerHTML = "<i class='fa-solid fa-trash'></i>"


                let screenshotScrollerLi = $(".splide__list")
                let lastLi = screenshotScrollerLi.children(":last-child")
                let index = screenshotScrollerLi.children(":last-child").index()

                lastLi.append(newA);

                $(newA).on('click', function () {
                    screenshotScroller.remove(index)
                    $("#" + newA.getAttribute("input-id")).remove();
                })



                $progress.show();
                $alert.removeClass('alert-success alert-warning');
                canvas.toBlob(function (blob) {
                    let file = new File([blob], "img" + i + ".jpg", { type: "image/jpeg", lastModified: new Date().getTime() });

                    let container = new DataTransfer();

                    container.items.add(file);

                    let newInput = document.createElement("input");
                    newInput.setAttribute("name", "imagenes_agregar[]");
                    newInput.setAttribute("type", "file");
                    newInput.setAttribute("accept", "image/*");
                    newInput.setAttribute("hidden", true);
                    newInput.setAttribute("id", "new-image-" + i);
                    newInput.files = container.files;

                    document.getElementById("images-to-add-container").append(newInput);
                    newA.setAttribute("input-id", "new-image-" + i)


                    i++;
                });
            }
        });


        $(".image-upload-button").on('click', function () {
            $('#image-upload').click();
        })

        $(".delete-image-button").on('click', function () {
            $("#images-to-remove-container").append("<input name='imagenes_remover[]' value='" + $(this).attr("data-id") + "' hidden>")
            $(this).parent().remove()
        })

        function showOptions(toggle) {

            if (toggle) {
                new bootstrap.Dropdown($("#category-name-input").siblings(".dropdown-toggle")).show();
                $("#category-name-input").focus();
            }

            var searchVal = $("#category-name-input").val();
            $("#category-name-input").siblings(".dropdown-menu").children().each(function (i) {
                if (isStringIncluded($(this).children("a").html(), searchVal.toLowerCase()) && $("#category-container").children("input[value='" + $(this).children("a").attr("data-id") + "']").length == 0) {
                    $(this).removeAttr("hidden");
                } else {
                    $(this).attr("hidden", true);
                }
            })
        }



        $("#category-name-input").on("keyup", function () {
            showOptions(true)
        })

        $("#category-toggler").on("click", function () {
            showOptions(false)
        })

        function addCategory(id, name) {
            $("#category-container").append("<input id='category-" + id + "' type='number' name='id_categoria[]' value='" + id + "' hidden>");
            $("#category-container").append("<span data-id='" + id + "' class='btn btn-primary rounded-5 shadow-sm'>" + name + "</span>").children("[data-id='" + id + "']").click(deleteButton)
            $("#category-name-input").val("");

            if ($("#category-container").children("span").length >= 4) { $("#category-name-input").attr("disabled", true); $(".category-select-option").addClass("disabled"); }
            else $("#category-name-input").attr("disabled", false);


        }


        $(".category-select-option").click(function () {
            addCategory($(this).attr("data-id"), $(this).html())
            $(this).parent().attr("hidden", true)
        })


        function isStringIncluded(mainString, searchString) {
            // Convert both strings to lowercase for case-insensitive comparison
            mainString = mainString.toLowerCase();
            searchString = searchString.toLowerCase();

            // Check if the mainString includes the searchString
            return mainString.includes(searchString);
        }

        $("#category-container").children("span").click(deleteButton)

        $("#add-category-button").click(function () {
            //<input id="category-1" type="number" name="id_categoria[]" value="" hidden>
            //<span class="btn btn-primary rounded-5 shadow-sm"><a><i class="fa-solid fa-minus fs-6"></i></a>&nbsp;Acción</span>
            //id=category-container

            const catName = $("#category-name-input").val();
            $(".category-select-option").each(function () {
                if (catName == $(this).html()) {
                    addCategory($(this).attr("data-id"), $(this).html())
                    $(this).parent().attr("hidden", true);
                }
            });
        })

        showOptions(false)
    });



    function deleteButton(e) {
        $("#category-" + $(this).attr("data-id")).remove()
        $("#category-name-input").attr("disabled", false)
        $(".category-select-option").removeClass("disabled")
        $(this).remove()
    }

    function deleteElement(e) {
        $(this).parent().delete();
    }


</script>
<?php
include ("include/footer.php");
?>

<script>
    /*
    $(".image-upload").on('change', function () {
        console.log(this.files);
        if (this.files && this.files[i]) {
            var reader = new FileReader(); //$(this).siblings('.profile-pic');
            reader.onload = function (e) {
                screenshotScroller.add("<li class='splide__slide rounded-5 overflow-hidden'><img class='' src='"+e.target.result+"'></li>");
                //$(".splide__list").append(newImg);
                //profilePic.attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[i]);
            this.files = undefined;
        }
    });*/
</script>