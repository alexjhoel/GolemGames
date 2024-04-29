document.addEventListener( 'DOMContentLoaded', function () {
    new Splide( '#screenshot-scroller', {
          perPage    : 4,
          pagination : false,
          gap : 10,
          breakpoints: {
              1000: {
                  perPage: 2,
              },
              600: {
                perPage: 1,
                },
          },
    } ).mount();
  } );


  document.addEventListener( 'DOMContentLoaded', function () {
    document.querySelectorAll(".game-scroller").forEach(element => {
        new Splide( element, {
            arrows: true,
            perPage    : 4,
            gap:10,
            pagination : false,
            breakpoints: {
                1000: {
                    perPage: 2,
                },
                600: {
                  perPage: 1,
                  },
            },
      } ).mount();
    });
    
  } );