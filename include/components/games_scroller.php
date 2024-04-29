<?php
class GamesScroller
{
    protected array $listaJuegos = array();

    public function agregarJuego(GameCards $juego){
        array_push($this->listaJuegos, $juego);
    }

    public function echo()
    {
        ?>
        <div class="splide game-scroller d-flex flex-row align-items-center py-0">
            <div class="splide__arrows">
                <button class="splide__arrow splide__arrow--prev">
                    <i class="btn btn-primary rounded-circle fa-solid fa-arrow-left p-1"></i>
                </button>
                <button class="splide__arrow splide__arrow--next">

                    <i class="btn btn-primary rounded-circle fa-solid fa-arrow-right p-1"></i>
                </button>
            </div>
            <div class="splide__track">
                <ul class="splide__list">
                    <!--Display de juegos--->
            <?php foreach ($this->listaJuegos as $juego) {
                ?>
            <li class="splide__slide p-1">
                <a class="bg-body rounded-5 d-flex flex-column align-items-start btn shadow-sm p-2 game-card"
                    href="game_info.php?id=<?=$juego->id?>">
                    <div class="carousel-fade" data-interval="2000">
                        <div class="carousel-inner">
                            <div class="d-block carousel-item active rounded-3 overflow-hidden">
                                <?php foreach($juego->linksCapturas as $link){?>
                                    <img src="<?=$link?>?t=<?=time()?>">
                                <?php }
                                ?>
                            </div>
                        </div>
                    </div>
                    <span class="fs-5 text-secondary-emphasis">
                        <?=$juego->titulo?>
                    </span>
                    <span class="fs-6 text-secondary">
                    <?=$juego->autor?>
                    </span>
                    <div class="d-flex w-100 gap-2">
                        <div class="text-secondary">
                            <i class="fa-solid fa-eye"></i>
                            <span>
                                <?=$juego->vistas?>
                            </span>
                        </div>
                        <div class="text-secondary">
                            <i class="fa-solid fa-thumbs-up"></i>
                            <span>
                                <?=$juego->likes?>
                            </span>
                        </div>
                    </div>
                </a>
            </li>
            <?php
            } ?>

        </ul>
    </div>

</div>
<?php
    }

}

?>