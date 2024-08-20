<?php
include_once ("include/connect_session.php");
include_once ("include/definitions.php");

$navSelection = 0;
$access_level_required = LOGGED_REQUIRED;

include ("include/header.php");

if (access_level == ADMIN_REQUIRED && is_GET_set("id")) {
    $userId = $_GET["id"];
} else {
    $userId = userId;
}

$query = "SELECT nombre, sobre_mi, foto_perfil, correo_electronico FROM usuarios WHERE id=?";
$usuarioData = mysqli_fetch_assoc(db::mysqliExecuteQuery($query, "s", array($userId)));
?>

<article class="container px-4 px-md-5 py-3 gap-2 flex-grow-1">
    <div class="row">
        <div class="col-sm-4 col-md-3">
            <nav id="config-navbar" class="flex-column align-items-stretch pe-4">
                <h4>Configuración</h4>
                <nav class="nav nav-pills flex-column">
                    <a class="nav-link rounded-5 active" data-bs-toggle="tab" data-bs-target="#tab-1" type="button"
                        role="tab">Mi perfil</a>
                </nav>
            </nav>
        </div>

        <div class="col-sm-8 col-md-9 tab-content">

            <div class="tab-pane active" id="tab-1" role="tabpanel">
                <form class="form-validator d-flex flex-column gap-2 text-start" method="POST"
                    action="./php_tasks/profile_save.php" validate-method="POST"
                    validate-action="./php_tasks/profile_save.php?validate=1" novalidate enctype='multipart/form-data'>

                    <div class="d-flex justify-content-center">
                        <div class="position-relative rounded-circle">
                            <img id="profile-pic" class="rounded-circle profile-pic overflow-hidden" width="150" height="150"
                                src="<?= $usuarioData["foto_perfil"] ?>">
                            <input id = "image-upload" name="foto_perfil" class="d-none file-upload" type="file" accept="image/*"
                                onchange="" />
                            <div class="position-absolute top-100 start-100 translate-middle"
                                onclick="$(this).siblings('.file-upload').click()">
                                <i class="fa fa-camera upload-button fs-2 pb-5 pe-4"></i>
                            </div>
                        </div>
                    </div>

                    <div class="w-100">
                        <input name="foto_perfil_feedback" value="1" type="hidden">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div>
                        <label for="usuarioInput" class="form-label">Nombre de usuario:</label>
                        <input name="usuario" value="<?= $usuarioData["nombre"] ?>" id="usuarioInput" type="text"
                            class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div>
                        <label for="sobreMiInput" class="form-label">Sobre mí:</label>
                        <textarea name="sobre_mi" id="sobreMiInput" type="text" class="form-control" rows="4"
                            maxlength="201"><?= $usuarioData["sobre_mi"] ?></textarea>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div>
                        <label for="emailInput" class="form-label">Correo electrónico:</label>
                        <input name="correo" value="<?= $usuarioData["correo_electronico"] ?>" id="emailInput"
                            type="email" class="form-control">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center">
                        <button class="btn btn-primary"><i class="fa-solid fa-save"></i>&nbsp;Guardar</button>
                        <a class="btn btn-danger" href="php_tasks/profile_delete.php?id=<?=$userId?>"><i class="fa-solid fa-trash"></i>&nbsp;Borrar cuenta</a>
                    </div>
                </form>
            </div>

            <div class="tab-pane" id="tab-2" role="tabpanel">
            </div>

            <div class="tab-pane" id="tab-3" role="tabpanel">
            </div>
        </div>
    </div>
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

<?php
include ("include/footer.php");
?>

<script>
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
                aspectRatio: 1/1,
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

                canvas.toBlob(function (blob) {
                    let file = new File([blob], "img.jpg", { type: "image/jpeg", lastModified: new Date().getTime() });

                    let container = new DataTransfer();

                    container.items.add(file);
                    $("#image-upload")[0].files = container.files;

                    var profilePic = $('#profile-pic');
                    
                    profilePic.attr('src', URL.createObjectURL(blob));

                });
            }
        });
    })
</script>