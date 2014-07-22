$(document).ready(function(){

	$('.sort_by').click(function(){
		$(this).next('.clothing_aside').slideToggle();
	});

	$(window).resize(function(){

		if ($(window).width()>991) {
			$('.clothing_aside').show();
		}
		
	});

	if ($(window).width()>768) {
		$('.dropdown-toggle').dropdownHover();
	}

	$(window).resize(function() {
		if ($(window).width()>768) {
			$('.dropdown-toggle').dropdownHover();
		}
	});

	/* MY ORMARY TABS */

	$('.following_designers_to').click(function(event){
		event.preventDefault();
		$(this).addClass('active');
		$(this).siblings().removeClass('active');
		$('.following_designers').show();
		$('.following_designers').siblings().hide();
	});

	$('.recommended_designers_to').click(function(event){
		event.preventDefault();
		$(this).addClass('active');
		$(this).siblings().removeClass('active');
		$('.recommended_designers').show();
		$('.recommended_designers').siblings().hide();
	});

	$('.my_orders_to').click(function(event){
		event.preventDefault();
		$(this).addClass('active');
		$(this).siblings().removeClass('active');
		$('.my_orders').show();
		$('.my_orders').siblings().hide();
	});

	/* ALL DESIGNERS FILTER SUB*/

	$('#orm_des_filter .filter-label').click(function(){
		$(this).toggleClass('activelabel');
		$(this).next('.sub_filter-clothing').toggle();
		$(this).siblings().next('.sub_filter-clothing').hide();
	});

	/* Product add to cart popup */

	$('.open_add_to_cart_popup').click(function(event){
		event.preventDefault();
		$('.popup, .add_to_cart_popup').show();
		var topDistance = $(window).scrollTop();
		var popupHeight = $('.add_to_cart_popup').height()/2;
		var popupPosition = $(window).height()/2;
		$('.add_to_cart_popup').css('top',topDistance + popupPosition - popupHeight);
		if (popupHeight > popupPosition) {
			$('.add_to_cart_popup').css('maxHeight',popupPosition*2).css('overflow','auto').css('top',topDistance);
		}
	});
	$('.add_to_cart_popup').click(function(event){
		event.stopPropagation();
	});
	$('.popup, .close_popup').click(function(){
		$('.add_to_cart_popup, .popup').hide();
	});

	/* Wardrobe create collection popup */

	$('.open_create_collection').click(function(event){
		event.preventDefault();
		$('.popup, .create_collection').show();
		var topDistance = $(window).scrollTop();
		var popupHeight = $('.create_collection').height()/2;
		var popupPosition = $(window).height()/2;
		$('.create_collection').css('top',topDistance + popupPosition - popupHeight);
		if (popupHeight > popupPosition) {
			$('.create_collection').css('maxHeight',popupPosition*2).css('overflow','auto').css('top',topDistance);
		}
	});
	$('.create_collection').click(function(event){
		event.stopPropagation();
	});
	$('.popup, .close_popup').click(function(){
		$('.create_collection, .popup').hide();
	});

	/* Wardrobe remove collection popup */

	$('.open_remove_collection').click(function(event){
		event.preventDefault();
		$('.popup, .remove_collection').show();
		var topDistance = $(window).scrollTop();
		var popupHeight = $('.remove_collection').height()/2;
		var popupPosition = $(window).height()/2;
		$('.remove_collection').css('top',topDistance + popupPosition - popupHeight);
		if (popupHeight > popupPosition) {
			$('.remove_collection').css('maxHeight',popupPosition*2).css('overflow','auto').css('top',topDistance);
		}
	});
	$('.remove_collection').click(function(event){
		event.stopPropagation();
	});
	$('.popup, .close_popup').click(function(){
		$('.remove_collection, .popup').hide();
	});

	/* My Wardrobe view recommended popup */

	$('.view_recommended').click(function(event){
		event.preventDefault();
		$('.related_popup, .popup').show();
		var topDistance = $(window).scrollTop();
		var popupHeight = $('.related_popup').height()/2;
		var popupPosition = $(window).height()/2;
		$('.related_popup').css('top',topDistance + popupPosition - popupHeight);
		if (popupHeight > popupPosition) {
			$('.related_popup').css('maxHeight',popupPosition*2).css('overflow','auto').css('top',topDistance);
		}
	});
	$('.related_popup').click(function(event){
		event.stopPropagation();
	});
	$('.popup, .close_popup').click(function(){
		$('.related_popup, .popup').hide();
	});

	/* JOIN ORMARY POPUPS */

	/* SIGN IN */

	$('.open_sign_in_popup').click(function(event){
		event.preventDefault();
		$('.sign_in_popup, .popup').show();
		var topDistance = $(window).scrollTop();
		var popupHeight = $('.sign_in_popup').height()/2;
		var popupPosition = $(window).height()/2;
		$('.sign_in_popup').css('top',topDistance + popupPosition - popupHeight);
		if (popupHeight > popupPosition) {
			$('.sign_in_popup').css('maxHeight',popupPosition*2).css('overflow','auto').css('top',topDistance);
		}
	});
	$('.sign_in_popup').click(function(event){
		event.stopPropagation();
	});
	$('.popup').click(function(){
		$('.popup, .sign_in_popup').hide();
	});

	/* SIGN UP */

	$('.open_ormary').click(function(event){
		event.preventDefault();
		$('.sign_up_popup, .popup').show();
		var topDistance = $(window).scrollTop();
		var popupHeight = $('.sign_up_popup').height()/2;
		var popupPosition = $(window).height()/2;
		$('.sign_up_popup').css('top',topDistance + popupPosition - popupHeight);
		if (popupHeight > popupPosition) {
			$('.sign_up_popup').css('maxHeight',popupPosition*2).css('overflow','auto').css('top',topDistance);
		}
	});
	$('.sign_up_popup').click(function(event){
		event.stopPropagation();
	});
	$('.popup').click(function(){
		$('.popup, .sign_up_popup').hide();
	});

	/**/

	$('.open_wizard').click(function(event){
		event.preventDefault();
		$('.popup, .interested_in').show();
		$('.sign_up_popup').hide();
		var topDistance = $(window).scrollTop();
		var popupHeight = $('.interested_in').height()/2;
		var popupPosition = $(window).height()/2;
		$('.interested_in').css('top',topDistance + popupPosition - popupHeight);
		if (popupHeight > popupPosition) {
			$('.interested_in').css('maxHeight',popupPosition*2).css('overflow','auto').css('top',topDistance);
		}
	});
	$('.interested_in').click(function(event){
		event.stopPropagation();
	});
	$('.popup').click(function(){
		$('.popup, .interested_in').hide();
	});

	/**/

	$('.open_wizard2').click(function(event){
		event.preventDefault();
		$('.do_you_like, .popup').show();
		var topDistance = $(window).scrollTop();
		var popupHeight = $('.do_you_like').height()/2;
		var popupPosition = $(window).height()/2;
		$('.do_you_like').css('top',topDistance + popupPosition - popupHeight);
		if (popupHeight > popupPosition) {
			$('.do_you_like').css('maxHeight',popupPosition*2).css('overflow','auto').css('top',topDistance);
		}
		$('.interested_in').hide();
		designerGoods();
	});
	$('.do_you_like').click(function(event){
		event.stopPropagation();
	});
	$('.popup').click(function(){
		$('.popup, .do_you_like').hide();
	});

	/**/

	$('.open_wizard3').click(function(event){
		event.preventDefault();
		$('.you_are_following, .popup').show();
		$('.do_you_like').hide();
		var topDistance = $(window).scrollTop();
		var popupHeight = $('.you_are_following').height()/2;
		var popupPosition = $(window).height()/2;
		$('.you_are_following').css('top',topDistance + popupPosition - popupHeight);
		if (popupHeight > popupPosition) {
			$('.you_are_following').css('maxHeight',popupPosition*2).css('overflow','auto').css('top',topDistance);
		}
	});
	$('.you_are_following').click(function(event){
		event.stopPropagation();
	});
	$('.popup').click(function(){
		$('.popup, .you_are_following').hide();
	});

	/* Add your shipping address popup */

	$('.open_shipping_address').click(function(event){
		event.preventDefault();
		$('.shipping_address, .popup').show();
		var topDistance = $(window).scrollTop();
		var popupHeight = $('.shipping_address').height()/2;
		var popupPosition = $(window).height()/2;
		$('.shipping_address').css('top',topDistance + popupPosition - popupHeight);
		if (popupHeight > popupPosition) {
			$('.shipping_address').css('maxHeight',popupPosition*2).css('overflow','auto').css('top',topDistance);
		}
	});
	$('.shipping_address').click(function(event){
		event.stopPropagation();
	});
	$('.popup').click(function(){
		$('.popup, .shipping_address').hide();
	});


});

/* Main slider */

var mySwiper = new Swiper('.orm_main_slider',{
  pagination: '.pagination',
  paginationClickable: true,
  loop: true,
  autoplay:3000,
  speed: 850
})
$('.arrow-left').on('click', function(e){
	e.preventDefault()
	mySwiper.swipePrev()
})
$('.arrow-right').on('click', function(e){
	e.preventDefault()
	mySwiper.swipeNext()
})

/* Newest products */

	var newestCarousel = new Swiper('.orm_newest_carousel',{
		paginationClickable: true,
		slidesPerView: 6,
		loop: true,
		autoplay:3500,
		speed: 750
	})

	$('.newest_carousel_prev').on('click', function(e){
		e.preventDefault()
		newestCarousel.swipePrev()
	})
	$('.newest_carousel_next').on('click', function(e){
		e.preventDefault()
		newestCarousel.swipeNext()
	})



$(document).ready(function(){
	$('.orm_carousel_slide').click(function(){
		$(this).addClass('active');
		$(this).siblings().removeClass('active');
		var imgsource = $(this).children().children().attr('src');
		$('.product_image img').attr('src',imgsource);
	});
});

/* Designer goods slider */

function designerGoods(){

	var mySwiper3 = new Swiper('.designer_goods_slider',{
		paginationClickable: true,
		slidesPerView: 4,
		loop: true
	})

	 $('.des_slider_left').on('click', function(e){
		e.preventDefault()
		mySwiper3.swipePrev()
	})
	$('.des_slider_right').on('click', function(e){
		e.preventDefault()
		mySwiper3.swipeNext()
	})

}

/**/

$(function() {

	jQuery("#slider").slider({
	    min: 0,
	    max: 1000,
	    values: [0,1000],
	    range: true,
	    stop: function(event, ui) {
	        jQuery("span#minCost").text(jQuery("#slider").slider("values",0));
	        jQuery("span#maxCost").text(jQuery("#slider").slider("values",1));
	    },
	    slide: function(event, ui){
	        jQuery("span#minCost").text(jQuery("#slider").slider("values",0));
	        jQuery("span#maxCost").text(jQuery("#slider").slider("values",1));
	    }
	});

});








