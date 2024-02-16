<?php
    $navSelection = 1;
    include("include/header.php");
    include("include/connect.php");
    include("include/session.php");
    $maxPages = 10;
    $page = 1;
?>

<article class="container px-4 px-md-5 py-3 align-items-center d-flex flex-column gap-2">
    
    <section class="bg-black" style="width: 100%; height: 360px">

    </section>

    <section class="d-flex flex-column gap-2 text-start align-self-center border rounded-5 p-4 container">

        <div class="d-flex flex-column justify-content-center">
            <a type="button" class="btn btn-lg btn-outline-success rounded-3 rounded-bottom-0" href="#"><i class="fa-solid fa-download"></i>
                        Descargar (XX MB)
            </a>
            <div class="w-100 bg-secondary text-white text-end p-2 rounded-3 rounded-top-0">
                    <i class="fa-brands fa-windows"></i>
                    <i class="fa-brands fa-apple"></i>
                    <i class="fa-brands fa-linux"></i>
                    <i class="fa-brands fa-android"></i>
                    <i class="fa-solid fa-globe"></i>
            </div>    
        </div>
        
        <h1>Lorem Ipsum</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum nulla repellendus, deleniti et, quo a eaque quisquam earum praesentium quae illo voluptates, dolor alias nam dolorum pariatur sapiente. In, porro?</p>
        <h4>Capturas de pantalla:</h4>
        <div class="gap-1 d-flex flex-row align-items-center">
            <i class="btn btn-primary rounded-circle fa-solid fa-arrow-left p-1"></i>
            <div class="d-flex flex-row gap-2 overflow-x-scroll flex-grow-1 scroller pb-3 px-2" data-scrolling-value=238>
                <?php for ($i=1; $i < 10; $i++) {?>
                
                <img class="bg-body rounded-4 col-3"  src="https://img.freepik.com/foto-gratis/equipo-videojuegos-futurista-iluminado-ia-generativa-discoteca_188544-32105.jpg?size=626&ext=jpg&ga=GA1.1.1880011253.1700524800&semt=ais" style="width:230px">
                <?php }?>
            </div>
            <i class="btn btn-primary rounded-circle fa-solid fa-arrow-right p-1"></i>
        </div>
        <h4>Autor: </h4>
        <a href="#">
            <img width="40" height="40">
            El señor de los anillos
        </a>
        <br>
        <h4>Comentarios: </h4>
        <div>
            <textarea class="form-control" placeholder="Escribe un comentario aquí..."></textarea>
        </div>
        <br>

        <!---Comentarios--->
        <div class="d-flex gap-2">
            <img width="40" height="40">
            <div class="flex-grow-1">
                <a href="#">
                    El señor de los anillos
                </a>
                <br>

                <span>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum dolorem placeat error blanditiis odit, iusto tempora iure. Et autem fugit quos, sequi esse nostrum aperiam tenetur facilis officiis nemo dignissimos?
                </span>
                <div>
                    <i class="btn btn-lg  fa-solid fa-thumbs-up p-0 border-0" data-bs-toggle="button"></i>
                    <i class="btn btn-lg fa-solid fa-flag p-0 border-0" data-bs-toggle="button"></i>
                </div>
            </div>
        </div>
        <div class="d-flex gap-2">
            <div class="bg-white" style="width:40px; height:40px;"></div>
            <div class="flex-grow-1">
                <a class="placeholder-glow" href="#">
                <span class="placeholder col-7"></span>
                </a>
                <br>

                <span class="placeholder-glow">
                    <span class="placeholder col-7"></span>
                    <span class="placeholder col-4"></span>
                    <span class="placeholder col-4"></span>
                    <span class="placeholder col-6"></span>
                    <span class="placeholder col-8"></span>
                </span>
                <div>
                    <i class="btn btn-lg  fa-solid fa-thumbs-up p-0 border-0" data-bs-toggle="button"></i>
                    <i class="btn btn-lg fa-solid fa-flag p-0 border-0" data-bs-toggle="button"></i>
                </div>
            </div>
        </div>
        
    </section>
    
</article>
<?php
    include("include/footer.php");
?>