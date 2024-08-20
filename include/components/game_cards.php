<?php
    class GameCards{
        public $id;
        public String $titulo;
        public String $autor;
        public int $likes;
        public int $vistas;
        public String $linksCapturas;

        public function echo(){
            ?>
                    <a class="bg-body rounded-5 w-100 d-flex flex-column align-items-start btn shadow-sm p-2 game-card"
                        href="game_info.php?id=<?=$this->id?>">
                        <div class="w-100 ratio ratio-16x9 overflow-hidden rounded-3">
                            <div class="carousel-fade" data-interval="2000">
                                
                                <div class="carousel-inner">
                                <?php
                                $first = true;
                                if($this->linksCapturas == ""){
                                    $capturas = array("assets/images/default_screenshot.jpg");
                                }else{
                                    $capturas = explode(", ", $this->linksCapturas);
                                }
                                foreach($capturas as $link){
                                    ?>
                                    <div class="d-block carousel-item <?= $first ? 'active' : ''?>"  >
                                        <img src="<?=$link?>?t=<?=time()?>" class="w-100" alt="">
                                    </div>
                                    <?php
                                    $first = false;
                                }
                                ?>
                                </div>
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
                
            <?php
        }
        
    }

?>