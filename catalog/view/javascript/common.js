var msgtimeout;

$(document).ready(function() {
	/* Search */
	$('.button-search').bind('click', function() {
		url = $('base').attr('href') + 'index.php?route=product/search';
				 
		var search = $('input[name=\'search\']').attr('value');
		
		if (search) {
			url += '&search=' + encodeURIComponent(search);
		}
		
		location = url;
	});
	
	$('#header input[name=\'search\']').bind('keydown', function(e) {
		if (e.keyCode == 13) {
			url = $('base').attr('href') + 'index.php?route=product/search';
			 
			var search = $('input[name=\'search\']').attr('value');
			
			if (search) {
				url += '&search=' + encodeURIComponent(search);
			}
			
			location = url;
		}
	});
	
	/* Ajax Cart */
        if ($('#cart > .heading a').length > 0) {
	$('#cart > .heading a').live('click', function() {
		$('#cart').addClass('active');
		
		$('#cart').load('index.php?route=module/cart #cart > *');
		
		$('#cart').live('mouseleave', function() {
			$(this).removeClass('active');
		});
	});
        }
	
	/* Mega Menu */
	$('#menu ul > li > a + div').each(function(index, element) {
		// IE6 & IE7 Fixes
		if ($.browser.msie && ($.browser.version == 7 || $.browser.version == 6)) {
			var category = $(element).find('a');
			var columns = $(element).find('ul').length;
			
			$(element).css('width', (columns * 143) + 'px');
			$(element).find('ul').css('float', 'left');
		}		
		
		var menu = $('#menu').offset();
		var dropdown = $(this).parent().offset();
		
		i = (dropdown.left + $(this).outerWidth()) - (menu.left + $('#menu').outerWidth());
		
		if (i > 0) {
			$(this).css('margin-left', '-' + (i + 5) + 'px');
		}
	});

	// IE6 & IE7 Fixes
        if ($.browser) {
	if ($.browser.msie) {
		if ($.browser.version <= 6) {
			$('#column-left + #column-right + #content, #column-left + #content').css('margin-left', '195px');
			
			$('#column-right + #content').css('margin-right', '195px');
		
			$('.box-category ul li a.active + ul').css('display', 'block');	
		}
		
		if ($.browser.version <= 7) {
			$('#menu > ul > li').bind('mouseover', function() {
				$(this).addClass('active');
			});
				
			$('#menu > ul > li').bind('mouseout', function() {
				$(this).removeClass('active');
			});	
		}
	}
	
	$('.success img, .warning img, .attention img, .information img').live('click', function() {
		$(this).parent().fadeOut('slow', function() {
			$(this).remove();
		});
	});	
        }
});

function getURLVar(key) {
	var value = [];
	
	var query = String(document.location).split('?');
	
	if (query[1]) {
		var part = query[1].split('&');

		for (i = 0; i < part.length; i++) {
			var data = part[i].split('=');
			
			if (data[0] && data[1]) {
				value[data[0]] = data[1];
			}
		}
		
		if (value[key]) {
			return value[key];
		} else {
			return '';
		}
	}
} 

function addToCart(product_id, quantity) {
	quantity = typeof(quantity) != 'undefined' ? quantity : 1;

	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: 'product_id=' + product_id + '&quantity=' + quantity,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information, .error').remove();
			
			if (json['redirect']) {
				location = json['redirect'];
			}
			
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				
				$('.success').fadeIn('slow');
				
				$('#cart-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
}
function addToWishList(product_id) {
     
    window.clearTimeout(msgtimeout)
    
    if (product_id === 'false') {
         $('#notification').html('<div class="attention" style="display: none;">Join Ormary To Create Your Wardrobe.<br><a  href="https://www.ormary.com/index.php?route=account/register" class="open_ormary underlined">JOIN NOW</a></div>')
	$('.attention').fadeIn('fast');
        
        
        $('.attention .open_ormary').click(function(event){
		event.preventDefault();
		$('.sign_up_popup, .popup').show();
		var topDistance = $(window).scrollTop();
		var popupHeight = $('.sign_up_popup').height()/2;
		var popupPosition = $(window).height()/2;
		$('.sign_up_popup').css('top',topDistance + popupPosition - popupHeight);
		if (popupHeight > popupPosition) {
			$('.sign_up_popup').css('maxHeight',popupPosition*2).css('overflow','auto').css('top',topDistance);
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
        msgtimeout = window.setInterval( function () {$('.attention').fadeOut('fast');},4000);
    
    }  else {
   
	$.ajax({
            
		url: 'index.php?route=account/wishlist/add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information').remove();
						
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '</div>')
			
				$('.success').fadeIn('fast');				
				$('#wishlist-total').html(json['total']);
			
                                                                      msgtimeout = window.setInterval( function () {$('.success').fadeOut('fast');},4000);
                        
				//$('html, body').animate({ scrollTop: 0 }, 'slow');
			}	
		}
	});
        
    }
}


function removeFromWishList(pid, cid) {
	$.get("index.php", { route : 'account/wishlist/remove', product_id: pid, collection_id: cid}, function(){location.reload(); });
}


function moveToWishListCollection(pid, cid) {
	$.get("index.php", { route : 'account/wishlist/update', product_id: pid, collection_id: cid}, function(){location.reload(); });
}

function addWishlistCollection() {
	name = $('#collection_name').val();
	if(name != '')
	{
		$.get("index.php", { route : 'account/wishlist/addCollection', collection_name: name}, function(){location.reload(); });
	}
}


function removeWishlistCollection(cid) {
	if(cid != '0')
	{
		$.get("index.php", { route : 'account/wishlist/removeCollection', collection_id: cid}, function(){location.reload(); });
	}
}

function addToCompare(product_id) { 
	$.ajax({
		url: 'index.php?route=product/compare/add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information').remove();
						
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				
				$('.success').fadeIn('slow');
				
				$('#compare-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
}
 
  function validateLogin()
  {
		$.ajax({
			url: 'index.php?route=account/login/ajaxValidate',
			type: 'post',
			data: $('#module_login input[type=\'text\'], #module_login input[type=\'password\']'),
			dataType: 'json',
			success: function(json) {
				if (json['error'].length != 0) 
				{					
					if(json['error']['email'])
					{
						$('#module_login #email-error').show();	
					}
					else
					{
						$('#module_login #email-error').hide();
					}
					
					if(json['error']['password'])
					{
						$('#module_login #pass-error').show();	
					}
					else
					{
						$('#module_login #pass-error').hide();
					}
					
					if(json['error']['incorrect'])
					{
						$('#module_login #login-error').show();	
					}
					else
					{
						$('#module_login #login-error').hide();
					}
					
				} 
				else
				{
					$('.sign_up_popup').hide();
					$('#module_login').submit();
				}	
			}
			});
  }