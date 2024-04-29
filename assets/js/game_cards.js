
$(".game-card").on("mouseenter",
    function(){

        $(this).children(".carousel-fade").carousel({
            interval: 2000, pause: "false"
          });
        $(this).children(".carousel-fade").carousel("cycle");
    }
);

$(".game-card").on("mouseleave",
        function(){
            $(this).children(".carousel-fade").carousel(0);
            $(this).children(".carousel-fade").carousel("pause");
        } 
)