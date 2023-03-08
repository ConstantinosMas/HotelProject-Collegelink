$(document).on('submit', 'form.favoriteForm', function(e) {
    e.preventDefault();
  
    const formData = $(this).serialize() + '&favoriteCall=yes';
  
    $.ajax(
      'http://hotel.collegelink.localhost/public/ajax/room_ajax.php',
      {
        type: "POST",
        dataType: "html",
        data: formData
      }).done(function(result) {
        $('form.favoriteForm').html($(result).filter('#favs').html());
        console.log(formData);
        // console.log($(result).filter('#favs').html());
      });
  
  });


  $(document).on('submit', 'form.postReview', function(e) {
    e.preventDefault();
    $('.review-btn').addClass('disabled');   
    const formData = $(this).serialize() + '&isAddReview=yes';
  
    $.ajax(
      'http://hotel.collegelink.localhost/public/ajax/room_ajax.php',
      {
        type: "POST",
        dataType: "html",
        data: formData
      }).done(function(result) {
        $('.reviews-section').html($(result).filter('#reviews').html());
        $('.top-rating').html($(result).filter('#rating').html());  
        const ratingStars = [...document.getElementsByClassName("rating-star")];
        const starClassInactive = "bi rating-star bi-star";
        ratingStars.forEach(element => element.className = starClassInactive);
        $('#review-text').val('');
        $('.review-btn').removeClass('disabled');
      });
  
  });


  $(document).on('submit', 'form.deleteReview', function(e) {
    e.preventDefault();
    $('.trash-review').addClass('disabled');
    const formData = $(this).serialize() + '&isDeleteReview=yes';
    
    $.ajax(
              'http://hotel.collegelink.localhost/public/ajax/room_ajax.php',
              {
                type: "POST",
                dataType: "html",
                data: formData
              }).done(function(result) {
                $('.reviews-section').html($(result).filter('#reviews').html());
                $('.top-rating').html($(result).filter('#rating').html());  
                $('.trash-review').removeClass('disabled');
              });
  });