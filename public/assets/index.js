$(document).ready(function () {
    $('.register-photo').on('click', '.pick-city', function(){
        $('.drop-btn-1').html($(this).html());
        $('.chosenCity').val($(this).html());
        checkInputs();
    })

    $('.register-photo').on('click', '.pick-room', function(){
        $('.drop-btn-2').html($(this).html());
        $('.roomStr').val($(this).html());
        var room_type_id = 1;
        var room_types = ['Single Room', 'Double Room', 'Triple Room', 'Fourfold Room'];
        for (const roomtype of room_types) {
            if (roomtype == $('.drop-btn-2').html()) {
                $('.chosenRoom').val(room_type_id);
                break
            }
            else {
                room_type_id++;
                continue
            }
        }
        room_type_id = 1;
        checkInputs();
    })

    $('.date').on('change', function() {
        checkInputs();
    })

    function checkInputs() {
        if ($('.chosenCity').val() != "" && $('.chosenRoom').val() != "" && $('.in').val() != "" && $('.out').val() != "") {
            $('.search').removeClass("disabled");
        }
    }

    $('.search').on('click', function() {
        $('.search').addClass('disabled');
    });

    let today = new Date().toISOString().split('T')[0];
    document.getElementsByName("checkin")[0].setAttribute('min', today);

    $('.in').on('change', function() {
        let selected_checkin = $(this).val();
        document.getElementsByName("checkout")[0].setAttribute('min', selected_checkin);
    });

    $('.out').on('change', function() {
        let selected_checkout = $(this).val();
        document.getElementsByName("checkin")[0].setAttribute('max', selected_checkout);
    });

    
   

      
   
    
    
    
});

