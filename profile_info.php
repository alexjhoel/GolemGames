<?php
    $navSelection = 1;
    include("include/header.php");
    $maxPages = 10;
    $page = 1;

    $query = "SELECT nombre, sobre_mi, foto_perfil FROM usuarios WHERE id=?";
    $userData = mysqli_fetch_assoc(db::mysqliExecuteQuery($conn, $query,"s",array($_GET["id"])));
?>

<article class="container px-4 px-md-5 py-3 align-items-center d-flex flex-column gap-2">
    
    <section class="card d-flex flex-column gap-2 text-start align-self-center rounded-5 p-4 container overflow-hidden">
        <!---Información de usuario--->
        <div class="d-flex gap-3">
            <img width="150" height="150" src="<?=$userData["foto_perfil"]?>">
            <div>
                <div class="row">
                     <h1 class="m-0 col-auto"><?=$userData["nombre"]?></h1>
                </div>
                <br>
                <a class="btn btn-primary"><i class="fa-solid fa-user-plus"></i>&nbsp;Solicitud de amistad</a>
                <button role="button" class="btn"><i class="fa-solid fa-paper-plane"></i>&nbsp;Solicitud enviada</button>
                

                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <button role="button" class="btn btn-primary"><i class="fa-solid fa-comment"></i>&nbsp;Mensaje</button>
                    <a class="btn btn-danger"><i class="fa-solid fa-user-xmark"></i>&nbsp;</a>
                </div>

            </div>
        </div>
        <h4>Sobre mí:</h4>
        <p><?=$userData["sobre_mi"]?></p>
        <a class="btn btn-primary position-absolute top-0 end-0 rounded-5 rounded-top-0 rounded-end-0 ps-4 pe-4 py-2" href="edit_client_info.php?id=<?=$_GET["id"]?>"><i class="fa-solid fa-pen"></i></a>
    </section>

    <section class="text-start py-2 container">
        <h3><i class="fas fa-gamepad fa-sm"></i>&nbsp;Mis juegos</h3>
        <div class="gap-1 d-flex flex-row align-items-center">
            <i class="btn btn-primary rounded-circle fa-solid fa-arrow-left p-1"></i>
            <div class="d-flex flex-row gap-2 overflow-x-scroll flex-grow-1 scroller pb-3 px-2" data-scrolling-value=238>
                <?php for ($i=1; $i < 10; $i++) {?>
                
                <a class="bg-body rounded-5 col-3 d-flex flex-column align-items-start btn shadow-sm p-2 <?php if($i==1) echo 'active-scroller-item'?>" style="width:230px" href="">
                    <img class="rounded-3 w-100" src="https://img.freepik.com/foto-gratis/equipo-videojuegos-futurista-iluminado-ia-generativa-discoteca_188544-32105.jpg?size=626&ext=jpg&ga=GA1.1.1880011253.1700524800&semt=ais">
                    <span class="fs-5 text-secondary-emphasis">Juego de ejemplo #<?=$i?></span>
                    <div class="d-flex w-100 gap-2">
                        <div class="text-secondary">
                            <i class="fa-solid fa-eye"></i>
                            <span>999</span>
                        </div>
                        <div class="text-secondary">
                            
                        <i class="fa-solid fa-thumbs-up"></i>
                            <span>999</span>
                        </div>
                    </div>
                </a>
                <?php }?>
            </div>
            <i class="btn btn-primary rounded-circle fa-solid fa-arrow-right p-1"></i>
        </div>
    </section>
    
</article>
<?php
    include("include/footer.php");
?>