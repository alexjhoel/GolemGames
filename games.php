<?php
    $navSelection = 1;
    include("include/header.php");
    include("include/connect.php");
    $maxPages = 10;
    $page = 1;
?>

<article class="container px-4 px-md-5 py-3 text-center d-flex flex-column gap-2">

    <!--Barra de busqueda de home--->
    <section class="mx-2 mx-lg-5 px-2 px-lg-5">
        <form action="" method="get">
            <div class="input-group rounded-5 shadow-sm bg-body overflow-hidden">
                <input type="text" class="form-control rounded-start border-0 shadow-none fs-5" placeholder="Buscar entre cientos de juegos!" />
                <button class="btn border-0" data-bs-toggle="collapse" data-bs-target="#search-filters">
                    <i class="fas fa-sliders"></i>
                </button>
                <button type="submit" class="btn btn-primary border-0">
                    <i class="fas fa-search"></i>
                </button>

                <div class="collapse" id="search-filters">
                    <div class="container">
                    Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.
                    </div>
                </div>
            </div>
        </form>
    </section>

    <section class="text-start align-self-center">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-2">
            <?php for ($i=1; $i < 10; $i++) {?>
                <div class="col d-flex justify-content-center">
                <a class="bg-body rounded-5 col-3 d-flex flex-column align-items-start btn shadow-sm p-2" style="width:230px" href="">
                    <img class="rounded-3 w-100" src="https://img.freepik.com/foto-gratis/equipo-videojuegos-futurista-iluminado-ia-generativa-discoteca_188544-32105.jpg?size=626&ext=jpg&ga=GA1.1.1880011253.1700524800&semt=ais">
                    <span class="fs-5 text-secondary-emphasis">Juego de ejemplo #<?=$i?></span>
                    <span class="fs-6 text-secondary">Por juegos sosa</span>
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
                </div>
                
                <?php }?>
        </div>
    </section>
    
</article>

<nav class="container d-flex justify-content-center">
    <ul class="pagination justify-content-center shadow-sm " style="width:fit-content;">
        <li class="page-item   <?=$page < 2 ? 'disabled' : ''?>">
            <button type="submit" form="clients-search" class="page-link border-0 rounded-start-pill" name="page" value=<?=$page - 1?>><i class="fa-solid fa-caret-left fa-xl"></i>&nbsp;</button>
        </li>
        <?php for ($i=1; $i < $maxPages + 1; $i++) { ?>
            <li class="page-item <?= $i==$page ? 'active' : '' ?>">
                <button type="submit" form="clients-search" class="page-link border-0" name="page" value=<?=$i?>>
                    <?=$i?>
                </button>
            </li>
        <?php }?>
        <li class="page-item <?=$page < $maxPages ? '' : 'disabled'?>">
            <button type="submit" form="clients-search" class="page-link border-0 rounded-end-circle" name="page" value=<?=$page + 1?>>&nbsp;<i class="fa-solid fa-caret-right fa-xl"></i></button>
        </li>
    </ul>
</nav>

<?php
    include("include/footer.php");
?>