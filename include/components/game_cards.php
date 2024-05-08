<?php
    class GameCards{
        public int $id;
        public String $titulo;
        public String $autor;
        public int $likes;
        public int $vistas;
        public array $linksCapturas;

        public function echo(){
            ?>
                <div class="col d-flex justify-content-center">
                    <a class="bg-body rounded-5 col-3 d-flex flex-column align-items-start btn shadow-sm p-2 game-card" 
                        style="width:230px;" 
                        href="game_info.php?id=<?=$this->id?>">
                        <div class="carousel-fade" data-interval="2000">
                            <div class="carousel-inner">
                                <?php
                                $first = true;
                                foreach($this->linksCapturas as $link){
                                    ?>
                                    <div class="d-block carousel-item <?= $first ? 'active' : ''?> rounded-3 overflow-hidden" style="width:212px; height: 135px">
                                        <img src="<?=$link?>?t=<?=time()?>" class="w-100 position-absolute top-50 start-50 translate-middle" alt="">
                                    </div>
                                    <?php
                                    $first = false;
                                }
                                ?>
                            </div>
                        </div>
                        <span class="fs-5 text-secondary-emphasis">
                            <?=$this->titulo?>
                        </span>
                        <span class="fs-6 text-secondary">
                            <?=$this->autor?>
                        </span>
                        <div class="d-flex w-100 gap-2">
                            <div class="text-secondary">
                                <i class="fa-solid fa-eye"></i>
                                <span>
                                    <?=$this->vistas?>
                                </span>
                            </div>
                            <div class="text-secondary">
                                <i class="fa-solid fa-thumbs-up"></i>   
                                <span>
                                    <?=$this->likes?>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php
        }
        
    }

?>