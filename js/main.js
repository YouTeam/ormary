$(document).ready(function(){

	if ($(window).width()>768) {
		$('.dropdown-toggle').dropdownHover();
	}

	$(window).resize(function(){
		if ($(window).width()>768) {
			$('.dropdown-toggle').dropdownHover();
		}
	});

	/* A FOCUS ON blocks hover */

	$('.orm_focus_on .col-md-4').hover(function(){
		$(this).animate({opacity: "0.7"}, 150);
	},function(){
		$(this).animate({opacity: "1"}, 100);
	});

	/* CLOTHING FILTER TABS */

	$('.filter-clothing-mens').hide();

	$('.womens_tab').click(function(event){
		event.preventDefault();
		$(this).addClass('active');
		$(this).siblings().removeClass('active');
		$('.filter-clothing-womens').show();
		$('.filter-clothing-mens').hide();
	});
	$('.mens_tab').click(function(event){
		event.preventDefault();
		$(this).addClass('active');
		$(this).siblings().removeClass('active');
		$('.filter-clothing-mens').show();
		$('.filter-clothing-womens').hide();
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
		$('.wrap_product_popup').show();
	});
	$('.add_to_cart_popup').click(function(event){
		event.stopPropagation();
	});
	$('.wrap_product_popup, .close_popup').click(function(){
		$('.wrap_product_popup').hide();
	});

	/* JOIN ORMARY POPUPS */

	$('.open_ormary').click(function(event){
		event.preventDefault();
		$('.wrap_sign_in').show();
	});
	$('.sign_in_popup').click(function(event){
		event.stopPropagation();
	});
	$('.wrap_sign_in').click(function(){
		$('.wrap_sign_in').hide();
	});

	/**/

	$('.open_wizard').click(function(event){
		event.preventDefault();
		$('.wrap_interested_in').show();
		$('.wrap_sign_in').hide();
	});
	$('.interested_in').click(function(event){
		event.stopPropagation();
	});
	$('.wrap_interested_in').click(function(){
		$('.wrap_interested_in').hide();
	});

	/**/

	$('.open_wizard2').click(function(event){
		event.preventDefault();
		$('.wrap_do_you_like').show();
		$('.wrap_interested_in').hide();
		designerGoods();
	});
	$('.do_you_like').click(function(event){
		event.stopPropagation();
	});
	$('.wrap_do_you_like').click(function(){
		$('.wrap_do_you_like').hide();
	});

	/**/

	$('.open_wizard3').click(function(event){
		event.preventDefault();
		$('.wrap_you_are_following').show();
		$('.wrap_do_you_like').hide();
	});
	$('.you_are_following').click(function(event){
		event.stopPropagation();
	});
	$('.wrap_you_are_following').click(function(){
		$('.wrap_you_are_following').hide();
	});


});

/* Main slider */

var mySwiper = new Swiper('.orm_main_slider',{
  pagination: '.pagination',
  paginationClickable: true,
  loop: true,
  autoplay:3000
})
$('.arrow-left').on('click', function(e){
	e.preventDefault()
	mySwiper.swipePrev()
})
$('.arrow-right').on('click', function(e){
	e.preventDefault()
	mySwiper.swipeNext()
})

/* Product carousel */

  var myCarousel = new Swiper('.orm_product_carousel',{
    paginationClickable: true,
    slidesPerView: 5
  })

  $('.orm_carousel_prev').on('click', function(e){
	e.preventDefault()
	myCarousel.swipePrev()
})
$('.orm_carousel_next').on('click', function(e){
	e.preventDefault()
	myCarousel.swipeNext()
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





