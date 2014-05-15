$(document).ready(function(){

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
