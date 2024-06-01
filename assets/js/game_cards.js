
/*
$(".game-card").on("mouseenter",
    function(){
        $(this).children(":first-child").children(".carousel-fade").carousel({
            interval: 2000, pause: "false"
          });
          $(this).children(":first-child").children(".carousel-fade").carousel("cycle");
    }
);

$(".game-card").on("mouseleave",
        function(){
            $(this).children(":first-child").children(".carousel-fade").carousel(0);
            $(this).children(":first-child").children(".carousel-fade").carousel("pause");
        } 
)*/

document.addEventListener( 'DOMContentLoaded', function () {
    document.querySelectorAll(".game-card-scroller").forEach(element => {
        
        var splideElement = new Splide( element, {
            arrows: false,
            type: 'fade',
            pagination : false,
            autoplay:true,
            padding:0,
            rewind: true,
            speed: 2000
        } ).mount();
        /*
        $(element).parent(".game-card").on("mouseenter",
        function(){
            element
            $(this).children(".carousel-fade").carousel({
                interval: 2000, pause: "false"
              });
            $(this).children(".carousel-fade").carousel("cycle");
        }
        );
        */
    });
    
  } );