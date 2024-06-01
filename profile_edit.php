<?php
$navSelection = 1;
include_once ("include/connect_session.php");
$id = $_GET["id"];
if (!logged || userId != $id)
    header("Location: home.php");
include ("include/header.php");

$query = "SELECT nombre, sobre_mi, foto_perfil, correo_electronico FROM usuarios WHERE id=?";
$usuarioData = mysqli_fetch_assoc(db::mysqliExecuteQuery($conn, $query, "s", array($id)));
?>

<article class="container px-4 px-md-5 py-3 gap-2 flex-grow-1">
    <div class="row">
        <div class="col-sm-4 col-md-3">
            <nav id="config-navbar" class="flex-column align-items-stretch pe-4">
                <h4>Configuración</h4>
                <nav class="nav nav-pills flex-column">
                    <a class="nav-link rounded-5 active" data-bs-toggle="tab" data-bs-target="#tab-1" type="button"
                        role="tab">Mi perfil</a>
                    <a class="nav-link rounded-5" data-bs-toggle="tab" data-bs-target="#tab-2" type="button"
                        role="tab">Seguridad</a>
                    <a class="nav-link rounded-5" data-bs-toggle="tab" data-bs-target="#tab-3" type="button"
                        role="tab">Ajustes</a>
                </nav>
            </nav>
        </div>

        <div class="col-sm-8 col-md-9 tab-content">

            <div class="tab-pane active" id="tab-1" role="tabpanel">
                <form action="php_tasks/profile_save.php" method="post" enctype='multipart/form-data'>
                    <section class="d-flex flex-column gap-2 text-start">
                        <div class="d-flex justify-content-center">
                            <div class="position-relative rounded-circle">
                                <img class="rounded-circle profile-pic overflow-hidden" width="150" height="150"
                                        src="<?=$usuarioData["foto_perfil"]?>">
                                <input name="foto_perfil" class="d-none file-upload" type="file" accept="image/*" onchange=""/>   
                                <div class="position-absolute top-100 start-100 translate-middle" onclick="$(this).siblings('.file-upload').click()">
                                    <i class="fa fa-camera upload-button fs-2 pb-5 pe-4"></i>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="usuarioInput" class="form-label">Nombre de usuario:</label>
                            <input name="usuario" value="<?=$usuarioData["nombre"]?>" id="usuarioInput" type="text" class="form-control">
                        </div>

                        <div>
                            <label for="sobreMiInput" class="form-label">Sobre mí:</label>
                            <textarea name="sobre_mi" id="sobreMiInput" type="text"
                                class="form-control" rows="4"><?=$usuarioData["sobre_mi"]?></textarea>
                        </div>

                        <div>
                            <label for="emailInput" class="form-label">Correo electrónico:</label>
                            <input name="email" value="<?=$usuarioData["correo_electronico"]?>" id="emailInput" type="email" class="form-control">
                        </div>

                        <input type="hidden" name="id" value="<?= $id ?>">
                        <button class="btn btn-primary"><i class="fa-solid fa-save"></i>&nbsp;Guardar</button>
                    </section>
                </form>
            </div>

            <div class="tab-pane" id="tab-2" role="tabpanel">
            </div>

            <div class="tab-pane" id="tab-3" role="tabpanel">
            </div>
        </div>
    </div>

</article>
<?php
include ("include/footer.php");
?>

<script>
    $(".file-upload").on('change', function(){
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            var profilePic = $(this).siblings('.profile-pic');
            reader.onload = function (e) {
                profilePic.attr('src', e.target.result);
            }
                                    
            reader.readAsDataURL(this.files[0]);
                                        }
            });
</script>     