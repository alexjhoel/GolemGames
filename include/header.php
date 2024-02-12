<?php
include("vendor/autoload.php");
if(!isset($navSelection)) $navSelection = 0;
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
            <a class="nav-link <?php if($navSelection == 0) {?>active"<?php }?> aria-current="page" href="home.php"><i class="fa-solid fa-home"></i> Página
              principal</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($navSelection == 1) {?>active"<?php }?>" href="games.php"><i class="fa-solid fa-gamepad"></i> Juegos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($navSelection == 2) {?>active"<?php }?>" href="chats.php"><i class="fa-solid fa-comment"></i> Salas de chat</a>
          </li>
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              <i class="fa-solid fa-user"></i> Mi cuenta
            </a>
            <ul class="dropdown-menu dropdown-menu-end px-2 py-1" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item rounded my-1" href="#">Iniciar sesión</a></li>
              <li><a class="dropdown-item rounded my-1" href="#">Registrarse gratis</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              <i class="fa-solid fa-sun"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end px-2 py-1" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item rounded my-1" data-bs-theme-value="light" href="#"><i class="fa-solid fa-sun"></i> Claro</a></li>
              <li><a class="dropdown-item rounded my-1" data-bs-theme-value="dark" href="#"><i class="fa-solid fa-moon"></i> Oscuro</a></li>
            </ul>
          </li>

        </ul>
      </div>
    </div>
  </nav>