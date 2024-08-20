<?php
    class ImagesScroller{
        public bool $addEnabled = false;

        private Array $links = array();
        private Array $ids = array();

        public function AddImage($link){
            array_push($this->links, $link);
        }

        public function AddId($id){
            array_push($this->ids, $id);
        }

        public function echo(){
            ?>
                <div class="splide" id="screenshot-scroller">
            <div class="splide__arrows">
                <button class="splide__arrow splide__arrow--prev" type="button">
                    <i class="btn btn-primary rounded-circle fa-solid fa-arrow-left p-1"></i>
                </button>
                <button class="splide__arrow splide__arrow--next" type="button">

                    <i class="btn btn-primary rounded-circle fa-solid fa-arrow-right p-1"></i>
                </button>
            </div>
            <div class="splide__track">
                <ul class="splide__list">
                    
                    <?php if($this->addEnabled) {?>
                        <li class="ratio ratio-16x9 splide__slide rounded-5 overflow-hidden btn btn-outline-primary border-5 image-upload-button" style="border-style: dashed;">
                            <div class="d-flex flex-column h-100 justify-content-center">
                                
                                <i class="fa-solid fa-image" style="font-size:300%;"></i>
                                Agregar captura
                            </div>
                        </li>
                    <?php } 
                    
                    for ($i=0; $i < count($this->links); $i++){
                        ?>
                            <li class="splide__slide rounded-5 overflow-hidden ">
                                <?php if($this->addEnabled){?><a data-id="<?=$this->ids[$i]?>" type="button" class="delete-image-button position-absolute top-0 end-0 fs-5 pt-3 pe-3"><i class="fa-solid fa-trash"></i></a><?php }?>
                                <img src="<?=$this->links[$i]?>?t=<?=time()?>">
                            </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>   
        <?php }
        
    }

?>