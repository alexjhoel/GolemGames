<?php
    include("include/header.php");
    include("include/connect.php");
    include("include/session.php");
?>

<article class="container p-3 text-center overflow-hidden">
    <section class="row p-5 shadow-sm align-items-center text-black title-banner rounded" style="background-image: linear-gradient(rgba(255,255,255,0.5), rgba(255,255,255,0.5)), url(https://images.unsplash.com/photo-1606160429008-751d8408a874?q=80&w=1000&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8N3x8cHM1JTIwY29udHJvbGxlcnxlbnwwfHwwfHx8MA%3D%3D)">
        <h3><strong>Encuentra tu juego favorito en UTU Games</strong></h2>
        <p>Descubre los mejores proyectos de videojuegos creados por alumnos de UTU</p>
    </section>

    <section class="mx-5 px-5 py-1 home-search-bar">
        <form action="" method="get">
            <div class="input-group">
                <input type="search" class="form-control rounded-start" placeholder="Buscar entre cientos de juegos!" />
                <span class="input-group-text border-0">
                    <i class="fas fa-search"></i>
                </span>
            </div>
        </form>
    </section>
</article>

<?php
    include("include/footer.php");
?>