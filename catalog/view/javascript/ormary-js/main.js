/* Payment animation */

jQuery(document).ready(function() {

    $('.csa-label').click(function() {
        $(this).next().slideDown();
        $(this).parent().siblings().children('.csa-label').next().slideUp();
    });

});
$(document).ready(function() {

    /* Bag review textarea */

    $('#gift').click(function(event) {
        event.preventDefault();
        $(this).siblings('#gift-ta').slideToggle();
    });


    $('#pay_card, #pay_paypal').click(function(event) {
        event.preventDefault();


        if ($('#terms').prop("checked"))
        {
            var id = $(this).attr("id");
	    var href = $(this).attr("href");	
            $.ajax({
                url: 'index.php?route=checkout/checkout_review/updateOrder',
                type: 'post',
                data: $('textarea[name="comment"]'),
                dataType: 'json',
                success: function(json) {

                    if (id == 'pay_card')
                    {
                        $('#card_form').submit();
                    }
                    else
                    {
                        if (id == 'pay_paypal')
                        {
							window.location.href = href;
							//$('#paypal_form').submit();
                        }
                    }

                }
            });
        }
        else
        {
            $('#terms-error').show();
        }
    });


    /* Iscroll Fix */
    $('.sort_by').click(function() {
        $(this).next('.clothing_aside').slideToggle();
        iScrollInit();
    });

    $(window).resize(function() {

        if ($(window).width() > 991) {
            $('.clothing_aside').show();
        }

    });


    if ($(window).width() > 768) {
        $('.dropdown-toggle').dropdownHover();
    }

    $(window).resize(function() {
        if ($(window).width() > 768) {
            $('.dropdown-toggle').dropdownHover();
        }
    });

    /* A FOCUS ON blocks hover */
    /*
     $('.orm_focus_on .col-md-4').hover(function(){
     $(this).animate({opacity: "0.7"}, 150);
     },function(){
     $(this).animate({opacity: "1"}, 100);
     });
     */

    /* CLOTHING FILTER TABS */

    $('.filter-clothing-mens').hide();

    $('.womens_tab').click(function(event) {
        event.preventDefault();
        $(this).addClass('active');
        $(this).siblings().removeClass('active');
        $('.filter-clothing-womens').show();
        $('.filter-clothing-mens').hide();
    });
    $('.mens_tab').click(function(event) {
        event.preventDefault();
        $(this).addClass('active');
        $(this).siblings().removeClass('active');
        $('.filter-clothing-mens').show();
        $('.filter-clothing-womens').hide();
    });



    /* Mobile zoom */

    $('#open_zoom').click(function() {
        $(this).hide();
        $('#close_zoom').show();
    });

    $('#close_zoom').click(function(event) {
        event.preventDefault();
        $(this).hide();
        $('#open_zoom').show();
    });


    /* MY ORMARY TABS */

    $('.following_designers_to').click(function(event) {
        event.preventDefault();
        $(this).addClass('active');
        $(this).siblings().removeClass('active');
        $('.following_designers').show();
        $('.following_designers').siblings().hide();
    });

    $('.recommended_designers_to').click(function(event) {
        event.preventDefault();
        $(this).addClass('active');
        $(this).siblings().removeClass('active');
        $('.recommended_designers').show();
        $('.recommended_designers').siblings().hide();
    });

    $('.my_orders_to').click(function(event) {
        event.preventDefault();
        $(this).addClass('active');
        $(this).siblings().removeClass('active');
        $('.my_orders').show();
        $('.my_orders').siblings().hide();
    });

    /* ALL DESIGNERS FILTER SUB*/

    $('#orm_des_filter .filter-label').click(function() {
        $(this).toggleClass('activelabel');
        $(this).next('.sub_filter-clothing').toggle();
        $(this).siblings().next('.sub_filter-clothing').hide();

        if ($(this).attr('id') == 'c0')
        {
            $('#orm_des_filter label').removeClass('activelabel');
        }
        else
        {
            $('#orm_des_filter label#c0').removeClass('activelabel');
            if (!$(this).hasClass('activelabel'))
            {
                $(this).next('.sub_filter-clothing').find('label').removeClass("activelabel");
            }
        }

        var filter = [];
        $("label.activelabel").each(function() {
            filter.push(this.id.substr(1));
        });
        filter.join(',');

        if (filter != '')
        {
            filter = '&category=' + filter;
        }

        window.location.href = "/index.php?route=product/manufacturer" + filter;
    });


    $('#designer_search input').on('input', function() {
        name = $(this).val();

        var filter = [];
        $("label.activelabel").each(function() {
            filter.push(this.id.substr(1));
        });
        filter.join(',');

        /*		if(filter !='')
         {
         filter = '&category=' + filter;	
         }*/

        if (name != '')
        {
            $.get("index.php?route=product/manufacturer/getDesignersByName", {designer_name: name, category: filter}, function(data) {
                $("#designers-byname-list-wrap").html('<div class="row"><div class="col-md-4 col-sm-4 col-xs-6"><ul>' + data + '</ul></div>');
            });
            $("#designers-list-wrap").hide();
        }
        else
        {
            $("#designers-byname-list-wrap").html('');
            $("#designers-list-wrap").show();
        }
    });


    /* Product add to cart popup */

    $('.open_add_to_cart_popup').click(function(event) {
        event.preventDefault();

        $('.mini-cart-msg').remove();
        if ($("#orm_product select").val() == "")
        {
            $("#orm_product select").addClass("not_filled");
            $('#notification').html('<div class="attention" style="display: none;">Select Your Size</div>')
            $('.attention').fadeIn('fast');

            $('.attention').scrollToFixed();

            //	$(".available_sizes div.alert_error").show();
        }
        else
        {
            $('.attention').fadeOut('fast');

            $("#orm_product select").removeClass("not_filled");
            $(".available_sizes div.alert_error").hide();
            if ($('html').hasClass('touch') == false) {
                $('.cart_dropdown').addClass('forceshow');
                $('.cart_dropdown').prepend('<p class="mini-cart-msg">Adding item....</p>');
            } else {
                $('#notification').html('<div class="attention" style="display: none;">Adding to bag</div>')
                $('.attention').fadeIn('fast');

                $('.attention').scrollToFixed();
            }
            $.ajax({
                url: 'index.php?route=checkout/cart/add',
                type: 'post',
                data: $('#orm_product input[type=\'text\'], #orm_product input[type=\'hidden\'], #orm_product input[type=\'radio\']:checked, #orm_product input[type=\'checkbox\']:checked, #orm_product select, #orm_product textarea'),
                dataType: 'json',
                success: function(json) {
                    
                    if ($('html').hasClass('touch') == false) {
                        $('.success, .warning, .attention, information, .error').remove();
                    }
                    if (json['error']) {
                        if (json['error']['option']) {
                            for (i in json['error']['option']) {
                                $('#option-' + i).after('<span class="error">' + json['error']['option'][i] + '</span>');
                                alert('<span class="error">' + json['error']['option'][i] + '</span>');
                            }
                        }

                        if (json['error']['profile']) {
                            $('select[name="profile_id"]').after('<span class="error">' + json['error']['profile'] + '</span>');
                        }
                    }

                    if (json['success']) {

                        if ($('html').hasClass('touch') == false) {

                            $('#cart').load('index.php?route=module/cart #cart > *', function() {
                                $('.open_cart_dropdown #cart_header_price').html($('#cart span.total #cart_price').html());
                                $('.cart_dropdown').prepend('<p class="mini-cart-msg">Item Added :)</p>');

                                var minicarttimer = window.setTimeout(function() {
                                    $('.cart_dropdown').removeClass('forceshow')
                                }, 3000);

                            });

                            $('#cart_items_in_cart').html(json['total']['items_count']);
                            $('#cart_subtotal').html(json['total']['subtotal_price']);

                            var qty = 1; //parseInt($("#orm_product select#qty option:selected").text());

                            if (qty == 1)
                            {
                                $('#cart_popup_header').html("1 item");



                            }
                            else
                            {
                                //		$('#cart_popup_header').html(qty + " items");	
                                //      $('.cart_dropdown').prepend('<p class="mini-cart-msg">'+qty +' items added.</p>');
                            }
                            //	$('.mini-cart-msg').html(qty+'Item Added');
                            //$('#cart_product_color').html($("#orm_product .filter-colors span.selected").attr('title'));
                            $('#cart_product_color').html($("#orm_product #color").attr('title'));
                            $('#cart_product_size').html($("#orm_product select#size option:selected").text());

                            //$('#cart_product_qty').html($("#orm_product select#qty option:selected").text());
                            $('#cart_product_qty').html(qty);
                            var total_price = parseFloat($("#product_price").text()) * qty;



                            $('#cart_product_price_total').html('&pound;' + total_price.toFixed(2));

                        } else {
                            $('#notification').html('<div class="success">Added ' + $('.product_sub_title').html() + ' to bag<br/><a href="/cart">View your cart</a></div>')
                            $('.success').scrollToFixed();
                            
                              window.setTimeout(function() {
                 
                             $('.success').fadeOut('fast');
            }, 5000);
                            
                             $('.attention').fadeOut('fast');
                        }

                        /*$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
                         $('.success').fadeIn('slow');
                         $('#cart-total').html(json['total']);
                         $('html, body').animate({ scrollTop: 0 }, 'slow'); */

                    }
                }
            });



            //	$('.popup, .add_to_cart_popup').show();
            //	var topDistance = $(window).scrollTop();
            //	var popupHeight = $('.add_to_cart_popup').height()/2;
            //	var popupPosition = $(window).height()/2;
            //	$('.add_to_cart_popup').css('top',topDistance + popupPosition - popupHeight);
            //	if (popupHeight > popupPosition) {
            //		$('.add_to_cart_popup').css('maxHeight',popupPosition*2).css('overflow','auto').css('top',topDistance);
            //	}
        }
    });
    $('.add_to_cart_popup').click(function(event) {
        event.stopPropagation();
    });
    $('.popup, .close_popup').click(function(event) {
        event.preventDefault();
        $('.add_to_cart_popup, .popup').hide();
    });


    /* Product share with a friend popup */

    $('.open_share_with_friend').click(function(event) {
        event.preventDefault();
        $('.popup, .share_with_friend_popup').show();
        var topDistance = $(window).scrollTop();
        var popupHeight = $('.share_with_friend_popup').height() / 2;
        var popupPosition = $(window).height() / 2;
        $('.share_with_friend_popup').css('top', topDistance + popupPosition - popupHeight);
        if (popupHeight > popupPosition) {
            $('.share_with_friend_popup').css('maxHeight', popupPosition * 2).css('overflow', 'auto').css('top', topDistance);
        }
    });
    $('.share_with_friend_popup').click(function(event) {
        event.stopPropagation();
    });
    $('.popup, .close_popup').click(function() {
        $('.share_with_friend_popup, .popup').hide();
    });


    /* Wardrobe create collection popup */

    $('.open_create_collection').click(function(event) {
        event.preventDefault();
        $('.popup, .create_collection').show();
        var topDistance = $(window).scrollTop();
        var popupHeight = $('.create_collection').height() / 2;
        var popupPosition = $(window).height() / 2;
        $('.create_collection').css('top', topDistance + popupPosition - popupHeight);
        if (popupHeight > popupPosition) {
            $('.create_collection').css('maxHeight', popupPosition * 2).css('overflow', 'auto').css('top', topDistance);
        }
    });
    $('.create_collection').click(function(event) {
        event.stopPropagation();
    });
    $('.popup, .close_popup, #create_collection_reject').click(function() {
        $('.create_collection, .popup').hide();
    });

    $("#create_collection #collection_name").bind("keypress", function(e) {
        if (e.keyCode == 13) {
            return false;
        }
    });
    $(".add_to_wardrobe_ff").click(function() {
        href = $(this).parent().find('a.link_to_product').attr("href");
        img = $(this).parent().find('a.link_to_product img').attr("src");
        name = $(this).parent().find('div.designer_name').html();
        designer = $(this).parent().find('div.prod_name').html();
        price = $(this).parent().find('div.price').html();

        $(".my_wardrobe ul").prepend('<li><a class="wardrobe_product" href=' + href + '"><img alt="Manon Cape" src="' + img + '"><div class="hover-info"><div class="designer_name">' + designer + '</div><div class="prod_name">' + name + '</div><div class="price">' + price + '</div></div></a></li>');

    });
    /* Wardrobe remove collection popup */

    $('.open_remove_collection').click(function(event) {
        event.preventDefault();
        $('.popup, .remove_collection').show();
        var topDistance = $(window).scrollTop();
        var popupHeight = $('.remove_collection').height() / 2;
        var popupPosition = $(window).height() / 2;
        $('.remove_collection').css('top', topDistance + popupPosition - popupHeight);
        if (popupHeight > popupPosition) {
            $('.remove_collection').css('maxHeight', popupPosition * 2).css('overflow', 'auto').css('top', topDistance);
        }
    });
    $('.remove_collection').click(function(event) {
        event.stopPropagation();
    });
    $('.popup, .close_popup, #remove_collection_reject').click(function() {
        $('.remove_collection, .popup').hide();
    });

    /* My Wardrobe view recommended popup */

    $('.view_recommended').click(function(event) {
        event.preventDefault();

        $('.related_popup .product img').attr('src', $(this).parent().find('img').attr('src'))
        $('.related_popup .product img').attr('alt', $(this).parent().find('img').attr('alt'))
        $('.related_popup .product .designer_name').html($(this).parent().find('.designer_name').html());
        $('.related_popup .product .prod_name').html($(this).parent().find('.prod_name').html());
        $('.related_popup .product .price').html($(this).parent().find('.price').html());
        $('.related_popup .product').attr('id', $(this).attr('id'))
        $('.related_popup .recommended a.rec_product').remove();
        $('.related_popup .recommended span.number').html(0);
        $.ajax({
            url: 'index.php?route=account/wishlist/getWishlistRelatedProduct',
            type: 'post',
            data: {product_id: $(this).attr('id')},
            dataType: 'json',
            success: function(json) {

                if (json['products'])
                {
                    for (i in json['products'])
                    {
                        $('.related_popup .recommended h4').after('<a href="' + json['products'][i]['href'] + '" class="rec_product"><div class="rec_product_img"><img src="' + json['products'][i]['thumb'] + '" alt="' + json['products'][i]['name'] + '"></div><div class="rec_product_info"><div>' + json['products'][i]['designer'] + '</div><div class="light_font">' + json['products'][i]['name'] + '</div><div>' + json['products'][i]['price'] + '</div></div></a>');
                        $('.related_popup .recommended span.number').html(json['products'].length);
                    }
                }
            }
        });

        $('.related_popup, .popup').show();
        var topDistance = $(window).scrollTop();
        var popupHeight = $('.related_popup').height() / 2;
        var popupPosition = $(window).height() / 2;
        $('.related_popup').css('top', topDistance + popupPosition - popupHeight);
        if (popupHeight > popupPosition) {
            $('.related_popup').css('maxHeight', popupPosition * 2).css('overflow', 'auto').css('top', topDistance);
        }

    });
    $('.related_popup').click(function(event) {
        event.stopPropagation();
    });
    $('.popup, .close_popup').click(function() {
        $('.related_popup, .popup').hide();
    });

    /* JOIN ORMARY POPUPS */

    /* SIGN IN */

    $('.open_sign_in_popup').click(function(event) {
        event.preventDefault();
        $('.sign_in_popup, .popup').show();
        var topDistance = $(window).scrollTop();
        var popupHeight = $('.sign_in_popup').height() / 2;
        var popupPosition = $(window).height() / 2;
        $('.sign_in_popup').css('top', topDistance + popupPosition - popupHeight);
        if (popupHeight > popupPosition) {
            $('.sign_in_popup').css('maxHeight', popupPosition * 2).css('overflow', 'auto').css('top', topDistance);
        }

        $.ajax({
            url: 'index.php?route=account/register/designersList',
            type: 'post',
            data: {designer_id: 1},
            dataType: 'json',
            success: function(json) {
                $('.wrap_do_you_like .designer').attr('id', json['designer']['id']);
                $('.wrap_do_you_like #designer_name').html(json['designer']['name']);
                $('.wrap_do_you_like #designer_image').attr('src', json['designer']['image']);
                $('.wrap_do_you_like #designer_image').attr('alt', json['designer']['name']);
                $('.wrap_do_you_like .des-img ').attr('id', json['designer']['mid']);
                $('.wrap_do_you_like .designer_goods_slider .swiper-wrapper').html(json['designer']['image_list']);
                designerGoods();
            }
        });

    });
    $('.sign_in_popup').click(function(event) {
        event.stopPropagation();
    });
    $('.popup').click(function() {
        $('.popup, .sign_in_popup').hide();
    });

    /* SIGN UP */

    $('.open_ormary').click(function(event) {
        event.preventDefault();
        $('.sign_up_popup, .popup').show();
        var topDistance = $(window).scrollTop();
        var popupHeight = $('.sign_up_popup').height() / 2;
        var popupPosition = $(window).height() / 2;
        $('.sign_up_popup').css('top', topDistance + popupPosition - popupHeight);
        if (popupHeight > popupPosition) {
            $('.sign_up_popup').css('maxHeight', popupPosition * 2).css('overflow', 'auto').css('top', topDistance);
        }


        $.ajax({
            url: 'index.php?route=account/register/designersList',
            type: 'post',
            data: {designer_id: 1},
            dataType: 'json',
            success: function(json) {
                $('.wrap_do_you_like .designer').attr('id', json['designer']['id']);
                $('.wrap_do_you_like #designer_name').html(json['designer']['name']);
                $('.wrap_do_you_like #designer_image').attr('src', json['designer']['image']);
                $('.wrap_do_you_like #designer_image').attr('alt', json['designer']['name']);
                $('.wrap_do_you_like .des-img ').attr('id', json['designer']['mid']);
                $('.wrap_do_you_like .designer_goods_slider .swiper-wrapper').html(json['designer']['image_list']);
                designerGoods();
            }
        });


    });
    $('.sign_up_popup').click(function(event) {
        event.stopPropagation();
    });
    $('.popup').click(function() {
        $('.popup, .sign_up_popup').hide();
    });

    /**/

    $('.open_wizard').click(function(event) {
        event.preventDefault();

        $('.popup, .interested_in').show();
        $('.sign_up_popup').hide();
        var topDistance = $(window).scrollTop();
        var popupHeight = $('.interested_in').height() / 2;
        var popupPosition = $(window).height() / 2;
        $('.interested_in').css('top', topDistance + popupPosition - popupHeight);
        if (popupHeight > popupPosition) {
            $('.interested_in').css('maxHeight', popupPosition * 2).css('overflow', 'auto').css('top', topDistance);
        }
    });

    $('.interested_in').click(function(event) {
        event.stopPropagation();
    });
    $('.popup').click(function() {
        $('.popup, .interested_in').hide();
    });

    /**/

    $("#registration-first-form input[type='checkbox']").click(function(event) {

        if (this.checked)
        {
            $(this).val('1')
        }
        else
        {
            $(this).val('0');
        }
    });


    $('.open_wizard2').click(function(event) {
        event.preventDefault();

        $.ajax({
            url: 'index.php?route=account/register/ajaxValidate',
            type: 'post',
            data: $('#registration-first-form input[type=\'text\'], #registration-first-form input[type=\'password\'], input[type=\'checkbox\'], #registration-first-form input[type=\'hidden\']'),
            dataType: 'json',
            success: function(json) {
                if (json['error'].length != 0)
                {
                    if (json['error']['name'])
                    {
                        $('#registration-first-form #name-error').show();
                    }
                    else
                    {
                        $('#registration-first-form #name-error').hide();
                    }

                    if (json['error']['email'])
                    {
                        $('#registration-first-form #email-error').show();
                    }
                    else
                    {
                        $('#registration-first-form #email-error').hide();
                    }

                    if (json['error']['email_exist'])
                    {
                        $('#registration-first-form #email-exist-error').show();
                    }
                    else
                    {
                        $('#registration-first-form #email-exist-error').hide();
                    }

                    if (json['error']['password'])
                    {
                        $('#registration-first-form #password-error').show();
                    }
                    else
                    {
                        $('#registration-first-form #password-error').hide();
                    }

                    if (json['error']['terms'])
                    {
                        $('#registration-first-form #terms-error').show();
                    }
                    else
                    {
                        $('#registration-first-form #terms-error').hide();
                    }
                }
                else
                {
                    $('.sign_up_popup').hide();
                    $('.do_you_like, .popup').show();
                    var topDistance = $(window).scrollTop();
                    var popupHeight = $('.do_you_like').height() / 2;
                    var popupPosition = $(window).height() / 2;
                    $('.do_you_like').css('top', topDistance + popupPosition - popupHeight);
                    if (popupHeight > popupPosition) {
                        $('.do_you_like').css('maxHeight', popupPosition * 2).css('overflow', 'auto').css('top', topDistance);
                    }
                    //$('.interested_in').hide();

                    designerGoods();
                }
            }
        });


    });
    $('.do_you_like').click(function(event) {
        event.stopPropagation();
    });
    $('.popup').click(function() {
        $('.popup, .do_you_like').hide();
    });


    $('.bottom_btn .like').click(function(event) {
        action = $(this).attr("id");
        mid = $('.wrap_do_you_like .designer').attr("id");

        if (action == "yes")
        {
            designer_image = $('.wrap_do_you_like #designer_image ').attr("src");
            designer_name = $('.wrap_do_you_like #designer_name ').text();
            designer_id = $('.wrap_do_you_like .des-img ').attr("id");
            output = '<div class="des_following clearfix"><a href="javascript:void(0)"><div class="des-img"><img src="' + designer_image + '" alt="' + designer_name + '"></div> <span>' + designer_name + '</span><span class="light_font">Designer</span></a><a href="javascript:void(0)" class="light_btn" id="' + designer_id + '">Following</a></div>';

            $(".you_are_following .bottom_btn").before(output);

            $('.wrap_you_are_following .you_are_following').find('.des_following .light_btn').click(function() {
                $(this).parent().remove();
            });

            $('.wrap_you_are_following .you_are_following').find('.des_following .light_btn').hover(function() {
                $(this).html("Unfollow");
            }, function() {
                $(this).html("Following");
            });

        }
        getNextDesigner(mid, action);
    });

    $('.wrap_you_are_following .bottom_btn a').click(function(event) {
        event.preventDefault();
        var mids = [];
        $(".wrap_you_are_following .des_following .light_btn").each(function( ) {
            mids.push($(this).attr('id'));
        });

        /*		$('#orm_registration #following_designers').attr('value', mids.toString());
         $('#orm_registration').submit();*/

        $('#registration-first-form #following_designers').attr('value', mids.toString());
        $('#registration-first-form').submit();

    });

    $('.not_now').click(function(event) {
        event.preventDefault();

        $('#registration-first-form').submit();

    });

    $('.open_wizard3').click(function(event) {
        event.preventDefault();
        $('.you_are_following, .popup').show();
        $('.do_you_like').hide();
        var topDistance = $(window).scrollTop();
        var popupHeight = $('.you_are_following').height() / 2;
        var popupPosition = $(window).height() / 2;
        $('.you_are_following').css('top', topDistance + popupPosition - popupHeight);
        if (popupHeight > popupPosition) {
            $('.you_are_following').css('maxHeight', popupPosition * 2).css('overflow', 'auto').css('top', topDistance);
        }
    });
    $('.you_are_following').click(function(event) {
        event.stopPropagation();
    });
    $('.popup').click(function() {
        $('.popup, .you_are_following').hide();
    });

    /* Add your shipping address popup */

    $('#add_shipping_address a.add_address_btn, #edit_shipping_address a.update_address_btn').click(function(event) {

        if ($(this).hasClass('add_address_btn'))
        {
            form_id = '#add_address';
        }
        else
        {
            if ($(this).hasClass('update_address_btn'))
            {
                form_id = '#edit_address';
            }
        }


        $.ajax({
            url: 'index.php?route=account/address/ajaxValidateForm',
            type: 'post',
            data: $(form_id + ' input[type=\'text\'], ' + form_id + ' select, ' + form_id + ' input[type=\'hidden\']'),
            dataType: 'json',
            success: function(json) {
                if (json['error'].length != 0)
                {
                    if (json['error']['firstname'])
                    {
                        $(form_id + ' #error_firstname').html(json['error']['firstname']);
                        $(form_id + ' #error_firstname').show();
                    }
                    else
                    {
                        $(form_id + ' #error_firstname').hide();
                    }

                    if (json['error']['lastname'])
                    {
                        $(form_id + ' #error_lastname').html(json['error']['lastname']);
                        $(form_id + ' #error_lastname').show();
                    }
                    else
                    {
                        $(form_id + ' #error_lastname').hide();
                    }

                    if (json['error']['country'])
                    {
                        $(form_id + ' #error_country').html(json['error']['country']);
                        $(form_id + ' #error_country').show();
                    }
                    else
                    {
                        $(form_id + ' #error_country').hide();
                    }

                    if (json['error']['city'])
                    {
                        $(form_id + ' #error_city').html(json['error']['city']);
                        $(form_id + ' #error_city').show();
                    }
                    else
                    {
                        $(form_id + ' #error_city').hide();
                    }

                    if (json['error']['address_1'])
                    {
                        $(form_id + ' #error_address_1').html(json['error']['address_1']);
                        $(form_id + ' #error_address_1').show();
                    }
                    else
                    {
                        $(form_id + ' #error_address_1').hide();
                    }

                    if (json['error']['zone'])
                    {
                        $(form_id + ' #error_zone').html(json['error']['zone']);
                        $(form_id + ' #error_zone').show();
                    }
                    else
                    {
                        $(form_id + ' #error_zone').hide();
                    }

                    if (json['error']['postcode'])
                    {
                        $(form_id + ' #error_postcode').html(json['error']['postcode']);
                        $(form_id + ' #error_postcode').show();
                    }
                    else
                    {
                        $(form_id + ' #error_postcode').hide();
                    }
                }
                else
                {
                    $(form_id).submit();
                }
            }
        });

    });


    $('#open_add_shipping_address').click(function(event) {
        event.preventDefault();

        $('#add_address .alert_error').hide();

        $('#add_shipping_address, .popup').show();
        var topDistance = $(window).scrollTop();
        var popupHeight = $('#add_shipping_address').height() / 2;
        var popupPosition = $(window).height() / 2;
        $('#add_shipping_address').css('top', topDistance + popupPosition - popupHeight);
        if (popupHeight > popupPosition) {
            $('#add_shipping_address').css('maxHeight', popupPosition * 2).css('overflow', 'auto').css('top', topDistance);
        }
    });
    $('#add_shipping_address').click(function(event) {
        event.stopPropagation();
    });
    $('.popup').click(function() {
        $('.popup, #add_shipping_address').hide();
    });

    /* Edit shipping address popup */

    //$('#open_edit_shipping_address').click(function(event){
    $('.address_info_block .edit_btn, .csa-address .edit_btn').click(function(event) {

        var aid = $(this).parent().attr('id');

        $.ajax({
            url: 'index.php?route=account/address/getAddress',
            type: 'post',
            data: {address_id: aid},
            dataType: 'json',
            success: function(json) {
                if (json['error'] != "")
                {
                    alert("Error");
                }
                else
                {
                    $('#delete_address input[name="address_id"]').val(aid);
                    //$('.remove-addres a').attr('href','index.php?route=account/address/update&address_id=' + aid);
                    $('#edit_shipping_address #edit_address').attr('action', 'index.php?route=account/address/update&address_id=' + aid);

                    $('#edit_shipping_address input[name="firstname"]').val(json['address']['firstname']);
                    $('#edit_shipping_address input[name="lastname"]').val(json['address']['lastname']);
                    $('#edit_shipping_address select[name="country_id"]').val(json['address']['country_id']);

                    $.ajax({
                        url: 'index.php?route=account/address/country&country_id=' + json['address']['country_id'],
                        dataType: 'json',
                        success: function(json_zone) {

                            html = '<option value=""><?php echo $text_select; ?></option>';
                            if (json_zone['zone'] != '') {
                                for (i = 0; i < json_zone['zone'].length; i++) {
                                    html += '<option value="' + json_zone['zone'][i]['zone_id'] + '"';

                                    if (json_zone['zone'][i]['zone_id'] == json['address']['zone_id']) {
                                        html += ' selected="selected"';
                                    }

                                    html += '>' + json_zone['zone'][i]['name'] + '</option>';
                                }
                            } else {
                                html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
                            }

                            $('select[name=\'zone_id\']').html(html);
                        }
                    });

                    $('#edit_shipping_address input[name="address_1"]').val(json['address']['address_1']);
                    $('#edit_shipping_address input[name="address_2"]').val(json['address']['address_2']);
                    $('#edit_shipping_address input[name="postcode"]').val(json['address']['postcode']);
                    $('#edit_shipping_address input[name="city"]').val(json['address']['city']);

                    $('#edit_address .alert_error').hide();
                    event.preventDefault();
                    $('#edit_shipping_address, .popup').show();
                    var topDistance = $(window).scrollTop();
                    var popupHeight = $('#edit_shipping_address').height() / 2;
                    var popupPosition = $(window).height() / 2;
                    $('#edit_shipping_address').css('top', topDistance + popupPosition - popupHeight);
                    if (popupHeight > popupPosition) {
                        $('#edit_shipping_address').css('maxHeight', popupPosition * 2).css('overflow', 'auto').css('top', topDistance);
                    }
                }
            }
        });


    });
    $('#edit_shipping_address').click(function(event) {
        event.stopPropagation();
    });
    $('.popup').click(function() {
        $('.popup, #edit_shipping_address').hide();
    });

    /*-----------Shipping addresses select------*/

    $('#select_shipping_address input[type=radio]').change(function() {

        $.ajax({
            url: 'index.php?route=checkout/checkout_shipping/ajaxGetShippingPriceMessage',
            type: 'post',
            data: {country_id: $(this).parent().attr('id')},
            dataType: 'json',
            success: function(json) {
                $('#shipping_message').html(json['message']);
            }
        });
    });

    /* Size guide popup */

    $('#openSizeGuide').click(function(event) {
        event.preventDefault();
        $('#size_guide_popup, .popup').show();
    });
    $('#size_guide_popup').click(function(event) {
        event.stopPropagation();
    });
    $('.popup, .close_popup_big').click(function() {
        $('.popup, #size_guide_popup').hide();

    });
    $('#cart_select_all').click(function() {
        if (this.checked)
        {
            $('.product_select_checkbox').prop('checked', true);
        }
        else
        {
            $('.product_select_checkbox').prop('checked', false);
        }
    });

    $('#cart_remove_selected').click(function(event) {
        event.preventDefault();

        $("div.cart .table_row").each(function(index) {
            if ($(this).find("div.checkbox input").prop("checked"))
            {
                $.ajax({
                    url: $(this).find('div.edit a').attr("href"),
                    type: 'post',
                    data: '',
                    dataType: 'json',
                    success: function(json) {
                    }
                });
            }
            window.setTimeout(function() {
                window.location.href = 'index.php?route=checkout/cart';
            }, 1000);
        });
    });

    $('#cart_move_to_wardrobe_selected').click(function(event) {
        event.preventDefault();

        $("div.cart .table_row").each(function(index) {
            if ($(this).find("div.checkbox input").prop("checked"))
            {
                addToWishList($(this).find("div.checkbox input").val());
                $.ajax({
                    url: $(this).find('div.edit a').attr("href"),
                    type: 'post',
                    data: '',
                    dataType: 'json',
                    success: function(json) {
                    }
                });
            }
            window.setTimeout(function() {
                window.location.href = 'index.php?route=checkout/cart';
            }, 1000);
        });
    });

    /* ADD/REMOVE FOLOWERS*/

    $('#folow_designer').click(function() {
        if ($('#folow_designer > span').attr("class") == 'plus')
        {
            $('#folow_designer > span.plus').text('-');
            $('#folow_designer > span.word').text('Unfollow')
            manufacture_id = $('#folow_designer > span.plus').attr("id");
            $('#folow_designer > span.plus').attr("class", 'minus');
            $.get("index.php", {route: 'account/follow/changeFollow', st: "follow", mid: manufacture_id}, function(data) {
                $('#follows_count').html(data);
            });
        }
        else
        {
            $('#folow_designer > span.minus').text('+');
            $('#folow_designer > span.word').text('Follow')
            manufacture_id = $('#folow_designer > span.minus').attr("id");
            $('#folow_designer > span.minus').attr("class", 'plus');
            $.get("index.php", {route: 'account/follow/changeFollow', st: "unfollow", mid: manufacture_id}, function(data) {
                $('#follows_count').html(data);
            });
        }
    });

    $('.unfollow_btn > a.unfollow').click(function() {
        manufacture_id = $(this).attr("id");
        $.get("index.php", {route: 'account/follow/changeFollow', st: "unfollow", mid: manufacture_id}, function() {
            location.reload();
        });

    });

    $('.follow_btn > a.follow').click(function() {
        manufacture_id = $(this).attr("id");
        $.get("index.php", {route: 'account/follow/changeFollow', st: "follow", mid: manufacture_id}, function() {
            location.reload();
        });

    });


    /* ---- Catalog Filter -----*/
    $('.designer-search-wrap > input').on('input', function() {
        name = $(this).val();
//	
        if ($(this).val() == '' && $('.designer-search-wrap .filter-designers input[checked="checked"]').length > 0)
        {
            $("ul.filter-designers").html('');
            $('#orm_filter input[type="hidden"]').trigger('change');
        }
        catId = $('#catId').val();

        $.get("index.php?route=module/category/getDesignersByNameAndCategory", {dname: name, category: catId}, function(data) {
            $("ul.filter-designers").html(data);

            $("ul.filter-designers").find("input[type=radio]").change(function() {
                $('#orm_filter input[name="path"]').trigger('change');
            });
        });
    });

    /*	$( '.filter-colors li > span' ).click(function() {
     if($(this).hasClass("selected"))
     {
     $(this).removeClass("selected");
     color_id = "";
     }
     else
     {
     $( ".filter-colors li > span" ).removeClass("selected");
     $(this).addClass("selected");
     color_id = $(this).parent().attr("id").substring(2);	
     }
     
     $( "input#color" ).val(color_id).trigger('change');
     });*/



    $("#orm_filter").bind("keypress", function(e) {
        if (e.keyCode == 13) {
            return false;
        }
    });


    $('#orm_search_word').submit(function(event) {
        event.preventDefault();
        //$('#orm_filter input[type="hidden"]').trigger('change');
        var search_phrase = $("#orm_search_word").serialize();
        window.location.href = "/index.php?route=product/category&path=0&" + search_phrase;
    });

    $('#orm_filter input[type="radio"], #orm_filter input[type="hidden"], #orm_filter select, #orm_sort_filter select, #orm_count_filter select').change(function() {

        var filter = $("#orm_filter").serialize();
        var sort_filter = $("#orm_sort_filter").serialize();
        var word_filter = $("#orm_search_word").serialize();
        var count_filter = $("#orm_count_filter").serialize();
        sort_filter = sort_filter.replace("-", "&order=");

        if (window.location.search.toLowerCase().search('product/category') != -1 || $("#orm_filter #page").val() == 'catalog')
        {
            window.location.href = "index.php?route=product/category&".concat(filter, "&", word_filter, "&", count_filter); //sort_filter, "&",
        }

        if (window.location.search.toLowerCase().search('product/manufacturer/info') != -1 || $("#orm_filter #page").val() == 'manufacturer')
        {
            window.location.href = "index.php?route=product/manufacturer/info&".concat(filter, "&", sort_filter, "&", count_filter);
        }

    });

    /*---------------Payment page-------------------*/
    $('#payment_form input[name="use_shipping_address"]').change(function(event) {

        var aid = $(this).val();

        if ($(this).prop("checked"))
        {
            $.ajax({
                url: 'index.php?route=account/address/getAddress',
                type: 'post',
                data: {address_id: aid},
                dataType: 'json',
                success: function(json) {
                    if (json['error'] != "")
                    {
                        alert("Error");
                    }
                    else
                    {
                        $('#payment_form input[name="firstname"]').val(json['address']['firstname']);
                        $('#payment_form input[name="lastname"]').val(json['address']['lastname']);
                        $('#payment_form select[name="country_id"]').val(json['address']['country_id']);

                        $.ajax({
                            url: 'index.php?route=account/address/country&country_id=' + json['address']['country_id'],
                            dataType: 'json',
                            success: function(json_zone) {

                                html = '<option value=""><?php echo $text_select; ?></option>';
                                if (json_zone['zone'] != '') {
                                    for (i = 0; i < json_zone['zone'].length; i++) {
                                        html += '<option value="' + json_zone['zone'][i]['zone_id'] + '"';

                                        if (json_zone['zone'][i]['zone_id'] == json['address']['zone_id']) {
                                            html += ' selected="selected"';
                                        }

                                        html += '>' + json_zone['zone'][i]['name'] + '</option>';
                                    }
                                } else {
                                    html += '<option value="0" selected="selected">No regions</option>';
                                }

                                $('#payment_form select[name=\'zone_id\']').html(html);
                            }
                        });

                        $('#payment_form input[name="address_1"]').val(json['address']['address_1']);
                        $('#payment_form input[name="address_2"]').val(json['address']['address_2']);
                        $('#payment_form input[name="postcode"]').val(json['address']['postcode']);
                        $('#payment_form input[name="city"]').val(json['address']['city']);

                    }
                }
            });
        }

    });



    /*------Thank you page------*/
    $('.payment_like_designer').click(function() {
        manufacture_id = $('.do_you_like .des-img ').attr("id");

        action = $(this).attr("id");
        mid = $('.do_you_like .designer').attr("id");

        if (action == "yes")
        {
            $.get("index.php", {route: 'account/follow/changeFollow', st: "follow", mid: manufacture_id}, function() {
            });
        }

        getNextDesignerForRegistered(mid, action);



    });


});

/* Main slider */
var MainSliderLoop = true;
var newestCarouselLopp = true;

if ($('.orm_main_slider .swiper-slide').length < 2) {
    MainSliderLoop = false;
}

if ($('.orm_newest_carousel .swiper-slide').length < 6) {
    newestCarouselLopp = false;
}

var mySwiper = new Swiper('.orm_main_slider', {
    loop: MainSliderLoop,
    autoplay: 6000,
    speed: 1500
})
$('.arrow-left').on('click', function(e) {
    e.preventDefault()
    mySwiper.swipePrev()
})
$('.arrow-right').on('click', function(e) {
    e.preventDefault()
    mySwiper.swipeNext()
})

/* Newest products */

var newestCarousel = new Swiper('.orm_newest_carousel', {
    paginationClickable: true,
    slidesPerView: 5,
    loop: newestCarouselLopp,
    autoplay: 3500,
    speed: 950
})

$('.newest_carousel_prev').on('click', function(e) {
    e.preventDefault()
    newestCarousel.swipePrev()
})
$('.newest_carousel_next').on('click', function(e) {
    e.preventDefault()
    newestCarousel.swipeNext()
})

$(document).ready(function() {
    $('.orm_carousel_slide').click(function() {
        $(this).addClass('active');
        $(this).siblings().removeClass('active');
        var imgsource = $(this).children().children().attr('src');
        $('.product_image img').attr('src', imgsource);
    });


    if ($('.no-touch .product').length > 0) {
        $('.no-touch .product').hover(
                function() {
                    var _this = $(this).find('img.swapimg');
                    var cururl = _this.attr('src');
                    var newurl = _this.attr('data-swap');
                    if (_this.length > 1) {
                        _this = _this[0];
                    }
                    _this.attr('src', newurl);
                    _this.attr('data-swap', cururl);
                },
                function() {
                    var _this = $(this).find('img.swapimg');
                    var cururl = _this.attr('src');
                    var newurl = _this.attr('data-swap');
                    var attr = _this.attr('alt');
                    if (_this.length > 1) {
                        _this = _this[0];
                    }
                    _this.attr('src', newurl);
                    _this.attr('data-swap', cururl);

                }
        )
    }


});

/* Designer goods slider */

function designerGoods() {

    var mySwiper3 = new Swiper('.designer_goods_slider', {
        paginationClickable: true,
        slidesPerView: 4,
        loop: true
    })

    $('.des_slider_left').on('click', function(e) {
        e.preventDefault()
        mySwiper3.swipePrev()
    })
    $('.des_slider_right').on('click', function(e) {
        e.preventDefault()
        mySwiper3.swipeNext()
    })

}

/**/

$(function() {

    jQuery("#slider").slider({
        min: 0,
        max: parseInt($('.slider_control #sliderMaxPrice').val()),
        values: [$('.slider_control #minCost').text(), $('.slider_control #maxCost').text()],
        range: true,
        stop: function(event, ui) {
            jQuery("span#minCost").text(jQuery("#slider").slider("values", 0));
            jQuery("span#maxCost").text(jQuery("#slider").slider("values", 1));
            $('#slider_price_low').val(jQuery("#slider").slider("values", 0));
            $('#slider_price_top').val(jQuery("#slider").slider("values", 1)).trigger('change');

        },
        slide: function(event, ui) {
            jQuery("span#minCost").text(jQuery("#slider").slider("values", 0));
            jQuery("span#maxCost").text(jQuery("#slider").slider("values", 1));
        }
    });

});


function getNextDesigner(mid, action)
{
    $.ajax({
        url: 'index.php?route=account/register/getNextDesigner',
        type: 'post',
        data: {designer_id: mid, like: action},
        dataType: 'json',
        success: function(json) {

            if (json['all_designers'] == true)
            {
                $(".open_wizard3").trigger("click");
            }
            else
            {
                $('.wrap_do_you_like .designer').attr('id', json['designer']['id']);
                $('.wrap_do_you_like #designer_name').html(json['designer']['name']);
                $('.wrap_do_you_like #designer_image').attr('src', json['designer']['image']);
                $('.wrap_do_you_like #designer_image').attr('alt', json['designer']['name']);
                $('.wrap_do_you_like .des-img ').attr('id', json['designer']['mid']);
                $('.wrap_do_you_like .designer_goods_slider .swiper-wrapper').html(json['designer']['image_list']);
                designerGoods();
                if (json['designers_liked_summary'] >= 3)
                {
                    $('.wrap_do_you_like .open_wizard3').show();
                }
            }

        }
    });
}
/* Thank you page follow */
function getNextDesignerForRegistered(mid, action)
{
    $.ajax({
        url: 'index.php?route=account/register/getNextDesigner',
        type: 'post',
        data: {designer_id: mid, like: action},
        dataType: 'json',
        success: function(json) {

            if (json['all_designers'] == true)
            {
                window.location.href = "index.php?route=common/home";
            }
            else
            {
                $('.thank_you_page .do_you_like .designer').attr('id', json['designer']['id']);
                $('.thank_you_page .do_you_like #designer_name').html(json['designer']['name']);
                $('.thank_you_page .do_you_like #designer_image').attr('src', json['designer']['image']);
                $('.thank_you_page .do_you_like #designer_image').attr('alt', json['designer']['name']);
                $('.thank_you_page .do_you_like .des-img ').attr('id', json['designer']['mid']);
                $('.thank_you_page .do_you_like .thank_you_page_slider .swiper-wrapper').html(json['designer']['image_list']);
                purchaseSuccessSlider();
            }
        }
    });
}
/* Thank you page slider */
function purchaseSuccessSlider()
{


    var mySwiper4 = new Swiper('.thank_you_page_slider', {
        paginationClickable: true,
        slidesPerView: 4,
        loop: true
    })

    $('.thank_slider_left').on('click', function(e) {
        e.preventDefault()
        mySwiper4.swipePrev()
    })
    $('.thank_slider_right').on('click', function(e) {
        e.preventDefault()
        mySwiper4.swipeNext()
    })
}