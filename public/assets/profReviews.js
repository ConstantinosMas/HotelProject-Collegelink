$(document).on('submit', 'form.loadReviews', function(e) {
    e.preventDefault();
  
    const formData = $(this).serialize();
  
    $.ajax(
      'http://hotel.collegelink.localhost/public/ajax/profile_reviews.php',
      {
        type: "GET",
        dataType: "html",
        data: formData
      }).done(function(result) {
        $('#reviewsList').append(result); 
      });
  
  });

$('.showmore').on('click', function() {
   let new_num = parseInt($('.resultsNumber').val()) + 4;
   $('.resultsNumber').val(new_num);
});