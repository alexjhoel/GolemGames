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
                    <a class="bg-body rounded-5 col-3 d-flex flex-column align-items-start btn shadow-sm p-2" 
                        style="width:230px" 
                        href="game_info.php?id=<?=$this->id?>">
                        <?php
                            $first = true;
                            foreach($this->linksCapturas as $link){
                                ?>
                                <img
                                    class="rounded-3 w-100 <?= !$first ? 'd-none' : ''?>"
                                    src="<?=$link?>"
                                >
                                <?php
                                $first = false;
                            }
                        ?>
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