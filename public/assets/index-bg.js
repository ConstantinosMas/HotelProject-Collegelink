$('.navbar').removeClass('bg-white');
$('.navbar').addClass('bg-transparent');

let current_nr = 1
    const img_loc = ["url('/public/assets/img/landing/1.jpg')", "url('/public/assets/img/landing/2.jpg')",
                     "url('/public/assets/img/landing/3.jpg')", "url('/public/assets/img/landing/4.jpg')",
                     "url('/public/assets/img/landing/5.jpg')", "url('/public/assets/img/landing/6.jpg')"];

    $(document).on('click', 'body', function() {
        current_nr++;
        if (current_nr > 5) {
            current_nr = 1;
        } 
        console.log(current_nr);   
        setTimeout(function() {
            $("body").css("background-image", img_loc[current_nr - 1]);
                  }, 3000)
        
    })