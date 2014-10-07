
(function($) {
    $.fn.OrmaryProductDetailsUI = function(options) {
        var settings = $.extend({
            'touch': false
        }, options);

        var $this = this;
        var $html = $('html');
        var touch = false;


        var init = function() {

            settings.touch = setIsTouch();




            if (settings.touch == true && $(window).width() < 788) {
                moveProductData();
                formatImagesForTouch();

            } else
            {

                $(window).resize(function() {

                    $('.zoomContainer').remove();

                    $('#zoom').elevateZoom({
                        gallery: "product_thumbs",
                        zoomType: "inner",
                        cursor: "crosshair",
                        zoomWindowFadeIn: 500,
                        zoomWindowFadeOut: 750,
                        loadingIcon: '/catalog/view/theme/ormary-new/images/productloading.gif'
                    });
                }).resize();
            }



        }

        var setIsTouch = function() {

            if ($html.hasClass('touch')) {
                return true;
            }
        }

        var moveProductData = function() {
            var pdata = $('.topData').clone();
            $('.topData').remove();
            pdata.addClass('topcenter');
            $('.swiper-container').before(pdata)
        }
        var formatImagesForTouch = function() {
            $('.textData').css('clear', 'both')
            $('.scroll_cap').remove()


            var thumbs = $('#product_thumbs:first a');
            var mainImgContainer = $('.mainImageContainer:first');
            mainImgContainer.addClass('swiper-wrapper');

            var mainW = mainImgContainer.width();
            var mainH = mainImgContainer.find('.product_image').innerHeight();





            var firstImage = $('.product_image:first');
            firstImage.addClass('swiper-slide');
            for (i = 0; i < thumbs.length; ++i) {
                var newImg = firstImage.clone();
                var newSrc = $(thumbs[i]).attr('data-image');
                newImg.find('img').attr('src', newSrc)

                firstImage.after(newImg)

            }

            var swiper = new Swiper('.swiper-container', {
                loop: MainSliderLoop,
                autoplay: '5000',
                loop : true,
                        speed: 50,
                resizeReInit: true
            })

            $('.mainImageContainer').css('padding-left', '0px')

            $('.mainImageContainer').css('padding-right', '0px')

            thumbs.remove();
            $('.close_zoom').remove();
            $('#product_thumbs').remove();
            $('.product_image:last').remove();


        }



        // Kick it off.
        init();

    };
})(jQuery);


$(document).ready(function() {
    $('body').OrmaryProductDetailsUI();
}) 