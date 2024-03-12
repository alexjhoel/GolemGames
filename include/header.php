<?php
include("vendor/autoload.php");
include("session.php");
if (!isset($navSelection))
  $navSelection = 0;
?>
<html lang="en" data-bs-theme="light">

<head>
  <meta name="author" content="Golem S.A.">
  <meta name="description" content="Empty">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta charset="utf-8">
  <title>UTU Games</title>
  <link rel="icon" type="image/x-icon" href="assets/images/logo.svg">

  <link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css?t=<?= time() ?>">
  <link href="assets/fontawesome/css/fontawesome.css" rel="stylesheet">
  <link href="assets/fontawesome/css/brands.css" rel="stylesheet">
  <link href="assets/fontawesome/css/solid.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/styles/main.css?t=<?= time() ?>">
</head>

<body class="d-flex flex-column h-100">

  <nav class="navbar navbar-expand-lg shadow-sm sticky-top p-0 bg-body">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="assets/images/logo1.png" width="80px">
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
            <a class="nav-link <?php if ($navSelection == 2) { ?>active <?php } ?>" href="chats.php"><i
                class="fa-solid fa-comment"></i> Salas de chat</a>
          </li>
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              <i class="fa-solid fa-user"></i> Mi cuenta
            </a>

            <ul class="dropdown-menu dropdown-menu-end px-2 py-1">

              <li><a class="dropdown-item rounded my-1" href="#"><i class="fa-solid fa-upload"></i>&nbsp;&nbsp;Subir un juego</a></li>

              <li><a class="dropdown-item rounded my-1" href="#"><i class="fa-solid fa-user"></i>&nbsp;&nbsp;Mi perfil</a></li>
              
              <li><a class="dropdown-item rounded my-1" href="#"><i class="fa-solid fa-gear"></i>&nbsp;&nbsp;Configuración</a></li>

              <li><a class="dropdown-item rounded my-1 btn btn-danger" href="#"><i class="fa-solid fa-right-from-bracket"></i>&nbsp;&nbsp;Cerrar sesión</a></li>


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


              <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="pills-home-tab"
                tabindex="0">
                <div class="d-flex flex-column align-items-center gap-3">

                  <i class="fa-solid fa-user" style="font-size: 7em;"></i>

                  <div class="form-floating w-100">
                    <input type="email" class="form-control rounded-pill" id="userLoginInput" placeholder="name@example.com">
                    <label for="userLoginInput">Usuario</label>
                  </div>

                  <div class="form-floating w-100">
                    <input type="password" class="form-control rounded-pill" id="passwordLoginInput" placeholder="Password">
                    <label for="passwordLoginInput">Contraseña</label>
                  </div>

                  <input type="submit" class="btn btn-primary rounded-pill" value="Iniciar sesión">

                  </div>
              </div>

            <!---Registrarse formulario--->

              <div class="tab-pane fade align-items-center gap-2" id="pills-register" role="tabpanel" aria-labelledby="pills-home-tab"
                tabindex="0">
                <div class="d-flex flex-column align-items-center gap-3">

                  <div class="form-floating w-100">
                    <input type="email" class="form-control rounded-pill" id="userRegisterInput" placeholder="name@example.com">
                    <label for="userRegisterInput">Usuario</label>
                  </div>

                  <div class="form-floating w-100">
                    <input type="password" class="form-control rounded-pill" id="emailRegisterInput" placeholder="Password">
                    <label for="emailRegisterInput">Correo electrónico</label>
                  </div>

                  <div class="form-floating w-100">
                    <input type="password" class="form-control rounded-pill" id="passwordRegisterInput" placeholder="Password">
                    <label for="passwordRegisterInput">Contraseña</label>
                  </div>

                  <div class="form-check">
                    <input name="termsChecked" class="form-check-input" type="checkbox" id="terms" required>
                    <label class="form-check-label" for="terms">
                      He leído y acepto los <a class="link" target="_blank" href="https://support.wix.com/es/article/crear-una-política-de-términos-y-condiciones">términos y condiciones de servicio.</a>
                    </label>
                  </div>

                  <input type="submit" class="btn btn-primary rounded-pill" value="Crear cuenta">
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
    </div>


  