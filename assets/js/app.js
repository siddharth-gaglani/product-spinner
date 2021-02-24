$(document).ready(function() {
    $(document).on("click", ".redeem", function(e) {
        e.preventDefault();
        this_one = $(this).parent('.product_block');
        console.log(this_one);
        var data = {
            product_id: $(this).data('product-id')
        };
        $.ajax({
            url: BASE_URL + "spin/redeem",
            dataType: "JSON",
            type: "POST",
            data: data,
            success: function(res) {
                if (res.access != false) {
                    if (res.setup == false) {
                        alert("ething wrong");
                    } else {
                        if (res.allowed == true) {
                            this_one.find('.message').html("You have successfully Redeemed this coupon");
                            $('#total_points').html(res.total_points);
                            this_one.find('.product_count').html(res.product_count);
                        } else {
                            this_one.find('.message').html("You dont have sufficient Points to Redeem this Product");
                        }

                        if (res.total_points == 0) {
                            $('.all_products').addClass('hide');
                        } else {
                            $('.all_products').removeClass('hide');
                        }
                    }
                } else {
                    window.location = BASE_URL;
                }
            }
        });
    });
    $(document).on("click", "#spin-now", function(e) {
        e.preventDefault();
        $('.spin-image-tag').addClass('rotate');
        setTimeout(function() {
            $.ajax({
                url: BASE_URL + "spin/lets_spin",
                dataType: "JSON",
                success: function(res) {
                    if (res.access != false) {
                        if (res.setup == false) {
                            alert("ething wrong");
                        } else {
                            if (res.allowed == true) {
                                $('#total_points').html(res.total_points);
                                $.each(res.images, function(key, value) {
                                    console.log(key);
                                    console.log(value);
                                    $('#image' + key).attr('src', URL + value.image_location);
                                });
                                if (res.points_earned != 0) {
                                    $('#points_earned').html(res.points_earned + " Points earned. Use this to redeem below products");
                                } else {
                                    $('#points_earned').html("Ohh. Bad Luck !! Please try again.");
                                }

                                if (res.total_points == 0) {
                                    $('.all_products').addClass('hide');
                                } else {
                                    $('.all_products').removeClass('hide');
                                }
                            } else {
                                $('#info').html("You can spin after " + res.next_attempt);
                                $('#points_earned').html("");
                            }
                        }
                        $('.spin-image-tag').removeClass('rotate');
                    } else {
                        window.location = BASE_URL;
                    }
                }
            });
        }, 3000);

        //alert('yeah');
    });
});