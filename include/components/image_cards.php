<?php
    class ImageCard{
        public int $id;
        public string $link;

        public function echo(){
            ?>
                <div class="col d-flex justify-content-center">
                    <a class="bg-body rounded-5 col-3 d-flex flex-column align-items-start btn shadow-sm p-2" 
                        style="width:250px" 
                        href="game_info.php?id=<?=$this->id?>">
                        <img class="rounded-3 w-100" src="<?=$this->link?>">
                </div>    
        <?php }
        
    }

?>