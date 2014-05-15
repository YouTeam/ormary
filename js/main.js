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