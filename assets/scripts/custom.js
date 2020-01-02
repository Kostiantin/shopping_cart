
/*Sliding side bar*/
$("#menu-toggle").click(function(e) {

    e.preventDefault();
    $("#wrapper").toggleClass("toggled");

    if ($(this).find('.fa-shopping-cart').hasClass('invisible-i')) {
        $(this).find('.fa-shopping-cart, .cart-quantity').removeClass('invisible-i');
        $(this).find('.fa-arrow-left').addClass('invisible-i');
    }
    else {
        $(this).find('.fa-shopping-cart, .cart-quantity').addClass('invisible-i');
        $(this).find('.fa-arrow-left').removeClass('invisible-i');
    }
});

/* Quantity of products to add to cart*/
$('.btn-number').click(function(e){
    e.preventDefault();

    var _fieldId = $(this).attr('data-field');
    var _type      = $(this).attr('data-type');
    var input = $("input#"+_fieldId);
    var currentVal = parseInt(input.val());

    if (!isNaN(currentVal)) {
        if(_type == 'minus') {

            input.parent().find('button[data-type="plus"]').attr('disabled', false);

            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            }
            if(parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if(_type == 'plus') {

            input.parent().find('button[data-type="minus"]').attr('disabled', false);

            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if(parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});

$('.input-number').focusin(function(){
    $(this).data('oldValue', $(this).val());
});

$('.input-number').change(function() {

    var minValue =  parseInt($(this).attr('min'));
    var maxValue =  parseInt($(this).attr('max'));
    var valueCurrent = parseInt($(this).val());

    var name = $(this).attr('name');
    if(valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        //alert('Sorry, the minimum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    if(valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
       // alert('Sorry, the maximum value was reached');
        $(this).val($(this).data('oldValue'));
    }
});

/* Refresh Cart */
function refreshCart(orderData = null) {
    $.ajax({
        url: '/?c=cart&a=getCartData',
        type: 'GET',
        data: '',
        success: function (data) {

        if (typeof data != 'undefined') {
            if (typeof data.products != 'undefined') {
                var _products_html = '<div class="products-in-cart">';
                for (var product_id in data['products']) {

                    _products_html += '<div class="row pic-row">';
                    _products_html += '<div class="col-md-2 pic-col product-in-cart-img"><img src="'+data['products'][product_id]['img']+'" alt=""/></div>';
                    _products_html += '<div class="col-md-2 pic-col product-in-cart-name"><strong>'+data['products'][product_id]['name']+'</strong></div>';
                    _products_html += '<div class="col-md-3 pic-col product-in-cart-quantity"><input min="0" max="1000" type="number" value="'+data['products'][product_id]['quantity']+'" name="cart_pr_quantity" id="cart_pr_quantity_'+product_id+'"/></div>';
                    _products_html += '<div class="col-md-2 pic-col product-in-cart-price"><span>$'+data['products'][product_id]['price']+'</span></div>';
                    _products_html += '<div class="col-md-2 pic-col product-in-cart-amount"><strong>$'+data['products'][product_id]['amount']+'</strong></div>';
                    _products_html += '<div class="col-md-1 pic-col product-in-cart-remove"><i class="fa fa-times removeProduct" id="removeProduct_'+product_id+'" aria-hidden="true"></i></div>';


                    _products_html += '</div>';
                }
                _products_html += '</div>';
                $('.products-in-cart-container').html(_products_html);
            }

            if (typeof data['totalProducts'] != 'undefined') {
                $('.amount-of-products').text(data['totalProducts']);
                $('.cart-quantity .qnt').addClass('hasNumber').text(data['totalProducts']);
                $('.cart-quantity input').val(data['totalProducts']);
                $('.clearCart').show();
            }
            else {
                $('.amount-of-products').text(0);
                $('.cart-quantity .qnt').removeClass('hasNumber').text('');
                $('.cart-quantity input').val(0);
                $('.clearCart').hide();
            }
            if (typeof data['totalAmount'] != 'undefined') {
                $('.tamfp').text(data['totalAmount']);

                // get the form for order
                $.ajax({
                    url: '/?c=order&a=getOrderForm',
                    type: 'GET',
                    data: '',
                    success: function (dataHtml) {

                        if (typeof dataHtml != 'undefined' && dataHtml != '' && dataHtml != null) {
                            $('.order-form-container').html(dataHtml);
                        }

                    },
                    dataType: 'html'
                });
            }
            else {
                $('.tamfp').text(0);
                $('.order-form-container').html('');

                if (orderData != null && orderData['first_name'] != 'undefined' && orderData['last_name'] != 'undefined' && orderData['total_amount'] != 'undefined') {
                    $('.order-form-container').html('<h3>Successful Order</h3><p>Dear <strong>' + orderData['first_name'] + ' ' + orderData['last_name'] + '</strong>, thank you for your order. The deposit was decreased by $'+orderData['total_amount']+' amount. </p>');
                }
            }
        }

        },
        dataType: 'json'
    });
}

// do refresh of cart on page load one time
refreshCart();

function addProductAjax(product_id, _quantity, _products_in_cart, _shouldReplaceNumberInCart) {
    /*Buy ajax*/
    $.ajax({
        url: '/?c=cart&a=addProductToCart',
        type: 'POST',
        data: {id: product_id, quantity: _quantity, shouldReplaceNumberInCart: _shouldReplaceNumberInCart},
        success: function (data) {

            /* Refresh Cart Data*/
            refreshCart();

            /*Visual add/increase number over cart*/

            if (typeof _quantity != 'undefined' && !isNaN(_quantity) && _quantity != null) {
                var _new_amount_of_products_in_cart = _products_in_cart + _quantity;

                if (typeof _new_amount_of_products_in_cart != 'undefined' && !isNaN(_new_amount_of_products_in_cart) && _new_amount_of_products_in_cart != null && _new_amount_of_products_in_cart > 0 ) {
                    $('.cart-quantity .qnt').addClass('hasNumber');
                }
                else {
                    $('.cart-quantity .qnt').removeClass('hasNumber');
                }

                $('.cart-quantity .qnt').text(_new_amount_of_products_in_cart);
                $('.cart-quantity input').val(_new_amount_of_products_in_cart);
            }
        },
        dataType: 'json'
    });
}

/* Add product to cart*/
$('.addProduct').click(function() {

    var product_id = $(this).data('product_id');

    var _quantity = parseInt($(this).parents('.product-holder:first').find('input.quantity').val());

    var _products_in_cart = parseInt($('.cart-quantity input').val());

    addProductAjax(product_id, _quantity, _products_in_cart, 0);

});

// Clear Cart
$('.clearCart').click(function() {
    $.ajax({
        url: '/?c=cart&a=_Empty',
        type: 'GET',
        data: '',
        success: function (data) {

            /* Refresh Cart Data*/
            refreshCart();

        },
        dataType: 'html'
    });
});

// Remove certain product from the cart
$(document).on('click', '.removeProduct', function() {

    var product_id = $(this).attr('id').replace('removeProduct_', '');

    $.ajax({
        url: '/?c=cart&a=removeProduct',
        type: 'POST',
        data: {id: product_id},
        success: function (data) {

            /* Refresh Cart Data*/
            refreshCart();

        },
        dataType: 'html'
    });

});

// Do order
$(document).on('submit', '.makeOrderForm',function(e) {
    e.preventDefault();

    var _tamfp_val = parseFloat($('.tamfp').text());
    var _deposit_val = parseFloat($('.user-deposit-amount').text());

    if (_tamfp_val > _deposit_val) {
        $('.error-cart-amount-exceeds-deposit').show();
        return;
    }
    else {
        $('.error-cart-amount-exceeds-deposit').hide();
    }

    $('.makeOrderForm .form-control').blur();

    var errorsCounter = 0;
    $('.makeOrderForm .form-control').each(function() {
        if ($(this).hasClass('has-error')) {
            errorsCounter++;
        }
    });

    if (errorsCounter > 0) {
        return;
    }
    else {

        var _formData = $('.makeOrderForm').serialize();

        $.ajax({
            url: '/?c=order&a=makeOrder',
            type: 'POST',
            data: _formData,
            success: function (data) {

                console.log(data);
                /* Refresh Cart Data*/
                if (typeof data != 'undefined' && typeof data['success'] !=  'undefined') {

                    refreshCart(data);
                    $('.user-deposit-amount').text(data['deposit']);

                }

            },
            dataType: 'json'
        });
    }
});

// Trim spaces from input value
function customTrimSpaces(val) {
    val = val.trim();
    return val;
}

// Validation of inputs
$(document).on('focusout', '.makeOrderForm .form-control', function(){
    var _trimmed_val = customTrimSpaces($(this).val());
    $(this).val(_trimmed_val);
    if (_trimmed_val == '' || _trimmed_val == '0') {
        $(this).addClass('has-error');
        $(this).parent().find('.error').show();
    }
    else {
        $(this).removeClass('has-error');
        $(this).parent().find('.error').hide();
    }
});


// Rating Poup
$(document).off('click', '.product-rating');

$(document).on('click', '.product-rating', function() {
    $('.sp-areYouSure-popup-container').remove();

    var _header_description = '';

    var _product_id = $(this).find('.five-stars-container').attr('id').replace('five-stars-container_', '');

    $('<div class="sp-popup-container sp-areYouSure-popup-container"><div class="apc-close"></div></div>').appendTo('body');

    var _new_html = $('.sp-areYouSure-main-popup-texts-container').html();

    $(_new_html).appendTo('.sp-areYouSure-popup-container');

    var _product_html = $(this).parents('.col-md-3:first').html();


    $('.sp-areYouSure-popup-container .apch-description').html(_product_html);

    $('.sp-areYouSure-popup-container .apch-description .description').remove();
    $('.sp-areYouSure-popup-container .apch-description .row').remove();

    $('.sp-areYouSure-popup-container .apch-description .product-rating').removeClass('product-rating').addClass('popup-product-rating').appendTo('.sp-areYouSure-popup-container .apch-image-holder');

    $('.sp-areYouSure-popup-container .saveRating').attr('id', 'saveRating_'+_product_id);
    var _top_pos = (parseInt($(window).innerHeight()) / 2) - (parseInt($('.sp-areYouSure-popup-container').innerHeight()) / 2);

    var _left_pos = (parseInt($(window).innerWidth()) / 2) - (parseInt($('.sp-areYouSure-popup-container').innerWidth()) / 2);

    $('.sp-areYouSure-popup-container').css({'left': _left_pos + 'px', 'top': _top_pos + 'px'}).show();

    $('.apc-close').click(function() {
        $(this).parent().remove();
    });
});

$(document).on('click', '.saveRating', function() {

    $('.rating-error-message, .rating-error-cant-be-empty').hide();

    var _product_id = $(this).attr('id').replace('saveRating_', '');
    var _email = $(this).parents('.sp-areYouSure-popup-container:first').find('.user_rating_email').val();
    var _rating = $(this).parents('.sp-areYouSure-popup-container:first').find('.user_rating').val();

    _email = customTrimSpaces(_email);
    _rating = customTrimSpaces(_rating);

    if (_rating != '' && _email != '') {
        $.ajax({
            url: '/?c=products&a=giveRating',
            type: 'POST',
            data: {product_id: _product_id, email: _email, rating: _rating},
            success: function (data) {

                if (typeof data != 'undefined' && typeof data['success'] != 'undefined' && data['success'] == true) {
                    location.reload();
                }
                else {
                    $('.rating-error-message').show();
                }

            },
            dataType: 'json'
        });
    }
    else {
        $('.rating-error-cant-be-empty').show();
    }

});


// Change amount of products in cart
$(document).on('blur', '.product-in-cart-quantity input[name="cart_pr_quantity"]', function() {

    var product_id = $(this).attr('id').replace('cart_pr_quantity_', '');

    var _quantity = parseInt($(this).val());

    //var _products_in_cart = parseInt($('.cart-quantity input').val());

    addProductAjax(product_id, _quantity, 0, 1);

    refreshCart();
});

// Add delivery to total

$(document).on('change', '#delivery', function(e) {

    var _delivery_cost = $(this).find('option[value="'+$(this).val()+'"]').data('cost');

    if (parseInt(_delivery_cost) == 0) {
        if ($('.tamfp').hasClass('deliveryAddedPay')) {
            var _tamfp_val = parseFloat($('.tamfp').text());
            _tamfp_val = _tamfp_val -5;
            $('.tamfp').text(_tamfp_val.toFixed(2));

            $('.tamfp').removeClass('deliveryAddedPay');
        }
    }
    if (parseInt(_delivery_cost) == 5) {

        var _tamfp_val = parseFloat($('.tamfp').text());
        _tamfp_val = _tamfp_val +5;
        $('.tamfp').text(_tamfp_val.toFixed(2));

        $('.tamfp').addClass('deliveryAddedPay');
    }

});




















