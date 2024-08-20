<?php
include_once ("vendor/autoload.php");
include_once ("connect_session.php");
include_once ("components.php");
include_once ("include/definitions.php");


if (!isset($navSelection))
  $navSelection = 0;

if(!isset($access_level_required))
  $access_level_required = 0;

//Chequeo de rango de usuario
if($access_level_required >= LOGGED_REQUIRED && !(logged && access_level >= $access_level_required)) {
  session::info_message("Acceso restringido", "danger");
  header("Location: home.php");
  exit();
}

?>
<html lang="en" data-bs-theme="light">

<head>
  <meta name="author" content="Golem S.A.">
  <meta name="description" content="Empty">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta charset="utf-8">
  <title>Golem | Online Games</title>
  <link rel="icon" type="image/x-icon" href="assets/images/logo1.png?t=1">

  <link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css?t=<?= time() ?>">
  <link href="assets/fontawesome/css/fontawesome.css" rel="stylesheet">
  <link href="assets/fontawesome/css/brands.css" rel="stylesheet">
  <link href="assets/fontawesome/css/solid.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/styles/main.css?t=<?= time() ?>">
  <link rel="stylesheet" href="assets/splide/splide.min.css">
  <link rel="stylesheet" href="assets/cropper/cropper.min.css">
</head>

<body class="d-flex flex-column vh-100">
<?php if(logged && access_level >=ADMIN_REQUIRED) {?>
  <div class="position-fixed bottom-0 end-0 p-3"><a class="rounded-5 btn btn-info py-3 px-3" href="edit_home.php"><i class="fa-solid fa-pen"></i></a></div> 
<?php }?>
  <nav class="navbar navbar-expand-lg shadow-sm sticky-top p-0 bg-body flex-shrink-1">
    <div class="container-fluid">
      <a class="navbar-brand" href="./">
        <img src="assets/images/logo1.png?t=1" width="80px">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
        aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link <?php if ($navSelection == 0) { ?>active <?php } ?>" aria-current="page"
              href="home.php"><i class="fa-solid fa-home"></i> Página
              principal</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if ($navSelection == 1) { ?>active <?php } ?>" href="games.php"><i
                class="fa-solid fa-gamepad"></i> Juegos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if ($navSelection == 2) { ?>active <?php } ?>" <?php if(logged) {?>href="chats.php" <?php } else {?> data-bs-toggle="modal"
              data-bs-target="#loginModal" <?php }?>><i
                class="fa-solid fa-comment"></i> Salas de chat</a>
          </li>
        </ul>
        <ul class="navbar-nav">

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              <i class="fa-solid fa-user"></i> <?php if (logged)
                echo username;
              else
                echo 'Mi cuenta'; ?>
            </a>

            <ul class="dropdown-menu dropdown-menu-end px-2 py-1">
              <?php
              if (logged) {
                ?>
                <li><a class="dropdown-item rounded my-1" href="game_upload.php"><i class="fa-solid fa-upload"></i>&nbsp;&nbsp;Subir un juego</a></li>

                <li><a class="dropdown-item rounded my-1" href="profile_info.php?id=<?= userId ?>"><i
                      class="fa-solid fa-user"></i>&nbsp;&nbsp;Mi perfil</a></li>

                <li><a class="dropdown-item rounded my-1" href="profile_edit.php"><i
                      class="fa-solid fa-gear"></i>&nbsp;&nbsp;Configuración</a></li>

                <li><a class="dropdown-item rounded my-1 btn btn-danger" href="./php_tasks/logoff.php"><i
                      class="fa-solid fa-right-from-bracket"></i>&nbsp;&nbsp;Cerrar sesión</a></li>

                <?php
              } else {
                ?>
                <li><a type="button" class="dropdown-item rounded my-1" data-bs-toggle="modal"
                    data-bs-target="#loginModal" id="myaccountLoginButton">&nbsp;&nbsp;Iniciar sesión</a></li>

                <li><a type="button" class="dropdown-item rounded my-1" data-bs-toggle="modal"
                    data-bs-target="#loginModal" id="myaccountRegisterButton">&nbsp;&nbsp;Registrarse</a></li>
              <?php } ?>

            </ul>

          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              <i class="fa-solid fa-sun"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end px-2 py-1" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item rounded my-1" data-bs-theme-value="light" href="#"><i
                    class="fa-solid fa-sun"></i> Claro</a></li>
              <li><a class="dropdown-item rounded my-1" data-bs-theme-value="dark" href="#"><i
                    class="fa-solid fa-moon"></i> Oscuro</a></li>
            </ul>
          </li>

        </ul>
      </div>
    </div>


  </nav>

  <div class="modal fade" tabindex="-1" id="loginModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
          <ul class="d-flex justify-content-center nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active shadow-sm rounded-start-pill" id="loginTab" data-bs-toggle="pill"
                data-bs-target="#pills-login" type="button" role="tab" aria-controls="pills-home"
                aria-selected="true">Iniciar sesión</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link shadow-sm rounded-end-pill" id="registerTab" data-bs-toggle="pill"
                data-bs-target="#pills-register" type="button" role="tab" aria-controls="pills-profile"
                aria-selected="false">Registrarse</button>
            </li>
          </ul>
          <div class="tab-content" id="pills-tabContent">

            <!---Iniciar sesión formulario--->

            <form 
              id="pills-login"
              role="tabpanel"  
              class="tab-pane fade show active form-validator" 
              method="post" 
              action="./php_tasks/login.php" 
              validate-method="post" 
              validate-action="./php_tasks/login.php?validate=1" 
              novalidate
            >
                <div class="d-flex flex-column align-items-center gap-3">

                  <i class="fa-solid fa-user" style="font-size: 7em;"></i>

                  <div class="form-floating w-100">
                    <input type="text" class="form-control rounded-pill" name="usuario"
                      placeholder="name@example.com">
                    <label for="userLoginInput">Nombre de usuario o correo electrónico</label>
                    <div class="invalid-feedback">
                      &nbsp;No existe ese nombre de usuario o correo electrónico.
                    </div>
                  </div>

                  <div class="form-floating w-100">
                    <input type="password" class="form-control rounded-pill" name="clave"
                      placeholder="Password">
                    <label for="passwordLoginInput">Contraseña</label>
                    <div class="invalid-feedback">
                      &nbsp;Contraseña incorrecta
                    </div>
                  </div>
                  <button class="btn btn-primary rounded-pill">Iniciar sesion</button>

                </div>
            </form>

            <!---Registrarse formulario--->
            <form  
              id="pills-register"
              role="tabpanel"  
              class="tab-pane fade show form-validator" 
              method="POST" 
              action="./php_tasks/register.php" 
              validate-method="POST" 
              validate-action="./php_tasks/register.php?validate=1" 
              novalidate
            >
                <div class="d-flex flex-column align-items-center gap-3">

                  <div class="form-floating w-100">
                    <input type="text" class="form-control rounded-pill" name="usuario"
                      placeholder="name@example.com">
                    <label for="userRegisterInput">Usuario</label>
                    <div class="invalid-feedback">
                      &nbsp;Usuario incorrecto
                    </div>
                  </div>

                  <div class="form-floating w-100">
                    <input type="email" class="form-control rounded-pill" name="correo"
                      placeholder="email">
                    <label for="emailRegisterInput">Correo electrónico</label>
                    <div class="invalid-feedback">
                      &nbsp;No existe ese nombre de usuario o correo electrónico.
                    </div>
                  </div>

                  <div class="form-floating w-100">
                    <input type="password" class="form-control rounded-pill" name="clave"
                      placeholder="Password">
                    <label for="passwordRegisterInput">Contraseña</label>
                    <div class="invalid-feedback">
                      &nbsp;Contraseña incorrecta
                    </div>
                  </div>

                  <div class="form-check">
                    <input name="terminos" class="form-check-input" type="checkbox">
                    <label class="form-check-label" for="terminos">
                      He leído y acepto los <a class="link" target="_blank"
                        href="../terms.php">términos
                        y
                        condiciones de servicio.</a>
                    </label>
                  </div>
                  <button class="btn btn-primary rounded-pill">Registrarse</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php if(session::is_set("message")){?>
  <div class="container p-2">
    <div class="alert alert-<?=session::get("message_type")?> alert-dismissible fade show" role="alert">
      <?=session::get("message")?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>
  <?php session::unset("message"); session::unset("message_type"); } ?>