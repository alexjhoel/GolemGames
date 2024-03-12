$(".scroller").siblings().click(function(){
    let scroller = $(this).siblings(".scroller");
    let scrollDirection = $(this).next().length == 0;

    let minPositive = Infinity;
    let maxNegative = -Infinity;

    scroller.children().each(function(i){
        let offset = $(this).position().left;
        if(offset + $(this).width() >  scroller.position().left + scroller.width() && minPositive == Infinity)
        {
            minPositive = $(this).width() - (scroller.position().left + scroller.width() - offset) ;
        }else if(offset > maxNegative && offset < 0){
            maxNegative = offset;
        }
    })
    console.log(minPositive)
    if(scrollDirection && minPositive != Infinity){
        scroller.animate({
            scrollLeft: "+=" + minPositive
        })
    }else if(!scrollDirection && maxNegative != -Infinity){
        scroller.animate({
            scrollLeft: "+=" + (maxNegative - scroller.offset().left)
        })
    }
    
});

