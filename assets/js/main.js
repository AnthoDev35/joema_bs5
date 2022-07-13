'use strict';

(function ($) {

    /*------------------
        Preloader
    --------------------*/
    $(window).on('load', function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");
		if($('#isFirstConnect').val() == 1){
			$('#firstConnectModal').modal('show');
		}
    });
	
	$('.head-search-text').keyup(function(e){
		e.preventDefault();
		if ($(this).val().length >= 2) {
			$.ajax({
				type : 'POST',
				url  : 'ajax/getSearch.php',
				data : {
					setSearch:true,
					searchText:$(this).val()
				},
				success : function(response){
					if($.trim(response) != 'error'){
						$('.select-search ul').html(response);
						$(".search-result").css('visibility', 'visible');
					}
					else{
						$('#logRegError').show();
						$('#logRegError').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> Une erreur c\'est produite!</div>');
					}
				}
			});
			return false;
		}
		else{
			$(".search-result").css('visibility', 'hidden');
		}
	});
	
    /*------------------
        Background Set
    --------------------*/
    $('.set-bg').each(function () {
        var bg = $(this).data('setbg');
        $(this).css('background-image', 'url(' + bg + ')');
    });

    /*------------------
        Hero Slider
    --------------------*/
    $(".hero-items").owlCarousel({
        loop: true,
        margin: 0,
        nav: true,
        items: 1,
        dots: false,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
    });

    /*------------------
        Product Slider
    --------------------*/
   $(".product-slider").owlCarousel({
        loop: true,
        margin: 25,
        nav: true,
        items: 4,
        dots: true,
        navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {
            0: {
                items: 1,
            },
            576: {
                items: 2,
            },
            992: {
                items: 2,
            },
            1200: {
                items: 3,
            }
        }
    });

    /*------------------
       logo Carousel
    --------------------*/
    $(".logo-carousel").owlCarousel({
        loop: false,
        margin: 30,
        nav: false,
        items: 5,
        dots: false,
        navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
        smartSpeed: 1200,
        autoHeight: false,
        mouseDrag: false,
        autoplay: true,
        responsive: {
            0: {
                items: 3,
            },
            768: {
                items: 5,
            }
        }
    });

    /*-----------------------
       Product Single Slider
    -------------------------*/
    $(".ps-slider").owlCarousel({
        loop: false,
        margin: 10,
        nav: true,
        items: 3,
        dots: false,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
    });
    
  /**
   * catslide slider
   */
  new Swiper('.catslide-slider', {
    speed: 600,
    loop: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false
    },
    slidesPerView: 'auto',
    pagination: {
      el: '.swiper-pagination',
      type: 'bullets',
      clickable: true
    },
    breakpoints: {
      320: {
        slidesPerView: 1,
        spaceBetween: 20
      },

      1200: {
        slidesPerView: 3,
        spaceBetween: 20
      }
    }
  });

  /**
   * newArticles slider
   */
  new Swiper('.newArticles-slider', {
    speed: 600,
    loop: true,
    autoplay: {
      delay: 3000,
      disableOnInteraction: false
    },
    slidesPerView: 'auto',
    pagination: {
      el: '.swiper-pagination',
      type: 'bullets',
      clickable: true
    },
    breakpoints: {
      320: {
        slidesPerView: 1,
        spaceBetween: 0
      },

      1200: {
        slidesPerView: 2,
        spaceBetween: 0
      }
    }
  });

  // Back to top button
  $(window).scroll(function() {
    if ($(this).scrollTop() > 100) {
      $('.back-to-top').fadeIn('slow');
    } else {
      $('.back-to-top').fadeOut('slow');
    }
  });

  $('.back-to-top').click(function() {
    $('html, body').animate({
      scrollTop: 0
    }, 0, 'easeInOutExpo');
    return false;
  });

  // Initiate venobox lightbox
  $(document).ready(function() {
    $('.venobox').venobox();
  });

$('#form-login').on('submit', function(e){
	e.preventDefault();
	var data = $("#form-login").serialize();
	$.ajax({
		type : 'POST',
		url  : 'ajax/getConnections.php',
		data : data,
		beforeSend: function(){
			$("#logHeadBtn").html('Connexion en cours');
		},
		success :  function(response){
			response = JSON.parse(response);
			if(response.success == 1){
				window.location.reload();
			}
			else{
				$('#errorModal').modal('show');
				$('#errorDetails').html(response.error);
				$('#logHeadBtn').html('Me connecter');
			}
		}
	});
	return false;
});

$('#register-form').on('submit', function(e){
	e.preventDefault();
	$('#logRegError').hide();
	var data = $("#register-form").serialize();
	$.ajax({
		type : 'POST',
		url  : 'ajax/getConnections.php',
		data : data,
		beforeSend: function(){
			$("#btn-submit-register").html('Inscription en cours');
		},
		success :  function(data){
			data = JSON.parse(data);
			if(data.success == 1){
				window.location.reload();
			}
			else{
				$('#errorModal').modal('show');
				$('#errorDetails').html(data.error);
				$("#btn-submit-register").html('M\'inscrire');
			}
		}
	});
	return false;
});

$('#sendHeaderDisconnect').on('click', function(e){
	e.preventDefault();
	$.ajax({
		type : 'POST',
		url  : 'ajax/getConnections.php',
		data : { isDisconnect:true },
		beforeSend: function(){
			$("#sendHeaderDisconnect").html('Déconnexion en cours');
		},
		success :  function(response){
			if(response==1){
				window.location.reload();
			}
		}
	});
	return false;
});

	$('#getAccountInfoBtn').on('click', function(e){
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: 'ajax/getAccount.php',
			data : {
				getAccountInfos:true
			},
			success: function(data){
				$('#account-content').html(data);
			}
		});
	});
	
	$("#getAccountInfoBtn").click(function(e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: 'ajax/getAccount.php',
			data : {
				getAccountInfos:true
			},
			success: function(data){
				$('#profileDatas').html(data);
				$("#getAccountInfoBtn").addClass('active');
				$("#getWalletInfoBtn").removeClass('active');
				$("#getAddressInfoBtn").removeClass('active');
				$("#getOrdersInfoBtn").removeClass('active');
				$("#getWishlistInfoBtn").removeClass('active');
			}
		});
	});
	$("#getWalletInfoBtn").click(function(e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: 'ajax/getAccount.php',
			data : {
				getWalletsInfos:true
			},
			success: function(data){
				$('#profileDatas').html(data);
				$("#getWalletInfoBtn").addClass('active');
				$("#getOrdersInfoBtn").removeClass('active');
				$("#getAccountInfoBtn").removeClass('active');
				$("#getAddressInfoBtn").removeClass('active');
				$("#getWishlistInfoBtn").removeClass('active');
			}
		});
	});
	$("#getAddressInfoBtn").click(function(e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: 'ajax/getAccount.php',
			data : {
				getAddressInfos:true
			},
			success: function(data){
				$('#profileDatas').html(data);
				$("#getAddressInfoBtn").addClass('active');
				$("#getWalletInfoBtn").removeClass('active');
				$("#getAccountInfoBtn").removeClass('active');
				$("#getOrdersInfoBtn").removeClass('active');
				$("#getWishlistInfoBtn").removeClass('active');
			}
		});
	});
	$("#getWishlistInfoBtn").click(function(e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: 'ajax/getAccount.php',
			data : {
				getWishlistInfo:true
			},
			success: function(data){
				$('#profileDatas').html(data);
				$("#getWishlistInfoBtn").addClass('active');
				$("#getWalletInfoBtn").removeClass('active');
				$("#getAccountInfoBtn").removeClass('active');
				$("#getAddressInfoBtn").removeClass('active');
				$("#getOrdersInfoBtn").removeClass('active');
			}
		});
	});
	$("#getOrdersInfoBtn").click(function(e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: 'ajax/getAccount.php',
			data : {
				getOrdersInfos:true
			},
			success: function(data){
				$('#profileDatas').html(data);
				$("#getOrdersInfoBtn").addClass('active');
				$("#getWalletInfoBtn").removeClass('active');
				$("#getAccountInfoBtn").removeClass('active');
				$("#getAddressInfoBtn").removeClass('active');
				$("#getWishlistInfoBtn").removeClass('active');
			}
		});
	});
	/*---single product activation---*/
    $('.single-product-active').owlCarousel({
        autoplay: true,
		loop: true,
        nav: true,
        autoplay: false,
        autoplayTimeout: 8000,
        items: 4,
        margin:15,
        dots:false,
        navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
        responsiveClass:true,
		responsive:{
				0:{
				items:1,
			},
            320:{
				items:2,
			},
            992:{
				items:3,
			},
            1200:{
				items:4,
			},


		  }
    });
    /*---stickey menu---*/
    $(window).on('scroll',function() {    
		var scroll = $(window).scrollTop();
		if (scroll < 100) {
			$(".sticky-header").removeClass("sticky");
		}
		else{
			$(".sticky-header").addClass("sticky");
		}
    });
    
    /*---mini cart activation---*/
    $('#showHeaderRegister, #showHeaderLogin').on('click', function(){
        $('#showLoginForm, #showRegisterForm').toggleClass('active');
    });
    
    $('.cart_link > a').on('click', function(){
        $('.mini_cart,.off_canvars_overlay').addClass('active')
    });
    
    $('.mini_cart_close > a,.off_canvars_overlay').on('click', function(){
        $('.mini_cart,.off_canvars_overlay').removeClass('active')
    });
    
    $('.heart_link > a').on('click', function(){
        $('.mini_heart,.off_canvars_overlay').addClass('active')
    });
    
    $('.mini_heart_close > a,.off_canvars_overlay').on('click', function(){
        $('.mini_heart,.off_canvars_overlay').removeClass('active')
    });
    
    $('.account_link > a').on('click', function(){
        $('.mini_account,.off_canvars_overlay').addClass('active')
    });
    
    $('.mini_account_close > a,.off_canvars_overlay').on('click', function(){
        $('.mini_account,.off_canvars_overlay').removeClass('active')
    });
    
    
	/*---canvas menu activation---*/
    $('.canvas_open').on('click', function(){
        $('.Offcanvas_menu_wrapper,.off_canvars_overlay').addClass('active')
    });
    
    $('.canvas_close,.off_canvars_overlay').on('click', function(){
        $('.Offcanvas_menu_wrapper,.off_canvars_overlay').removeClass('active')
    });
    
    
    /*---Off Canvas Menu---*/
    var $offcanvasNav = $('.offcanvas_main_menu'),
        $offcanvasNavSubMenu = $offcanvasNav.find('.sub-menu');
    $offcanvasNavSubMenu.parent().prepend('<span class="menu-expand"><i class="fa fa-angle-down"></i></span>');
    
    $offcanvasNavSubMenu.slideUp();
    
    $offcanvasNav.on('click', 'li a, li .menu-expand', function(e) {
        var $this = $(this);
        if ( ($this.parent().attr('class').match(/\b(menu-item-has-children|has-children|has-sub-menu)\b/)) && ($this.attr('href') === '#' || $this.hasClass('menu-expand')) ) {
            e.preventDefault();
            if ($this.siblings('ul:visible').length){
                $this.siblings('ul').slideUp('slow');
            }else {
                $this.closest('li').siblings('li').find('ul:visible').slideUp('slow');
                $this.siblings('ul').slideDown('slow');
            }
        }
        if( $this.is('a') || $this.is('span') || $this.attr('clas').match(/\b(menu-expand)\b/) ){
        	$this.parent().toggleClass('menu-open');
        }else if( $this.is('li') && $this.attr('class').match(/\b('menu-item-has-children')\b/) ){
        	$this.toggleClass('menu-open');
        }
    });
	
})(jQuery);

/* init website modules*/
function initWebsite(){
	initCarts();
	getAllWishListItems();
}

/*Shopping cart*/
function initCarts(){
	$.ajax({
		type : 'POST',
		url  : 'ajax/getCart.php',
		data : {initCart:true},
		success :  function(datas){
			datas = JSON.parse(datas);
			if(datas.success == 1){
				getAllCartItems();
			}
		}
	});
	return false;
}

$(document).on('change', 'input[type="radio"][name="color"]', function(e) {
	e.preventDefault();
	var setSizeID = $('#setSizeID').val();
	if(!setSizeID){
		setSizeID=0;
	}
	if($(this).is(':checked')) {
		$('#setColorID').val($(this).val());
		$.ajax({
			type : 'POST',
			url  : 'ajax/getSearch.php',
			data : {checkColorsAndSizes:true,artID:$('#artID').val(),sizeID:setSizeID,colorID:$(this).val()},
			success :  function(response){
				response = JSON.parse(response);
				if(response.datas != ''){
					$('#stockArticle').html(response.datas);
					$('#buyMaxQty').val(response.datas);
				}
				else if(response.error){
					$('#errorModal').modal('show');
					$('#errorDetails').html(response.error);
				}
			}
		});
		return false;
	}
});

$(document).on('change', 'input[type="radio"][name="size"]', function(e) {
	e.preventDefault();
	var setColorID = $('#setColorID').val();
	if(!setColorID){
		setColorID=0;
	}
	if($(this).is(':checked')) {
		$('#setSizeID').val($(this).val());
		$.ajax({
			type : 'POST',
			url  : 'ajax/getSearch.php',
			data : {checkColorsAndSizes:true,artID:$('#artID').val(),colorID:setColorID,sizeID:$(this).val()},
			success :  function(response){
				response = JSON.parse(response);
				if(response.datas != ''){
					$('#stockArticle').html(response.datas);
					$('#buyMaxQty').val(response.datas);
				}
				else if(response.error){
					$('#errorModal').modal('show');
					$('#errorDetails').html(response.error);
				}
			}
		});
		return false;
	}
});

function updateCartQty(artID){
	var quantity = parseInt($('#buyArtQty_'+artID).val());
	if(quantity != 0){
		updCartPageQuantity(artID,quantity);
	}
	else{
		delProductCart(artID);
	}
	return false;
}

function getAllCartItems(){
	$.ajax({
		type : 'POST',
		url  : 'ajax/getCart.php',
		data : {getAllCartItems:true},
		success :  function(datas){
			let response = JSON.parse(datas);
			if(response.data){
				$('.headArticleCart').html(response.data);
				countItemCart();
			}
		}
	});
	return false;
}

function getAllWishListItems(){
	$.ajax({
		type : 'POST',
		url  : 'ajax/getWishlist.php',
		data : {getAllWishListItems:true},
		success : function(datas){
			let response = JSON.parse(datas);
			if(response.data){
				$('.headWishlist').html(response.data);
				countItemsWishlist();
			}
		}
	});
	return false;
}

function sendConfirmMail(){
	$.ajax({
		type : 'POST',
		url  : 'ajax/getConnections.php',
		data : {sendConfirmMail:true},
		success :  function(data){
			if($.trim(data)){
				if(data == 'success'){
					window.location.href = "account.php?mailSend=success";
				}
			}
		}
	});
	return false;
}

function showSearchBar(){
	$('.Offcanvas_menu_wrapper,.off_canvars_overlay').removeClass('active');
	$('#searchbar').slideToggle(200);
	$('.show-searchbar').parent().toggleClass('active');
}

function addGiftCertificateToCard(){
	var giftCertAmount = $('#giftCertAmount').val();
	var regex = /^[0-9]*$/;
	var isValid = regex.test(giftCertAmount);
	if(isValid){
		if(giftCertAmount > 500){
			$('#errorModal').modal('show');
			$('#errorDetails').html('Vous ne pouvez pas dépasser 500 euros!');
		}
		else if(giftCertAmount == ''){
			$('#errorModal').modal('show');
			$('#errorDetails').html('Vous devez renseigner un montant!');
		}
		else{
			$.ajax({
				type : 'POST',
				url  : 'ajax/getCart.php',
				data : {addGiftCertificate:true,amount:giftCertAmount},
				success :  function(datas){
					var response = JSON.parse(datas);
					if(response.success == 1){
						getAllCartItems();
						showCartToast('cart', 'add');
						showAddToCartModal('999999999999');
					}
					else{
						$('#errorModal').modal('show');
						$('#errorDetails').html(response.error);
					}
				}
			});
			return false;
		}
	}
	else{
		$('#errorModal').modal('show');
		$('#errorDetails').html('Vous ne pouvez utiliser que des nombres entiers!');
	}
}

function addArticleToCart(pID){
	var buyArtQty = $('#buyArtQty').val();
	var buyMaxQty = $('#buyMaxQty').val();
	if(buyMaxQty >= 1){
		if(buyArtQty > buyMaxQty){
			$('#errorModal').modal('show');
			$('#errorDetails').html('Désolé, il ne reste seulement '+buyMaxQty+' articles de cette référence en stock!');
			return false;
		}
		else{
			var buyArtColor = $('#setColorID').val();
			var buyArtSize = $('#setSizeID').val();
			if(!buyArtColor){
				buyArtColor = 0;
			}
			if(!buyArtSize){
				buyArtSize = 0;
			}
			$.ajax({
				type : 'POST',
				url  : 'ajax/getCart.php',
				data : {addItem:true,itemID:pID,itemQty:buyArtQty,itemColor:buyArtColor,itemSize:buyArtSize},
				success :  function(datas){
					var response = JSON.parse(datas);
					if(response.success == 1){
						getAllCartItems();
						showCartToast('cart', 'add');
						showAddToCartModal(pID);
					}
					else{
						$('#errorModal').modal('show');
						$('#errorDetails').html(response.error);
					}
				}
			});
			return false;
		}
	}
	else{
		$('#errorModal').modal('show');
		$('#errorDetails').html('Désolé, cette référence est victime de sont succès et n\'est plus disponible!');
	}
}

function delProductCart(pID){
	$.ajax({
		type : 'POST',
		url  : 'ajax/getCart.php',
		data : {delItem:true,itemID:pID},
		success :  function(datas){
			let response = JSON.parse(datas);
			if(response.success == 1){
				getAllCartItems();
				showCartToast('cart', 'remove');
			}
			else{
				$('#errorModal').modal('show');
				$('#errorDetails').html(response.error);
			}
		}
	});
	return false;
}

function countItemCart(){
	$.ajax({
		type : 'POST',
		url  : 'ajax/getCart.php',
		data : {getCountCartItems:true},
		success :  function(datas){
			datas = JSON.parse(datas);
			if(datas.data){
				$('.count-cart-items').html(datas.data);
				updCartPage();
			}
		}
	});
	return false;
}

function countItemsWishlist(){
	$.ajax({
		type : 'POST',
		url  : 'ajax/getWishlist.php',
		data : {getCountWishlistItems:true},
		success :  function(data){
			if($.trim(data)){
				$('.count-wishlist-items').html(data);
			}
		}
	});
	return false;
}

function updHeaderCartPrice(){
	$.ajax({
		type : 'POST',
		url  : 'ajax/getCart.php',
		data : {getHeaderCartPrice:true},
		success :  function(datas){
			var response = JSON.parse(datas);
			if(response.data != ''){
				$('.header-cart-price').html(response.data);
			}
		}
	});
	return false;
}

function addDiscountCode(){
	$.ajax({
		type : 'POST',
		url  : 'ajax/getCart.php',
		data : {setDiscountCode:true,discountcode:$('#discountcode').val()},
		success :  function(datas){
			var response = JSON.parse(datas);
			if(response.success == 1){
				updHeaderCartPrice();
				updCartPagePrice();
			}
			else{
				$('#errorModal').modal('show');
				$('#errorDetails').html(response.error);
			}
		}
	});
	return false;
}

function delDiscountCode(){
	$.ajax({
		type : 'POST',
		url  : 'ajax/getCart.php',
		data : {delDiscountCode:true},
		success :  function(datas){
			var response = JSON.parse(datas);
			if(response.success == 1){
				updHeaderCartPrice();
				updCartPagePrice();
			}
			else{
				$('#errorModal').modal('show');
				$('#errorDetails').html(response.error);
			}
		}
	});
	return false;
}

function addGiftCertificateCode(){
	$.ajax({
		type : 'POST',
		url  : 'ajax/getCart.php',
		data : {setGiftCertificateCode:true,giftCertificateCode:$('#giftCertificateCode').val()},
		success :  function(datas){
			var response = JSON.parse(datas);
			if(response.success == 1){
				updHeaderCartPrice();
				updCartPagePrice();
			}
			else{
				$('#errorModal').modal('show');
				$('#errorDetails').html(response.error);
			}
		}
	});
	return false;
}

function updCartPage(){
	$.ajax({
		type : 'POST',
		url  : 'ajax/getCart.php',
		data : {getPageCart:true},
		success :  function(datas){
			var response = JSON.parse(datas);
			if(response.data != ''){
				updHeaderCartPrice();
				if($('#getCartDetail').length){
					$('#getCartDetail').html(response.data);
					updCartPagePrice();
				}
			}
		}
	});
	return false;
}

function updCartPagePrice(){
	$.ajax({
		type : 'POST',
		url  : 'ajax/getCart.php',
		data : {getPageCartPrice:true},
		success :  function(datas){
			var response = JSON.parse(datas);
			if(response.data != ''){
				$('#pageCartPrice').html(response.data);
			}
		}
	});
	return false;
}

function updCartPageQuantity(itemID,itemQty){
	let maxQty = $('#buyMaxQty_'+itemID).val();
	if(itemQty > maxQty){
		itemQty = maxQty;
	}
	$.ajax({
		type : 'POST',
		url  : 'ajax/getCart.php',
		data : {updCartQty:true,itemID:itemID,itemQty:itemQty},
		success :  function(datas){
			var response = JSON.parse(datas);
			if(response.success == 1){
				if(itemQty > maxQty){
					$('#errorModal').modal('show');
					$('#errorDetails').html('La quantité indiqué est supérieur au stock actuel. Nous avons mis à jour la quantité de l\'article avec le stock maximum.');
					setTimeout(function(){
						window.location.reload();
					}, 2000);
				}
				else{
					window.location.reload();
				}
			}
			else{
				$('#errorModal').modal('show');
				$('#errorDetails').html(response.error);
			}
		}
	});
	return false;
}

/*Toast*/
function showCartToast(data, val){
	var showDataTitle = '';
	var showDataAdd = '';
	var showDataDel = '';
	var showDataText = '';
	if(data == 'cart'){
		showDataTitle = 'Panier d\'achat';
		showDataAdd = 'au panier';
		showDataDel = 'du panier';
	}
	else if(data == 'wishlist'){
		showDataTitle = 'Liste d\'envie';
		showDataAdd = 'à la liste';
		showDataDel = 'de la liste';
	}
	else if(data == 'sharePage'){
		showDataTitle = 'Partage de lien';
		showDataAdd = 'à la liste';
		showDataDel = 'de la liste';
	}
	if(val == 'remove'){
		showDataText = 'Article supprimé '+showDataDel;
	}
	else if(val == 'add'){
		showDataText = 'Article ajouté '+showDataAdd;
	}
	else if(val == 'share'){
		showDataText = 'Page envoyé avec succès.';
	}
	$('#notif-title').html(showDataTitle);
	$('#notif-text').html(showDataText);
	$('#notification').show('slow');
	setTimeout(function(){
		$('#notification').hide('slow');
	}, 2000);
	return false;
}

function showAddToCartModal(pID){
	$('#addToCartModal').modal('show');
	$.ajax({
		type : 'POST',
		url  : 'ajax/getCart.php',
		data : {getAddToCartModal:true,articleID:pID},
		success :  function(data){
			data = JSON.parse(data);
			if(data.datas != ''){
				$('#addToCartDetails').html(data.datas);
			}
		}
	});
	return false;
}

function sendShareMail(){
	var username = $('#shareEmailName').val();
	var receiver = $('#shareEmailReceiver').val();
	var shareLink = $('#shareEmailLink').val();
	if(username == ''){
		$('#shareProductModal').modal('hide');
		$('#errorModal').modal('show');
		$('#errorDetails').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> Vous devez renseigner votre Nom & Prénom.</div>');
	}
	else if(receiver == ''){
		$('#shareProductModal').modal('hide');
		$('#errorModal').modal('show');
		$('#errorDetails').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> Vous devez renseigner une adresse email.</div>');
	}
	else{
		$.ajax({
			type : 'POST',
			url  : 'ajax/getConnections.php',
			data : {getShareLink:true,username:username,receiver:receiver,shareLink:shareLink},
			success :  function(data){
				if($.trim(data) == 'success'){
					$('#shareProductModal').modal('hide');
					showCartToast('sharePage', 'share');
				}
				else{
					$('#shareProductModal').modal('hide');
					$('#errorModal').modal('show');
					$('#errorDetails').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> '+data+'</div>');
				}
			}
		});
		return false;
	}
}

function sendForgotPassMail(){
	var forgotLastname = $('#forgotLastname').val();
	var forgotFirstname = $('#forgotFirstname').val();
	var forgotEmail = $('#forgotEmail').val();
	if(forgotLastname == '' && forgotFirstname == '' && forgotEmail == ''){
		$('#forgotPassModal').modal('hide');
		$('#errorModal').modal('show');
		$('#errorDetails').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> Vous devez renseigner tous les champs.</div>');
	}
	else{
		$.ajax({
			type : 'POST',
			url  : 'ajax/getConnections.php',
			data : {getForgotPass:true,forgotLastname:forgotLastname,forgotFirstname:forgotFirstname,forgotEmail:forgotEmail},
			success :  function(data){
				data = JSON.parse(data);
				if(data.success){
					$('#forgotpass-details').html('<div class="alert alert-success">Le mot de passe à été réinitialisé.Vérifiez votre adresse email.</div>');
				}
				else{
					$('#forgotPassModal').modal('hide');
					$('#errorModal').modal('show');
					$('#errorDetails').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> '+data.error+'</div>');
				}
			}
		});
		return false;
	}
}

function sendDefinePassword(){
	var firstPassword = $('#firstPassword').val();
	var firstRePassword = $('#firstRePassword').val();
	$.ajax({
		type : 'POST',
		url  : 'ajax/getConnections.php',
		data : {setDefinePassword:true,firstPassword:firstPassword,firstRePassword:firstRePassword},
		success :  function(data){
			data = JSON.parse(data);
			if(data.success == '1'){
				$('#forgotPassDetails').html('<div class="alert alert-success">Le mot de passe à été validé. Patientez quelques secondes pour continuer. </div>');
				setTimeout(function(){
					$('#firstConnectModal').modal('hide');
				}, 2000);
			}
			else{
				$('#forgotPassDetails').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> '+data.error+'</div>');
			}
		}
	});
	return false;
}
/*wish list*/

function addArtWishList(pID){
	$.ajax({
		type : 'POST',
		url  : 'ajax/getWishlist.php',
		data : {addWishlistItem:true,wishlistItemID:pID},
		success :  function(data){
			var response = JSON.parse(data);
			if(response.success == 1){
				getAllWishListItems();
				showCartToast('wishlist', 'add');
				window.location.reload();
			}
			else{
				$('#errorModal').modal('show');
				$('#errorDetails').html(response.error);
			}
		}
	});
	return false;
}

function delArtWishList(pID){
	$.ajax({
		type : 'POST',
		url  : 'ajax/getWishlist.php',
		data : {delWishlistItem:true,wishlistItemID:pID},
		success :  function(data){
			var response = JSON.parse(data);
			if(response.success == 1){
				getAllWishListItems();
				showCartToast('wishlist', 'remove');
				window.location.reload();
			}
			else{
				$('#errorModal').modal('show');
				$('#errorDetails').html(response.error);
			}
		}
	});
	return false;
}
function countWishlistItems(){
	$.ajax({
		type : 'POST',
		url  : 'ajax/getWishlist.php',
		data : {getCountWishlistItems:true},
		success :  function(data){
			if(data){
				$('.count-wishlist-items').html(data);
			}
		}
	});
	return false;
}

function editProfile(){
	$.ajax({
		type : 'POST',
		url  : 'ajax/getAccount.php',
		data : { editProfile:true },
		beforeSend: function(){
			$("#editProfile").html('Préparation');
		},
		success :  function(response){
			$('#profileDatas').html(response);
		}
	});
	return false;
}

function getModAccountCity(val){
	$('#dropdownModSelectCity').hide();
	if(val.length >= 2){
		$.ajax({
			type : 'POST',
			url  : 'ajax/getAccount.php',
			data : { getAccountCity:true,value:val },
			success :  function(response){
				$('#dropdownModSelectCity').show();
				$('#dropdownModSelectCity').html(response);
			}
		});
	}
	else{
		$('#dropdownModSelectCity').hide();
	}
	return false;
}

function setAccountModCityInput(id, postal, name){
	$('#ModPostal').val(postal);
	$('#ModCityID').val(id);
	$('#ModCityInput').val(postal+' '+name);
	$('#dropdownModSelectCity').hide();
	return false;
}
function getAddBillingAddressCity(val){
	$('#BillingAddAddressCity').hide();
	if(val.length >= 2){
		$.ajax({
			type : 'POST',
			url  : 'ajax/getAccount.php',
			data : { getAddBilAddressCity:true,value:val },
			success :  function(response){
				$('#BillingAddAddressCity').show();
				$('#BillingAddAddressCity').html(response);
			}
		});
		return false;
	}
	else{
		$('#BillingAddAddressCity').hide();
	}
}

function setBilAddressCityInput(id, postal, name){
	$('#addBilAddressPostal').val(postal);
	$('#addBilAddressCityID').val(id);
	$('#setBilAddressCityName').val(postal+' '+name);
	$('#BillingAddAddressCity').hide();
	return false;
}

function getAddAddressCity(val){
	$('#dropdownAddAddressCity').hide();
	if(val.length >= 2){
		$.ajax({
			type : 'POST',
			url  : 'ajax/getAccount.php',
			data : { getAddAddressCity:true,value:val },
			success :  function(response){
				$('#dropdownAddAddressCity').show();
				$('#dropdownAddAddressCity').html(response);
			}
		});
		return false;
	}
	else{
		$('#dropdownAddAddressCity').hide();
	}
}
function setAddressCityInput(id, postal, name){
	$('#addAddressPostal').val(postal);
	$('#addAddressCityID').val(id);
	$('#setAddressCityName').val(postal+' '+name);
	$('#dropdownAddAddressCity').hide();
	return false;
}

function addDeliveryAddress(){
	var addAddressName = $('#addAddressName').val();
	var addAddressFirstname = $('#addAddressFirstname').val();
	var addAddressLastname = $('#addAddressLastname').val();
	var addAddressText = $('#addAddressText').val();
	var addAddressPostal = $('#addAddressPostal').val();
	var addAddressCity = $('#addAddressCityID').val();
	var addAddressPhone = $('#addAddressPhone').val();
	if(addAddressName == ''){
		$('#errorModal').modal('show');
		$('#errorDetails').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> Vous devez renseigner un Nom pour votre adresse.</div>');
	}
	else if(addAddressFirstname == ''){
		$('#errorModal').modal('show');
		$('#errorDetails').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> Vous devez renseigner le Nom.</div>');
	}
	else if(addAddressLastname == ''){
		$('#errorModal').modal('show');
		$('#errorDetails').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> Vous devez renseigner le Prénom.</div>');
	}
	else if(addAddressText == ''){
		$('#errorModal').modal('show');
		$('#errorDetails').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> Vous devez renseigner une adresse.</div>');
	}
	else if($('#setAddressCityName').val() == ''){
		$('#errorModal').modal('show');
		$('#errorDetails').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> Vous devez renseigner une ville et un code postal.</div>');
	}
	else if(addAddressPhone == ''){
		$('#errorModal').modal('show');
		$('#errorDetails').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> Vous devez renseigner un numéro de téléphone.</div>');
	}
	else{
		$.ajax({
			type : 'POST',
			url  : 'ajax/getAccount.php',
			data : {
				addDeliveryAddress:true,
				addAddressName:addAddressName,
				addAddressFirstname:addAddressFirstname,
				addAddressLastname:addAddressLastname,
				addAddressText:addAddressText,
				addAddressPostal:addAddressPostal,
				addAddressCity:addAddressCity,
				addAddressPhone:addAddressPhone
			},
			success :  function(response){
				if($.trim(response) == 'success'){
					window.location.href = "checkout.php?addAddress=success";
				}
			}
		});
		return false;
	}
}

function addBillingAddress(){
	var addBilAddressName = $('#addBilAddressName').val();
	var addBilAddressFirstname = $('#addBilAddressFirstname').val();
	var addBilAddressLastname = $('#addBilAddressLastname').val();
	var addBilAddressText = $('#addBilAddressText').val();
	var addBilAddressPostal = $('#addBilAddressPostal').val();
	var addBilAddressCity = $('#addBilAddressCityID').val();
	var addBilAddressPhone = $('#addBilAddressPhone').val();
	if(addBilAddressName == ''){
		$('#errorModal').modal('show');
		$('#errorDetails').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> Vous devez renseigner un Nom pour votre adresse.</div>');
	}
	else if(addBilAddressFirstname == ''){
		$('#errorModal').modal('show');
		$('#errorDetails').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> Vous devez renseigner le Nom.</div>');
	}
	else if(addBilAddressLastname == ''){
		$('#errorModal').modal('show');
		$('#errorDetails').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> Vous devez renseigner le Prénom.</div>');
	}
	else if(addBilAddressText == ''){
		$('#errorModal').modal('show');
		$('#errorDetails').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> Vous devez renseigner une adresse.</div>');
	}
	else if($('#setBilAddressCityName').val() == ''){
		$('#errorModal').modal('show');
		$('#errorDetails').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> Vous devez renseigner une ville et un code postal.</div>');
	}
	else if(addBilAddressPhone == ''){
		$('#errorModal').modal('show');
		$('#errorDetails').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> Vous devez renseigner un numéro de téléphone.</div>');
	}
	else{
		$.ajax({
			type : 'POST',
			url  : 'ajax/getAccount.php',
			data : {
				addBillingAddress:true,
				addBilAddressName:addBilAddressName,
				addBilAddressFirstname:addBilAddressFirstname,
				addBilAddressLastname:addBilAddressLastname,
				addBilAddressText:addBilAddressText,
				addBilAddressPostal:addBilAddressPostal,
				addBilAddressCity:addBilAddressCity,
				addBilAddressPhone:addBilAddressPhone
			},
			success :  function(response){
				if($.trim(response) == 'success'){
					window.location.href = "checkout.php?addBilAddress=success";
				}
			}
		});
		return false;
	}
}

function setAccountData(){
	var modAccEmail = $('#modAccEmail').val();
	var modAccFirstname = $('#modAccFirstname').val();
	var modAccLastname = $('#modAccLastname').val();
	var modAccAddress = $('#modAccAddress').val();
	var modAccPostal = $('#ModPostal').val();
	var modAccCityID = $('#ModCityID').val();
	var modAccPhone = $('#modAccPhone').val();
	var modAccPassword = $('#modAccPassword').val();
	if(modAccPassword == ''){
		$('#passwordRequiredModal').modal('show');
	}
	else{
		$.ajax({
			type : 'POST',
			url  : 'ajax/getAccount.php',
			data : {
				editProfilDatas:true,
				modAccEmail:modAccEmail,
				modAccFirstname:modAccFirstname,
				modAccLastname:modAccLastname,
				modAccAddress:modAccAddress,
				modAccPostal:modAccPostal,
				modAccCityID:modAccCityID,
				modAccPhone:modAccPhone,
				modAccPassword:modAccPassword
			},
			success :  function(response){
				if($.trim(response) == 'success'){
					window.location.href = "account.php?modSuccess=true";
				}
			}
		});
		return false;
	}
}

function setAccountDelete(){
	$('#checkDelVerifyPassword').hide();
	var Password = $('#delAccPassword').val();
	if(Password == ''){
		$('#checkDelVerifyPassword').show();
	}
	else{
		$.ajax({
			type : 'POST',
			url  : 'ajax/getAccount.php',
			data : {
				setAccountDelete:true,
				delAccountPassword:Password
			},
			success :  function(response){
				if($.trim(response) == 'success'){
					window.location.href = "index.php?delSuccess=true";
				}
			}
		});
	}
}

function setValidateAddress(id){
	var addressID = id;
	$.ajax({
		type : 'POST',
		url  : 'ajax/getAccount.php',
		data : {
			setValidateAddress:true,
			addressID:addressID
		},
		success :  function(response){
			window.location.href = "account.php?modSuccess=true";
		}
	});
	return false;
}

function setDeleteAddress(id){
	var addressID = id;
	$.ajax({
		type : 'POST',
		url  : 'ajax/getAccount.php',
		data : {
			setDeleteAddress:true,
			addressID:addressID
		},
		success :  function(response){
			window.location.href = "account.php?delSuccess=true";
		}
	});
	return false;
}

function toggleNewAddressForm(){
	$('#addNewAddress').hide();
}
function toggleNewBillingAddressForm(){
	$('#addNewBillingAddress').hide();
}
function getDeliveryAddress(val){
	$('#setDeliveryAddress').hide();
	$('#addNewAddress').hide();
	if(val == 0){
		$('#addNewAddress').show();
	}
	else{
		$.ajax({
			type : 'POST',
			url  : 'ajax/getAccount.php',
			data : {getAddressDetail:true, addressID:val},
			success :  function(data){
				if($.trim(data)){
					$('#setDeliveryAddress').show();
					$('#setDeliveryAddress').html(data);
				}
				else{
					$('#logRegError').show();
					$('#logRegError').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> '+data+'</div>');
					$("#btn-submit-login").html('Me connecter');
				}
			}
		});
		return false;
	}
}

function getBillingAddress(val){
	$('#setBillingAddress').hide();
	$('#addNewBillingAddress').hide();
	if(val == 0){
		$('#addNewBillingAddress').show();
	}
	else{
		$.ajax({
			type : 'POST',
			url  : 'ajax/getAccount.php',
			data : {getAddressDetail:true, addressID:val},
			success :  function(data){
				if($.trim(data)){
					$('#setBillingAddress').show();
					$('#setBillingAddress').html(data);
				}
				else{
					$('#logRegError').show();
					$('#logRegError').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> '+data+'</div>');
					$("#btn-submit-login").html('Me connecter');
				}
			}
		});
		return false;
	}
}

function setNewOrder(){
	var totalCart = $('#totalCart').val();
	var selectDeliveryAddress = $('#selectDeliveryAddress').val();
	var selectBillingAddress = $('#selectBillingAddress').val();
	var selectShipmentMethod = $('#selectShipmentMethod').val();
	var selectPaymentMethod = $('#selectPaymentMethod').val();
	if(selectDeliveryAddress == 0){
		$('#errorModal').modal('show');
		$('#errorDetails').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> Vous devez choisir l\'adresse de livraison !</div>');
	}
	else if(selectBillingAddress == 0){
		$('#errorModal').modal('show');
		$('#errorDetails').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> Vous devez choisir l\'adresse de facturation !</div>');
	}
	else if(selectShipmentMethod == 0){
		$('#errorModal').modal('show');
		$('#errorDetails').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> Vous devez choisir un transporteur !</div>');
	}
	else if(selectPaymentMethod == 0){
		$('#errorModal').modal('show');
		$('#errorDetails').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> Vous devez choisir un moyen de paiement !</div>');
	}
	else if(totalCart == 0){
		$('#errorModal').modal('show');
		$('#errorDetails').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> Votre panier est vide !</div>');
	}
	else{
		$.ajax({
			type : 'POST',
			url  : 'ajax/getChekout.php',
			data : {setNewOrder:true, deliveryAddress:selectDeliveryAddress, billingAddress:selectBillingAddress, shipmentMethod:selectShipmentMethod, paymentMethod:selectPaymentMethod, totalCart:totalCart},
			success :  function(data){
				if($.trim(data) != 'error'){
					window.location.href = data;
				}
				else{
				$('#errorModal').modal('show');
				$('#errorDetails').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> '+data+'</div>');
				}
			}
		});
	}
}

function getMondialRelay(){
	$('#getMondialRelayModal').modal('show');
	$("#mondialRelayDetails").MR_ParcelShopPicker({
		Target: "#mondialRelayID",
		Brand: "BDTEST  ",
		Country: "FR",
		PostCode: $('#userPostal').val(),
		ColLivMod: "24R", // Mode de livraison (Standard [24R], XL [24L], XXL [24X], Drive [DRI])
		NbResults: "10",// Nombre de Point Relais à afficher
		ShowResultsOnMap: true,
		DisplayMapInfo: true,
		CSS: 1,
		Responsive: true,
		OnParcelShopSelected: function(data) {
			$("#mr_Name").html(data.Nom);
			$("#mr_Address").html(data.Adresse1);
			$("#mr_CP").html(data.CP);
			$("#mr_City").html(data.Ville);
			$("#mr_Country").html(data.Pays);
			var obj = {'Name': data.Nom,'Address': data.Adresse1,'CP': data.CP,'City': data.Ville,'Country': data.Pays};
			var test = JSON.stringify(obj);
		}
	});
}

function setShipmentMethod(id,totalWeight){
	if($('#userPostal').val() == ''){
		$('#selectShipmentMethod').val('0');
		return false;
	}
	else{
		$.ajax({
			type : 'POST',
			url  : 'ajax/getChekout.php',
			data : {setShipmentMethod:true,totalWeight:totalWeight,methodID:id},
			success :  function(data){
				data = JSON.parse(data);
				if(data.isMondialRelay == 1){
					getMondialRelay();
				}
				if(data.checkoutResult){
					$('#chekoutTotalPrice').html(data.checkoutResult+' €');
					$('#totalCart').val(data.checkoutResult);
				}
				else{
					$('#errorModal').modal('show');
					$('#errorDetails').html('<div class="alert alert-danger"><i class="fa fa-warning"></i> '+data+'/div>');
				}
			}
		});
		return false;
	}
}
