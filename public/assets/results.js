let minValue = document.getElementById("min-value");
let maxValue = document.getElementById("max-value");

function validateRange(minPrice, maxPrice) {
  if (minPrice > maxPrice) {

    // Swap to Values
    let tempValue = maxPrice;
    maxPrice = minPrice;
    minPrice = tempValue;
  }

  minValue.innerHTML = "$" + minPrice;
  maxValue.innerHTML = "$" + maxPrice;
  $('.min-price').val(minPrice);
  $('.max-price').val(maxPrice);
}

const inputElements = document.querySelectorAll("input[type=range]");

inputElements.forEach((element) => {
  element.addEventListener("change", (e) => {
    let minPrice = parseInt(inputElements[0].value);
    let maxPrice = parseInt(inputElements[1].value);

    validateRange(minPrice, maxPrice);
  });
});

validateRange(inputElements[0].value, inputElements[1].value);

function checkInputs() {
    if ($('.chosenCity').val() != "" && $('.chosenRoom').val() != "" && $('.in').val() != "" && $('.out').val() != "") {
        $('.search').removeClass("disabled");
    }
}

$('.price-range').on('change', function() { 
    checkInputs();
});


$(document).on('submit', 'form.searchForm', function(e) {
  e.preventDefault();

  const formData = $(this).serialize();

  $.ajax(
    'http://hotel.collegelink.localhost/public/ajax/search_results.php',
    {
      type: "GET",
      dataType: "html",
      data: formData
    }).done(function(result) {
      $('.results-div').html(result);
      history.pushState({}, '', 'http://hotel.collegelink.localhost/public/assets/search_results.php?' + formData);

    });

});

let today = new Date().toISOString().split('T')[0];
let initial_checkout = $('.out').val();
let initial_checkin = $('.in').val();
document.getElementsByName("checkin")[0].setAttribute('min', today);
document.getElementsByName("checkin")[0].setAttribute('max', initial_checkout);
document.getElementsByName("checkout")[0].setAttribute('min', initial_checkin);

$('.in').on('change', function() {
  let selected_checkin = $(this).val();
  document.getElementsByName("checkout")[0].setAttribute('min', selected_checkin);
  });

$('.out').on('change', function() {
  let selected_checkout = $(this).val();
  document.getElementsByName("checkin")[0].setAttribute('max', selected_checkout);
  });

