
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
)