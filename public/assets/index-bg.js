$('.navbar').removeClass('bg-white');
$('.navbar').addClass('bg-transparent');

let current_nr = 1
let img_loc = []
for (let i = 1; i <= 8; i++) { //the maximum number of i needs to be the same number of pictures in the img/landing folder
    let pic_url = `url('/public/assets/img/landing/${i}.jpg')`;
    img_loc.push(pic_url);
}

$(document).on('click', 'body', function() {
    current_nr++;
    if (current_nr > 8) {
        current_nr = 1;
    } 
    console.log(current_nr);   
    setTimeout(function() {
        $("body").css("background-image", img_loc[current_nr - 1]);
                }, 3000)
    
})