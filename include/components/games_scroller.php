<?php
class GamesScroller
{
    protected array $gamesList = array();

    public function addGame(GameCards $juego)
    {
        array_push($this->gamesList, $juego);
    }

    public function echo()
    {
        ?>
        <div class="splide game-scroller py-0">
            <div class="splide__arrows">
                <button class="splide__arrow splide__arrow--prev">
                    <i class="btn btn-primary rounded-circle fa-solid fa-arrow-left p-1"></i>
                </button>
                <button class="splide__arrow splide__arrow--next">

                    <i class="btn btn-primary rounded-circle fa-solid fa-arrow-right p-1"></i>
                </button>
            </div>
            <div class="splide__track" style="height: 300px;">
                <ul class="splide__list">
                    <!--Display de juegos--->
                    <?php foreach ($this->gamesList as $game) {?>
                        <li class="splide__slide p-1"><?php $game->echo(); ?></li>
                    <?php } ?>
                </ul>
            </div>

        </div>
<?php
    }

}

?>