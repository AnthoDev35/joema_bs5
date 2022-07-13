
(function ($) {
  // USE STRICT
  "use strict";

  // Dropdown 
  try {
    var menu = $('.js-item-menu');
    var sub_menu_is_showed = -1;

    for (var i = 0; i < menu.length; i++) {
      $(menu[i]).on('click', function (e) {
        e.preventDefault();
        $('.js-right-sidebar').removeClass("show-sidebar");        
        if (jQuery.inArray(this, menu) == sub_menu_is_showed) {
          $(this).toggleClass('show-dropdown');
          sub_menu_is_showed = -1;
        }
        else {
          for (var i = 0; i < menu.length; i++) {
            $(menu[i]).removeClass("show-dropdown");
          }
          $(this).toggleClass('show-dropdown');
          sub_menu_is_showed = jQuery.inArray(this, menu);
        }
      });
    }
    $(".js-item-menu, .js-dropdown").click(function (event) {
      event.stopPropagation();
    });

    $("body,html").on("click", function () {
      for (var i = 0; i < menu.length; i++) {
        menu[i].classList.remove("show-dropdown");
      }
      sub_menu_is_showed = -1;
    });

  } catch (error) {
    console.log(error);
  }

  var wW = $(window).width();
    // Right Sidebar
    var right_sidebar = $('.js-right-sidebar');
    var sidebar_btn = $('.js-sidebar-btn');

    sidebar_btn.on('click', function (e) {
      e.preventDefault();
      for (var i = 0; i < menu.length; i++) {
        menu[i].classList.remove("show-dropdown");
      }
      sub_menu_is_showed = -1;
      right_sidebar.toggleClass("show-sidebar");
    });

    $(".js-right-sidebar, .js-sidebar-btn").click(function (event) {
      event.stopPropagation();
    });

    $("body,html").on("click", function () {
      right_sidebar.removeClass("show-sidebar");

    });
 

  // Sublist Sidebar
  try {
    var arrow = $('.js-arrow');
    arrow.each(function () {
      var that = $(this);
      that.on('click', function (e) {
        e.preventDefault();
        that.find(".arrow").toggleClass("up");
        that.toggleClass("active");
		$('.navbar__list li').removeClass("active");
		$('.navbar-mobile__list li').removeClass("active");
        that.parent().find('.js-sub-list').slideToggle("250");
      });
    });

  } catch (error) {
    console.log(error);
  }


  try {
    // Hamburger Menu
    $('.hamburger').on('click', function () {
      $(this).toggleClass('active');
      $('.navbar-mobile').slideToggle('500');
    });
    $('.navbar-mobile__list li.has-dropdown > a').on('click', function () {
      var dropdown = $(this).siblings('ul.navbar-mobile__dropdown');
      $(this).toggleClass('active');
      $(dropdown).slideToggle('500');
      return false;
    });
  } catch (error) {
    console.log(error);
  }
  // Load more
  try {
    var list_load = $('.js-list-load');
    if (list_load[0]) {
      list_load.each(function () {
        var that = $(this);
        that.find('.js-load-item').hide();
        var load_btn = that.find('.js-load-btn');
        load_btn.on('click', function (e) {
          $(this).text("Loading...").delay(1500).queue(function (next) {
            $(this).hide();
            that.find(".js-load-item").fadeToggle("slow", 'swing');
          });
          e.preventDefault();
        });
      })

    }
  } catch (error) {
    console.log(error);
  }

    var navbars = ['header', 'aside'];
    var hrefSelector = 'a:not([target="_blank"]):not([href^="#"]):not([class^="chosen-single"])';
    var linkElement = navbars.map(element => element + ' ' + hrefSelector).join(', ');
    $(".animsition").animsition({
      inClass: 'fade-in',
      outClass: 'fade-out',
      inDuration: 400,
      outDuration: 400,
      linkElement: linkElement,
      loading: true,
      loadingParentElement: 'html',
      loadingClass: 'page-loader',
      loadingInner: '<div class="page-loader__spin"></div>',
      timeout: false,
      timeoutCountdown: 2000,
      onLoadEvent: true,
      browser: ['animation-duration', '-webkit-animation-duration'],
      overlay: false,
      overlayClass: 'animsition-overlay-slide',
      overlayParentElement: 'html',
      transition: function (url) {
        window.location.href = url;
      }
    });
  
  
  })(jQuery);
(function ($) {
  // USE STRICT
  "use strict";

  try {
    
    $('[data-toggle="tooltip"]').tooltip();

  } catch (error) {
    console.log(error);
  }

  // Chatbox
  try {
    var inbox_wrap = $('.js-inbox');
    var message = $('.au-message__item');
    message.each(function(){
      var that = $(this);

      that.on('click', function(){
        $(this).parent().parent().parent().toggleClass('show-chat-box');
      });
    });
    

  } catch (error) {
    console.log(error);
  }

    $(window).on( "load", function() {
		if($('#setMailBoxResults')){
			$.ajax({
				url: 'ajax/getMailBoxInfo.php',
				type: 'post',
				data: {
					getMails:true
				},
				success: function(response){
					$('#setMailBoxResults').html(response);
				},
				error: function(response){
					$(this).html('Syncroniser les emails');
				},
			});
			return false;
		}
	});
	$('#adm-login-form').on('submit', function(e){
		e.preventDefault();
        var data = $("#adm-login-form").serialize();
        $.ajax({
            type : 'POST',
            url  : 'ajax/sendLogin.php',
            data : data,
            beforeSend: function(){
				$('#loadingModal').modal('show');
            },
            success :  function(data){
				setTimeout(function(){
					if(data == 1){
							$('#loadingModal').modal('hide');
							window.location.href = 'index.php';
					}
					else{
						$('#loadingModal').modal('hide');
						window.location.href = 'login.php?errorData='+data;
					}
				},2000);
            },
        });
	});

	$('#sendDisconnect').on('click', function(e){
		e.preventDefault();
		$('#loadingModal').modal('show');
        $.get('ajax/sendLogout.php?isDisconnect=true', function(response){
				setTimeout(function(){
					if(response == 1){
						window.location.href = 'login.php?isDisconnected=true';
					}
				},2000);
        });
	});
	
	/*Articles*/
	$('#setAddArticleForm').on('submit', function(e){
		e.preventDefault();
		
		var artCategorie = $("select#setArtCategorie").val();
		var artSubCategorie = $("select#setArtSubCategorie").val();
		var artName = $("input#setArticleName").val();
		var artRef = $("input#setArtRef").val();
		var artDescription = CKEDITOR.instances['setArtDescription'].getData();
		var artImageRenamed1 = $("input#setArtImageRenamed1").val();
		var artImageRenamed2 = $("input#setArtImageRenamed2").val();
		var artImageRenamed3 = $("input#setArtImageRenamed3").val();
		var artImageRenamed4 = $("input#setArtImageRenamed4").val();
		var artStockManager = $("select#artStockManager").val();
		var artStock = $("select#setArtStock").val();
		var artShipment = $("select#setArtShipment").val();
		var artWeight = $("input#setArtWeight").val();
		var artIsNew = $("select#setArtIsNew").val();
		
		var isLastChance = $("input[name='setArtLastChance']:checked").val();
		var artIsActive = $("input[name='setArtIsActive']:checked").val();
		var artNormalPrice = $("input#setArtNormalPrice").val();
		var artReducePrice = $("input#setArtReducePrice").val();
		
		$.ajax({
			url: "ajax/getArticleRequests.php",
			type: "POST",
			data: {
				addArticle:true,
				artCategorie: artCategorie,
				artSubCategorie: artSubCategorie,
				artName: artName,
				artRef: artRef,
				artDescription: artDescription,
				artImageRenamed1: artImageRenamed1,
				artImageRenamed2: artImageRenamed2,
				artImageRenamed3: artImageRenamed3,
				artImageRenamed4: artImageRenamed4,
				artStockManager:artStockManager,
				artStock: artStock,
				artShipment: artShipment,
				artWeight:artWeight,
				artIsNew:artIsNew,
				isLastChance:isLastChance,
				artIsActive:artIsActive,
				artNormalPrice:artNormalPrice,
				artReducePrice:artReducePrice
			},
			success: function(response) {
				response = JSON.parse(response);
				if(response.success == 1){
					if(response.manager == 1){
						getAddedColor(response.artID);
					}
					else if(response.manager == 2){
						getAddedSize(response.artID);
					}
					else if(response.manager == 3){
						getAddedColorAndSize(response.artID);
					}
					else {
						window.location.href = 'articles.php';
					}
				}
				else if(response.error){
					$('#errorDatas').html(response.error);
					$('#errorModal').modal('show');
				}
			}
		});
		return false;
	});
	
	$('#setModArticleForm').on('submit', function(e){
		e.preventDefault();
		var articleID = $("#modArticleID").val();
		var artCategorie = $("select#setArtCategorie").val();
		var artSubCategorie = $("select#setArtSubCategorie").val();
		var artName = $("input#setArtName").val();
		var artRef = $("input#setArtRef").val();
		var artDescription = CKEDITOR.instances['setArtDescription'].getData();
		var artImageRenamed1 = $("input#setArtImageRenamed1").val();
		var artImageRenamed2 = $("input#setArtImageRenamed2").val();
		var artImageRenamed3 = $("input#setArtImageRenamed3").val();
		var artImageRenamed4 = $("input#setArtImageRenamed4").val();
		var artStockManager = $("select#artStockManager").val();
		var artStock = $("select#setArtStock").val();
		var artShipment = $("select#setArtShipment").val();
		var artWeight = $("input#setArtWeight").val();
		var artIsNew = $("select#setArtIsNew").val();
		
		var artColors = [];
		$.each($("#setMultiColors option:selected"), function() {
			artColors.push($(this).val()); 
		});

		var artSizes = [];
		$.each($("#setMultiSizes option:selected"), function() {
			artSizes.push($(this).val()); 
		});
		
		var isLastChance = $("input[name='setArtLastChance']:checked").val();
		var artIsActive = $("input[name='setArtIsActive']:checked").val();
		var artNormalPrice = $("input#setArtNormalPrice").val();
		var artReducePrice = $("input#setArtReducePrice").val();
		var artPage = $("input#artPage").val();
		
		$.ajax({
			url: "ajax/getArticleRequests.php",
			type: "POST",
			data: {
				modArticle: true,
				articleID: articleID,
				artCategorie: artCategorie,
				artSubCategorie: artSubCategorie,
				artName: artName,
				artRef: artRef,
				artDescription: artDescription,
				artImageRenamed1: artImageRenamed1,
				artImageRenamed2: artImageRenamed2,
				artImageRenamed3: artImageRenamed3,
				artImageRenamed4: artImageRenamed4,
				artStockManager:artStockManager,
				artStock: artStock,
				artShipment: artShipment,
				artWeight:artWeight,
				artIsNew:artIsNew,
				artColors:artColors,
				artSizes:artSizes,
				isLastChance:isLastChance,
				artIsActive:artIsActive,
				artNormalPrice:artNormalPrice,
				artReducePrice:artReducePrice,
				artPage:artPage
			},
			success: function(response) {
				response = JSON.parse(response);
				if(response.success == '1'){
					if(response.manager == 1){
						getAddedColor(response.artID);
					}
					else if(response.manager == 2){
						getAddedSize(response.artID);
					}
					else if(response.manager == 3){
						getAddedColorAndSize(response.artID);
					}
					else {
						window.location.href = 'articles.php?isRefreshPage=true&getArticlePage='+response.page;
					}
				}
				else if(response.error){
					$('#errorDatas').html(response.error);
					$('#errorModal').modal('show');
				}
			}
		});
		return false;
	});
	
	$('#getArticleSearch').on('keyup',function(){
		if($(this).val().length >= 2){
			$.ajax({
				url: "ajax/getArticleRequests.php",
				type: "POST",
				data: {
					getArticleSearch: true,
					searchText: $(this).val()
				},
				cache: false,
				success: function(response) {
					$('#articleSearchResults').addClass('show');
					$('#articleSearchResults').html(response);
				}
			});
			return false;
		}
	});
	
	/*Carrousels*/
	
	$('#submit-add-carrousel').on('submit', function(e){
		e.preventDefault();
		$('#loadingModal').modal('show');
		// get values from FORM
		var carCategorie = $("#setCarrouselCategorieID").val();
		var carTitle = $("#setCarrouselTitle").val();
		var carPercentDiscount = $("#setCarrouselReduction").val();
		var carDescription = CKEDITOR.instances['setCarrouselDescription'].getData();
		var carImageName = $("#setCarrouselImageRenamed").val();
		var carIsActive = $("#setIsActive").val();
		
		$.ajax({
			url: "ajax/getCarrousels.php",
			type: "POST",
			data: {
				getAddCarrousel: true,
				carCategorie: carCategorie,
				carTitle: carTitle,
				carPercentDiscount: carPercentDiscount,
				carDescription: carDescription,
				carImageName: carImageName,
				carIsActive: carIsActive
			},
			cache: false,
			success: function(response) {
				$('#loadingModal').modal('hide');
				if($.trim(response) == 'success'){
					window.location.href = 'carrousels.php?addCarrousel=success';
				}
				else{
					$('#errorDatas').html(response);
					$('#errorModal').modal('show');
				}
			}
		});
		return false;
	});
	
	$('#submit-mod-carrousel').on('submit', function(e){
		e.preventDefault();
		$('#loadingModal').modal('show');
		// get values from FORM
		var carrouselID = $("#carrouselID").val();
		var carCategorie = $("#setCarrouselCategorieID").val();
		var carTitle = $("#setCarrouselTitle").val();
		var carPercentDiscount = $("#setCarrouselReduction").val();
		var carDescription = CKEDITOR.instances['setCarrouselDescription'].getData();
		var carImageName = $("#setCarrouselImageRenamed").val();
		var carIsActive = $("#setIsActive").val();
		
		$.ajax({
			url: "ajax/getCarrousels.php",
			type: "POST",
			data: {
				getModCarrousel: true,
				carrouselID: carrouselID,
				carCategorie: carCategorie,
				carTitle: carTitle,
				carPercentDiscount: carPercentDiscount,
				carDescription: carDescription,
				carImageName: carImageName,
				carIsActive: carIsActive
			},
			cache: false,
			success: function(response) {
				$('#loadingModal').modal('hide');
				if($.trim(response) == 'success'){
					window.location.href = 'carrousels.php?modCarrousel=success';
				}
				else{
					$('#errorDatas').html(response);
					$('#errorModal').modal('show');
				}
			}
		});
		return false;
	});
	
	// submit-add-gift-certificate
	
	$('#submit-add-gift-certificate').on('submit', function(e){
		e.preventDefault();
		// get values from FORM
		var addReference = $("#setGiftReference").val();
		var addTotalAmount = $("#setTotalAmount").val();
		var addLimitAmount = $("#setLimitAmount").val();
		var addBuyDate = $("#setBuyDate").val();
		var addLimitDate = $("#setLimitDate").val();
		var addBuyerName = $("#setBuyerName").val();
		var addCustomerName = $("#setCustomerName").val();
		var addSendToMail = $("#setSendToMail").val();
		var addCustomerMail = $("#setCustomerMail").val();
		var addStatus = $("#setIsActive").val();
		
		if(addReference == ''){
			alert('La référence est obligatoire!');
		}
		else if(addTotalAmount == ''){
			alert('Le montant total est obligatoire!');
		}
		else if(addLimitAmount == ''){
			alert('Le montant utilisé est obligatoire!');
		}
		else if(addBuyDate == ''){
			alert('La date d\'achat est obligatoire!');
		}
		else if(addLimitDate == ''){
			alert('La date limite est obligatoire!');
		}
		else if(addBuyerName == ''){
			alert('Le Nom de l\'acheteur est obligatoire!');
		}
		else if(addCustomerName == ''){
			alert('Le Nom du bénéficiaire est obligatoire!');
		}
		else if(addSendToMail == 1 && addCustomerMail == ''){
			alert('L\'adresse email du bénéficiaire est obligatoire!');
		}
		else if(addStatus == ''){
			alert('Le status est obligatoire!');
		}
		else{
			$.ajax({
				url: "createCheques.php",
				type: "POST",
				data: {
					setAddGiftCertificate: true,
					setAddReference:addReference,
					setAddTotalAmount:addTotalAmount,
					setAddLimitAmount:addLimitAmount,
					setAddBuyDate:addBuyDate,
					setAddLimitDate:addLimitDate,
					setAddBuyerName:addBuyerName,
					setAddCustomerName:addCustomerName,
					setAddSendToMail:addSendToMail,
					setAddCustomerMail:addCustomerMail,
					setAddStatus:addStatus
				},
				success: function(response) {
					if($.trim(response) == 'mail-success'){
						$('#loadingModal').modal('hide');
						window.location.href = 'gift_certificates.php?addNewMailGift=success';
					}
					else if($.trim(response) == 'nomail-success'){
						$('#loadingModal').modal('hide');
						window.location.href = 'gift_certificates.php?addNewGift=success';
					}
					else{
						$('#errorDatas').html(response);
						$('#errorModal').modal('show');
					}
				},
				error: function() {
					
				}
			});
			return false;
		}
	});
	
	$('#submit-mod-gift-certificate').on('submit', function(e){
		e.preventDefault();
		// get values from FORM
		var modGiftCertificateID =  $("#setGiftCertificateID").val();
		var addReference = $("#setGiftReference").val();
		var addTotalAmount = $("#setTotalAmount").val();
		var addLimitAmount = $("#setLimitAmount").val();
		var addStatus = $("#setIsActive").val();
		if(addReference == ''){
			alert('La référence est obligatoire!');
		}
		else if(addTotalAmount == ''){
			alert('Le montant total est obligatoire!');
		}
		else if(addLimitAmount == ''){
			alert('Le montant utilisé est obligatoire!');
		}
		else if(addStatus == ''){
			alert('Le status est obligatoire!');
		}
		else{
			$('#loadingModal').modal('show');
			setTimeout(function(){
				$.ajax({
					url: "ajax/getRequests.php",
					type: "POST",
					data: {
						setModGiftCertificate: true,
						setModGiftCertificateID:modGiftCertificateID,
						setAddReference:addReference,
						setAddTotalAmount:addTotalAmount,
						setAddLimitAmount:addLimitAmount,
						setAddStatus:addStatus
					},
					success: function(response) {
						if($.trim(response) == 'success'){
							$('#loadingModal').modal('hide');
							window.location.href = 'gift_certificates.php?modGift=success';
						}
						else{
							alert(response);
						}
					},
					error: function() {
						
					}
				});
				return false;
			}, 2000);
		}
	});
	
	$('#searchColorArtID').on('keyup', function(e){
		e.preventDefault();
		if ($(this).val().length >= 2) {
			$.ajax({
				type : 'POST',
				url  : 'ajax/getRequests.php',
				data : {
					setArtColorSearch:true,
					searchArtText:$(this).val()
				},
				success :  function(data){
					data = JSON.parse(data);
					if(data.datas){
						$('#dropdownColorSearchArticle').html(data.datas);
						$("#dropdownColorSearchArticle").addClass('show');
					}
					else{
						$("#dropdownColorSearchArticle").removeClass('show');
					}
				}
			});
			return false;
		}
		else{
			$("#dropdownColorSearchArticle").removeClass('show');
		}
	});
})(jQuery);

$(document).on('keyup', '.search-size-artID', function(e) {
	e.preventDefault();
	if ($(this).val().length >= 2) {
		$.ajax({
			type : 'POST',
			url  : 'ajax/getRequests.php',
			data : {
				setArtSizeSearch:true,
				searchArtText:$(this).val()
			},
			success :  function(data){
				data = JSON.parse(data);
				if(data.datas){
					$('#dropdownSearchSizeArticle').html(data.datas);
					$("#dropdownSearchSizeArticle").addClass('show');
				}
				else{
					$("#dropdownSearchSizeArticle").removeClass('show');
				}
			}
		});
		return false;
	}
	else{
		$("#dropdownSearchSizeArticle").removeClass('show');
	}
});

$(document).on('keyup', '.search-color-artID', function(e) {
	e.preventDefault();
	if ($(this).val().length >= 2) {
		$.ajax({
			type : 'POST',
			url  : 'ajax/getRequests.php',
			data : {
				setArtColorSearch:true,
				searchArtText:$(this).val()
			},
			success :  function(data){
				data = JSON.parse(data);
				if(data.datas){
					$('#dropdownSearchColorArticle').html(data.datas);
					$("#dropdownSearchColorArticle").addClass('show');
				}
				else{
					$("#dropdownSearchColorArticle").removeClass('show');
				}
			}
		});
		return false;
	}
	else{
		$("#dropdownSearchColorArticle").removeClass('show');
	}
});

function setDataColor(val){
	var newval = val.replace('#', '');
	$('#setEditColorHex').val(newval);
}

function getStockManager(val){
	if(val == 0) {
		$('#stockNormalQuantity').show();
		$('#stockNormalManager').show();
		$('#stockNormalShipment').addClass('col-md-6');
		$('#stockNormalShipment').removeClass('col-md-12');
	}
	else{
		$('#stockNormalQuantity').hide();
		$('#stockNormalManager').show();
		$('#stockNormalShipment').addClass('col-md-12');
		$('#stockNormalShipment').removeClass('col-md-6');
	}
}

function getRefreshMails(){
	$('#reloadMails').html('');
	$('#allMailShow').hide();
	setTimeout(function(){
		$.ajax({
			url: 'ajax/getMailBoxInfo.php',
			type: 'post',
			data: {
				getMails:true
			},
			success: function(response){
				$('#setMailBoxResults').html(response);
				$('#allMailShow').show();
			},
		});
	}, 2000);
	return false;
}

function getAddDataModal(data){
	$.get('ajax/getRequests.php?getDataModal=true&data='+data, function(response){
		if(response != 0){
			$('#contentModal').modal('show');
			$('#addContentModal').html(response);
		}
	});
	return false;
}

function getSubCategorieDatas(value){
	$.get('ajax/getRequests.php?getSubCategorieData=true&categorieID='+value, function(response){
		if(response != 0){
			$('#setArtSubCategorie').html(response);
		}
	});
	return false;
}

function getAddedCategorie(){
	$.get('ajax/getRequests.php?addedCategory=true', function(response){
		if(response != 0){
			$('#contentModal').modal('show');
			$('#addContentModal').html(response);
		}
	});
	return false;
}

function getAddedSubCategorie(){
	$.get('ajax/getRequests.php?addedSubCategory=true', function(response){
		if(response != 0){
			$('#contentModal').modal('show');
			$('#addContentModal').html(response);
		}
	});
	return false;
}

function setAddedCategorie(){
	$('#contentModal').modal('hide');
	$('#loadingModal').modal('show');
	var name = $('#categoryName').val();
	var imageName = $('#imageRenamed').val();
	var active = $('#IsActiveCategorie').val();
	var banner = $('#IsActiveBanner').val();
	$.ajax({
		url: "ajax/getRequests.php",
		type: "POST",
		data: {
			setQueryData: true,
			datas:'categorie',
			name:name,
			image:imageName,
			isBanner:banner,
			isActive:active
		},
		cache: false,
		success: function(response) {
			if($.trim(response) == 'success'){
				$('#loadingModal').modal('hide');
				window.location.href = 'category.php?addCategorie=success';
			}
		},
		error: function() {
			
		}
	});
	return false;
}

function setCategoryImage(){
	$('#imageUpload').hide();
	var img_file = new FormData();
	var files = $('#setCatImage')[0].files;
	
	if(files.length > 0 ){
	   img_file.append('setCatImage',files[0]);
		$.ajax({
			url: 'upload_cat_img.php',
			type: 'post',
			data: img_file,
			contentType: false,
			processData: false,
			success: function(response){
				if($.trim(response) != 0 && $.trim(response) != 1 && $.trim(response) != 2){
					$('#imageRenamed').val('assets/img/category/'+response);
					$('#imagePreview').show();
					$('#imagePreview').html('<img class="img-fluid" src="../assets/img/category/'+response+'" width="200px"/>');
					$('#btn-del-image-cat').show();
				}
				else{
					if(response == 0)
						response = 'Erreur code 0';
					else if(response == 1)
						response = 'Erreur code 1';
					else if(response == 2)
						response = 'Erreur code 2';
					else 
						response = 'Quelque chose!';
					$('#imageUpload').show();
					$('#resultImgUpload').show();
					$('#resultImgUpload').html(response);
				}
			},
		});
	}
	else{
		$('#resultImgUpload').show();
		$('#resultImgUpload').html('Une erreur c\'est produite.');
	}
}

function setImageCategoryDelete(){
	var name = $('#imageRenamed').val();
	$.get('ajax/getRequests.php?setImageCategoryDelete=true&ImageName='+name, function(response) {
		if(response == 0){
			alert('Une erreur c\'est produite.');
		}
		else{
			$('#setCatImage').val('');
			$('#imageRenamed').val('');
			$('#imagePreview').html('');
			$('#btn-del-image-cat').hide();
			$('#imageUpload').show();
		}
	});
	return false;
}

function setAddedSubCategorie(){
	$('#contentModal').modal('hide');
	var name = $('#subCategoryName').val();
	var categorieID = $('#selectArtCategorieID').val();
	var active = $('#IsActiveSubCategorie').val();
	
	$.ajax({
		url: "ajax/getRequests.php",
		type: "POST",
		data: {
			setQueryData: true,
			datas:'subCategorie',
			name:name,
			categorieID:categorieID,
			isActive:active
		},
		cache: false,
		success: function(response) {
			if($.trim(response) == 'success'){
				$('#loadingModal').modal('hide');
				window.location.href = 'category.php?addSubCategorie=success';
			}
		},
		error: function() {
			
		}
	});
	return false;
}

function setAddCategorie(){
	$('#contentModal').modal('hide');
	var name = $('#categoryName').val();
	var active = $('#IsActiveCategorie').val();
	$.ajax({
		url: "ajax/getRequests.php",
		type: "POST",
		data: {
			setQueryData: true,
			datas:'categorie',
			name:name,
			isActive:active
		},
		cache: false,
		success: function(response) {
			if($.trim(response) == 'success'){
				getCategorieReload();
			}
		},
		error: function() {
			
		}
	});
	return false;
}

function setAddSubCategorie(){
	$('#contentModal').modal('hide');
	var name = $('#subCategoryName').val();
	var categorieID = $('#selectArtCategorieID').val();
	var active = $('#IsActiveSubCategorie').val();
	$.ajax({
		url: "ajax/getRequests.php",
		type: "POST",
		data: {
			setQueryData: true,
			datas:'subCategorie',
			name:name,
			categorieID:categorieID,
			isActive:active
		},
		cache: false,
		success: function(response) {
			if($.trim(response) == 'success'){
				getSubCategorieReload();
			}
		},
		error: function() {
			
		}
	});
	return false;
}

function setAddColor(){
	$('#contentModal').modal('hide');
	var name = $('#colorName').val();
	var addColorHexadecimal = $('#setEditColorHex').val();
	var active = $('#IsActiveColor').val();
	$.ajax({
		url: "ajax/getRequests.php",
		type: "POST",
		data: {
			setQueryData: true,
			datas:'colors',
			name:name,
			colorHex:addColorHexadecimal,
			isActive:active
		},
		cache: false,
		success: function(response) {
			if($.trim(response) == 'success'){
				getColorsReload();
			}
		},
		error: function() {
			
		}
	});
	return false;
}

function setAddSize(){
	$('#contentModal').modal('hide');
	var name = $('#sizeName').val();
	var shortName = $('#sizeShortName').val();
	var active = $('#IsActiveSize').val();
	$.ajax({
		url: "ajax/getRequests.php",
		type: "POST",
		data: {
			setQueryData: true,
			datas:'sizes',
			name:name,
			shortName:shortName,
			isActive:active
		},
		cache: false,
		success: function(response) {
			if($.trim(response) == 'success'){
				getSizesReload();
			}
		},
		error: function() {
			
		}
	});
	return false;
}

function getCategorieReload(){
	$.get('ajax/getRequests.php?getQueryData=true&data=categorie', function(response){
		if(response != 0){
			$('#setArtCategorie').html(response);
		}
	});
	return false;
}
function getSubCategorieReload(){
	$.get('ajax/getRequests.php?getQueryData=true&data=subCategorie', function(response){
		if(response != 0){
			$('#setArtSubCategorie').html(response);
		}
	});
	return false;
}
function getColorsReload(){
	$.get('ajax/getRequests.php?getQueryData=true&data=colors', function(response){
		if(response != 0){
			$('#setArtColors').html(response);
		}
	});
	return false;
}
function getSizesReload(){
	$.get('ajax/getRequests.php?getQueryData=true&data=sizes', function(response){
		if(response != 0){
			$('#setArtSizes').html(response);
		}
	});
	return false;
}

function setArticleImage(value){
	$('#setArtImageUpload'+value).hide();
	var img_file = new FormData();
	var files = $('#setArtImage'+value)[0].files;
	
	if(files.length > 0 ){
	   img_file.append('setArtImage'+value,files[0]);
		if($('#setArtImageRenamed'+value).val() != ""){
			
		}
		$.ajax({
			url: 'upload_img.php',
			type: 'post',
			data: img_file,
			contentType: false,
			processData: false,
			success: function(response){
				if(response != 0 || response != 1 || response != 2){
					$('#setArtImageRenamed'+value).val('assets/img/products/'+response);
					$('#setArtImagePreview'+value).show();
					$('#setArtImagePreview'+value).html('<img class="img-fluid" src="../assets/img/products/'+response+'" width="200px"/>');
					$('#btn-del-image'+value).show();
				}
				else{
					if(response == 0)
						response = 'Erreur code 0';
					else if(response == 1)
						response = 'Erreur code 1';
					else if(response == 2)
						response = 'Erreur code 2';
					else 
						response = 'Quelque chose!';
					$('#setArtImageUpload'+value).show();
					$('#setResultImgUpload'+value).show();
					$('#setResultImgUpload'+value).html(response);
				}
			},
		});
	}
	else{
		$('#resultImgUpload').show();
		$('#resultImgUpload').html('Une erreur c\'est produite.');
	}
}

function setImageDelete(value){
	var name = $('#setArtImageRenamed'+value).val();
	$.get('ajax/getRequests.php?setImageDelete=true&ImageName='+name, function(response) {
		if(response == 0){
			alert('Une erreur c\'est produite.');
		}
		else{
			$('#setArtImage'+value).val('');
			$('#setArtImageRenamed'+value).val('');
			$('#setArtImagePreview'+value).html('');
			$('#btn-del-image'+value).hide();
			$('#setArtImageUpload'+value).show();
		}
	});
	return false;
}

	/*Edition suppression des catégories & sous catégories*/
function getEditCategorie(val){
	$('#loadingModal').modal('show');
	$.get('ajax/getRequests.php?isCategorie=true&editCategorie=true&categorieID='+val, function(response){
		setTimeout(function(){
			if(response){
				$('#loadingModal').modal('hide');
				$('#contentModal').modal('show');
				$('#addContentModal').html(response);
			}
		},1000);
	});
	return false;
}
	
function setEditCategorie(){
	$('#contentModal').modal('hide');
	$('#loadingModal').modal('show');
	var editCategorieID = $('#editCategorieID').val();
	var editCategorieName = $('#editCategoryName').val();
	var editBanner = $('#IsActiveBanner').val();
	var editImage = $('#imageRenamed').val();
	var editCategorieIsActive = $('#IsActiveEditCategorie').val();
	$.ajax({
		url: "ajax/getRequests.php",
		type: "POST",
		data: {
			editCategorie: true,
			editCategorieID: editCategorieID,
			editCategorieName: editCategorieName,
			editBanner: editBanner,
			editImage: editImage,
			editCategorieIsActive: editCategorieIsActive
		},
		cache: false,
		success: function(response) {
			if($.trim(response) == 'success'){
				$('#loadingModal').modal('hide');
				window.location.href = 'category.php?editCategorie=success';
			}
		},
		error: function() {
			
		}
	});
	return false;
}
	
function getDeleteCategorie(val){
	$('#loadingModal').modal('show');
	$.get('ajax/getRequests.php?isCategorie=true&deleteCategorie=true&categorieID='+val, function(response){
		setTimeout(function(){
			if(response){
				$('#loadingModal').modal('hide');
				$('#contentModal').modal('show');
				$('#addContentModal').html(response);
			}
		},1000);
	});
	return false;
}
	
function setDeleteCategorie(catID){
	$('#contentModal').modal('hide');
	$('#loadingModal').modal('show');
	$.ajax({
		url: "ajax/getRequests.php",
		type: "POST",
		data: {
			delCategorie: true,
			deleteCategorieID: catID
		},
		cache: false,
		success: function(response) {
			if($.trim(response) == 'success'){
				$('#loadingModal').modal('hide');
				window.location.href = 'category.php?deleteCategorie=success';
			}
		},
		error: function() {
			
		}
	});
	return false;
}

function getEditSubCategorie(val){
	$('#loadingModal').modal('show');
	$.get('ajax/getRequests.php?isSubCategorie&editSubCategorie=true&subCategorieID='+val, function(response){
		setTimeout(function(){
			if(response){
				$('#loadingModal').modal('hide');
				$('#contentModal').modal('show');
				$('#addContentModal').html(response);
			}
		},1000);
	});
	return false;
}
	
function setEditSubCategorie(){
	$('#contentModal').modal('hide');
	$('#loadingModal').modal('show');
	var editSubCategorieID = $('#editSubCategorieID').val();
	var editSubCategoryCategoryID = $('#editSubCategoryCategoryID').val();
	var editSubCategoryName = $('#editSubCategoryName').val();
	var IsActiveEditSubCategorie = $('#IsActiveEditSubCategorie').val();
	
	$.ajax({
		url: "ajax/getRequests.php",
		type: "POST",
		data: {
			editSubCategorie: true,
			editSubCategorieID: editSubCategorieID,
			editSubCategorieCategorieID: editSubCategoryCategoryID,
			editSubCategorieName: editSubCategoryName,
			editSubCategorieIsActive: IsActiveEditSubCategorie
		},
		cache: false,
		success: function(response) {
			if($.trim(response) == 'success'){
				$('#loadingModal').modal('hide');
				window.location.href = 'category.php?editSubCategorie=success';
			}
		},
		error: function() {
			
		}
	});
	return false;
}

function getDeleteSubCategorie(val){
	$('#loadingModal').modal('show');
	$.get('ajax/getRequests.php?isSubCategorie&deleteSubCategorie=true&subCategorieID='+val, function(response){
		setTimeout(function(){
			if(response){
				$('#loadingModal').modal('hide');
				$('#contentModal').modal('show');
				$('#addContentModal').html(response);
			}
		},1000);
	});
	return false;
}

function setDeleteSubCategorie(catID){
	$('#contentModal').modal('hide');
	$('#loadingModal').modal('show');
	$.ajax({
		url: "ajax/getRequests.php",
		type: "POST",
		data: {
			delSubCategorie: true,
			deleteSubCategorieID: catID
		},
		cache: false,
		success: function(response) {
			if($.trim(response) == 'success'){
				$('#loadingModal').modal('hide');
				window.location.href = 'category.php?deleteSubCategorie=success';
			}
		}
	});
	return false;
}

function getDeleteColor(val){
	$.get('ajax/getRequests.php?isColor&deleteColor=true&colorID='+val, function(response){
		response = JSON.parse(response);
		if(response.datas){
			$('#contentModal').modal('show');
			$('#addContentModal').html(response.datas);
		}
		else if(response.error){
			$('#errorDatas').html(response.error);
			$('#errorModal').modal('show');
			return false;
		}
	});
	return false;
}

function setDeleteColor(colorID){
	$('#contentModal').modal('hide');
	$('#loadingModal').modal('show');
	$.ajax({
		url: "ajax/getRequests.php",
		type: "POST",
		data: {
			delColor: true,
			deleteColorID: colorID
		},
		cache: false,
		success: function(response) {
			if($.trim(response) == 'success'){
				$('#loadingModal').modal('hide');
				window.location.href = 'colors.php?deleteColor=success';
			}
		},
		error: function() {
			
		}
	});
	return false;
}

function getEditColor(val){
	$('#loadingModal').modal('show');
	$.get('ajax/getRequests.php?isColor&editColor=true&colorID='+val, function(response){
		setTimeout(function(){
			if(response){
				$('#loadingModal').modal('hide');
				$('#contentModal').modal('show');
				$('#addContentModal').html(response);
			}
		},1000);
	});
	return false;
}

function getAddedColor(artID){
	if(artID == ''){
		artID = 0;
	}
	$.get('ajax/getRequests.php?isColor=true&addColor=true&artID='+artID, function(response){
		$('#contentModal').modal('show');
		$('#addContentModal').html(response);
	});
	return false;
}

function setAddedColor(){
	let artID = $('#colorArtID').val();
	let name = $('#colorName').val();
	let qtyStock = $('#qtyStock').val();
	let addColorHexadecimal = $('#setEditColorHex').val();
	let isLastColor = $("input[name='isLastColor']:checked").val();
	if(artID == ''){
		$('#errorDatas').html('Vous devez séléctionner un article!');
		$('#errorModal').modal('show');
		return false;
	}
	$.ajax({
		url: "ajax/getRequests.php",
		type: "POST",
		data: {
			setQueryData: true,
			datas: 'colors',
			artID:artID,
			name: name,
			colorHex:addColorHexadecimal,
			qtyStock:qtyStock
		},
		success: function(response) {
			response = JSON.parse(response);
			if(response.success){
				if(isLastColor == 1){
					getAddedColor(artID);
				}
				else{
					window.location.href = 'colors.php?addProductColor=success';
				}
			}
			else if(response.error){
				$('#errorDatas').html(response.error);
				$('#errorModal').modal('show');
			}
		}
	});
	return false;
}

function setEditColor(){
	$('#contentModal').modal('hide');
	$('#loadingModal').modal('show');
	var editColorID = $('#editColorID').val();
	var editColorName = $('#editColorName').val();
	var editColorHex = $('#setEditColorHex').val();
	var IsActiveEditColor = $('#IsActiveEditColor').val();
	$.ajax({
		url: "ajax/getRequests.php",
		type: "POST",
		data: {
			editColor: true,
			editColorID: editColorID,
			editColorName: editColorName,
			editColorHex: editColorHex,
			IsActiveEditColor: IsActiveEditColor
		},
		cache: false,
		success: function(response) {
			if($.trim(response) == 'success'){
				$('#loadingModal').modal('hide');
				window.location.href = 'colors.php?editColor=success';
			}
		},
		error: function() {
			
		}
	});
	return false;
}

function getAddedSize(artID){
	if(artID == ''){
		artID = 0;
	}
	$.get('ajax/getRequests.php?isSize=true&addSize=true&artID='+artID, function(response){
		$('#contentModal').modal('show');
		$('#addContentModal').html(response);
	});
	return false;
}

function setAddedSize(){
	let artID = $('#sizeArtID').val();
	let name = $('#sizeName').val();
	let shortName = $('#sizeShortName').val();
	let qtyStock = $('#qtyStock').val();
	let isLastSize = $("input[name='isLastSize']:checked").val();
	
	if(artID == ''){
		$('#errorDatas').html('Vous devez séléctionner un article!');
		$('#errorModal').modal('show');
		return false;
	}
	$.ajax({
		url: "ajax/getRequests.php",
		type: "POST",
		data: {
			setQueryData: true,
			datas: 'sizes',
			artID: artID,
			name: name,
			shortName:shortName,
			qtyStock:qtyStock
		},
		success: function(response) {
			response = JSON.parse(response);
			if(response.success){
				if(isLastSize == 1){
					getAddedSize(artID);
				}
				else{
					window.location.href = 'sizes.php?addProductSize=success';
				}
			}
			else if(response.error){
				$('#errorDatas').html(response.error);
				$('#errorModal').modal('show');
			}
		}
	});
	return false;
}

function setArticleSize(articleID,articleName){
	$('#sizeArtID').val(articleID);
	$('#searchSizeArtID').val(articleName);
	$('#dropdownSearchSizeArticle').removeClass('show');
}

function setArticleColor(articleID,articleName){
	$('#colorArtID').val(articleID);
	$('#searchColorArtID').val(articleName);
	$('#dropdownSearchColorArticle').removeClass('show');
}

function getAddedColorAndSize(artID){
	$.get('ajax/getRequests.php?isColorAndSize=true&addColorSize=true&artID='+artID, function(response){
		$('#contentModal').modal('show');
		$('#addContentModal').html(response);
	});
	return false;
}

function getEditSize(val){
	$('#loadingModal').modal('show');
	$.get('ajax/getRequests.php?isSize&editSize=true&sizeID='+val, function(response){
		setTimeout(function(){
			if(response){
				$('#loadingModal').modal('hide');
				$('#contentModal').modal('show');
				$('#addContentModal').html(response);
			}
		},1000);
	});
	return false;
}

function setEditSize(){
	$('#contentModal').modal('hide');
	$('#loadingModal').modal('show');
	var editSizeID = $('#editSizeID').val();
	var editSizeName = $('#editSizeName').val();
	var editShortSizeName = $('#editShortSizeName').val();
	var IsActiveEditSize = $('#IsActiveEditSize').val();
	$.ajax({
		url: "ajax/getRequests.php",
		type: "POST",
		data: {
			editSize: true,
			editSizeID: editSizeID,
			editSizeName: editSizeName,
			editShortSizeName: editShortSizeName,
			IsActiveEditSize: IsActiveEditSize
		},
		cache: false,
		success: function(response) {
			if($.trim(response) == 'success'){
				$('#loadingModal').modal('hide');
				window.location.href = 'sizes.php?editSize=success';
			}
		},
		error: function() {
			
		}
	});
	return false;
}

function getDeleteSize(val){
	$('#loadingModal').modal('show');
	$.get('ajax/getRequests.php?isSize&deleteSize=true&sizeID='+val, function(response){
		setTimeout(function(){
			if(response){
				$('#loadingModal').modal('hide');
				$('#contentModal').modal('show');
				$('#addContentModal').html(response);
			}
		},1000);
	});
	return false;
}

function setDeleteSize(sizeID){
	$('#contentModal').modal('hide');
	$('#loadingModal').modal('show');
	$.ajax({
		url: "ajax/getRequests.php",
		type: "POST",
		data: {
			delSize: true,
			deleteSizeID: sizeID
		},
		cache: false,
		success: function(response) {
			if($.trim(response) == 'success'){
				$('#loadingModal').modal('hide');
				window.location.href = 'sizes.php?deleteSize=success';
			}
		},
		error: function() {
			
		}
	});
	return false;
}

/*Shipments*/

function getAddedShipment(){
	$.get('ajax/getShipmentInfos.php?isShipment=true&addShipment=true', function(response){
		$('#contentModal').modal('show');
		$('#addContentModal').html(response);
	});
	return false;
}

function setAddedShipment(){
	$('#contentModal').modal('hide');
	var addShipmentName = $('#addShipmentName').val();
	var addShipmentPrice250 = $('#addShipmentPrice250').val();
	var addShipmentPrice500 = $('#addShipmentPrice500').val();
	var addShipmentPrice1000 = $('#addShipmentPrice1000').val();
	var addShipmentPrice2000 = $('#addShipmentPrice2000').val();
	var addShipmentPrice5000 = $('#addShipmentPrice5000').val();
	var addShipmentPrice10000 = $('#addShipmentPrice10000').val();
	var addShipmentLimitTime = $('#addShipmentLimitTime').val();
	var IsActiveAddShipment = $('#IsActiveAddShipment').val();
	$.ajax({
		url: "ajax/getShipmentInfos.php",
		type: "POST",
		data: {
			addShipment: true,
			addShipmentName: addShipmentName,
			addShipmentPrice250: addShipmentPrice250,
			addShipmentPrice500: addShipmentPrice500,
			addShipmentPrice1000: addShipmentPrice1000,
			addShipmentPrice2000: addShipmentPrice2000,
			addShipmentPrice5000: addShipmentPrice5000,
			addShipmentPrice10000: addShipmentPrice10000,
			addShipmentLimitTime: addShipmentLimitTime,
			IsActiveAddShipment: IsActiveAddShipment
		},
		cache: false,
		success: function(response) {
			if($.trim(response) == 'success'){
				$('#loadingModal').modal('hide');
				window.location.href = 'shipments.php?addShipment=success';
			}
		},
		error: function() {
			
		}
	});
	return false;
}

function getEditShipment(val){
	$('#loadingModal').modal('show');
	$.get('ajax/getShipmentInfos.php?isShipment&editShipment=true&shipmentID='+val, function(response){
		setTimeout(function(){
			if(response){
				$('#loadingModal').modal('hide');
				$('#contentModal').modal('show');
				$('#addContentModal').html(response);
			}
		},1000);
	});
	return false;
}

function setEditShipment(){
	$('#contentModal').modal('hide');
	$('#loadingModal').modal('show');
	var editShipmentID = $('#editShipmentID').val();
	var editShipmentName = $('#editShipmentName').val();
	var editShipmentPrice250 = $('#editShipmentPrice250').val();
	var editShipmentPrice500 = $('#editShipmentPrice500').val();
	var editShipmentPrice1000 = $('#editShipmentPrice1000').val();
	var editShipmentPrice2000 = $('#editShipmentPrice2000').val();
	var editShipmentPrice5000 = $('#editShipmentPrice5000').val();
	var editShipmentPrice10000 = $('#editShipmentPrice10000').val();
	var editShipmentLimitTime = $('#editShipmentLimitTime').val();
	var IsActiveEditShipment = $('#IsActiveEditShipment').val();
	$.ajax({
		url: "ajax/getShipmentInfos.php",
		type: "POST",
		data: {
			editShipment: true,
			editShipmentID: editShipmentID,
			editShipmentName: editShipmentName,
			editShipmentPrice250: editShipmentPrice250,
			editShipmentPrice500: editShipmentPrice500,
			editShipmentPrice1000: editShipmentPrice1000,
			editShipmentPrice2000: editShipmentPrice2000,
			editShipmentPrice5000: editShipmentPrice5000,
			editShipmentPrice10000: editShipmentPrice10000,
			editShipmentLimitTime: editShipmentLimitTime,
			IsActiveEditShipment: IsActiveEditShipment
		},
		cache: false,
		success: function(response) {
			if($.trim(response) == 'success'){
				$('#loadingModal').modal('hide');
				window.location.href = 'shipments.php?editShipment=success';
			}
		},
		error: function() {
			
		}
	});
	return false;
}

function getDeleteShipment(val){
	$('#loadingModal').modal('show');
	$.get('ajax/getShipmentInfos.php?isShipment&deleteShipment=true&shipmentID='+val, function(response){
		setTimeout(function(){
			if(response){
				$('#loadingModal').modal('hide');
				$('#contentModal').modal('show');
				$('#addContentModal').html(response);
			}
		},1000);
	});
	return false;
}

function setDeleteShipment(shipmentID){
	$('#contentModal').modal('hide');
	$('#loadingModal').modal('show');
	$.ajax({
		url: "ajax/getShipmentInfos.php",
		type: "POST",
		data: {
			delShipment: true,
			deleteShipmentID: shipmentID
		},
		cache: false,
		success: function(response) {
			if($.trim(response) == 'success'){
				$('#loadingModal').modal('hide');
				window.location.href = 'shipments.php?deleteShipment=success';
			}
		},
		error: function() {
			
		}
	});
	return false;
}

/*carrousels*/

function setCarrouselImg(){
	$('#setCarrouselImageUpload').hide();
	var img_file = new FormData();
	var files = $('#setCarrouselImage')[0].files;
	
	if(files.length > 0 ){
	   img_file.append('setCarrouselImage',files[0]);
		if($('#setCarrouselImageRenamed').val() != ""){
			
		}
		$.ajax({
			url: 'upload_carrousel.php',
			type: 'post',
			data: img_file,
			contentType: false,
			processData: false,
			success: function(response){
				if(response != 0 || response != 1 || response != 2){
					$('#setCarrouselImageRenamed').val('assets/img/carrousels/'+response);
					$('#setCarrouselImagePreview').show();
					$('#setCarrouselImagePreview').html('<img class="img-fluid" src="../assets/img/carrousels/'+response+'" width="200px"/>');
					$('#btn-del-carrousel-image').show();
				}
				else{
					if(response == 0)
						response = 'Erreur code 0';
					else if(response == 1)
						response = 'Erreur code 1';
					else if(response == 2)
						response = 'Erreur code 2';
					else 
						response = 'Quelque chose!';
					$('#setCarrouselImageUpload').show();
					$('#setResultImgCarrousel').show();
					$('#setResultImgCarrousel').html(response);
				}
			},
		});
	}
	else{
		$('#setResultImgCarrousel').show();
		$('#setResultImgCarrousel').html('Une erreur c\'est produite.');
	}
}

function setCarrouselImgDelete(){
	var name = $('#setCarrouselImageRenamed').val();
	$.get('ajax/getRequests.php?setImageDelete=true&ImageName='+name, function(response) {
		if(response == 0){
			alert('Une erreur c\'est produite.');
		}
		else{
			$('#setCarrouselImage').val('');
			$('#setCarrouselImageRenamed').val('');
			$('#setCarrouselImagePreview').html('');
			$('#btn-del-carrousel-image').hide();
			$('#setCarrouselImageUpload').show();
		}
	});
	return false;
}

function setCarrouselStatus(id, status){
	$('#loadingModal').modal('show');
	$.ajax({
		url: "ajax/getCarrousels.php",
		type: "POST",
		data: {
			setCarrouselActive: true,
			carrouselID: id,
			carrousselIsActive: status
		},
		cache: false,
		success: function(response) {
			if($.trim(response) == 'success'){
				$('#loadingModal').modal('hide');
				window.location.href = 'carrousels.php?isActive=success';
			}
		},
		error: function() {
			
		}
	});
	return false;
}

function setCarrouselDelete(id){
	$('#loadingModal').modal('show');
	$.ajax({
		url: "ajax/getCarrousels.php",
		type: "POST",
		data: {
			setCarrouselDelete: true,
			carrouselID: id
		},
		cache: false,
		success: function(response) {
			if($.trim(response) == 'success'){
				$('#loadingModal').modal('hide');
				window.location.href = 'carrousels.php?isDelete=success';
			}
		},
		error: function() {
			
		}
	});
	return false;
}
	
/**********/

function getArticlePages(page){
	var p = 0;
	if(page != '' || page != 0){
		p = page;
	}
	$.ajax({
		url: 'ajax/getArticleRequests.php',
		type: 'get',
		data: {
			getArticles:true,
			getArticlePage:p
		},
		success: function(response){
			$('#setAllArticles').html(response);
		},
		error: function(response){
		},
	});
	return false;
}

function getArticleDelete(val){
	$.get('ajax/getArticleRequests.php?isDeleteArticle=true&articleID='+val, function(response){
		if(response){
			$('#contentModal').modal('show');
			$('#addContentModal').html(response);
		}
	});
	return false;
}
	
function setArticleDelete(id){
	$.ajax({
		url: "ajax/getArticleRequests.php",
		type: "POST",
		data: {
			setArticleDelete: true,
			articleID: id
		},
		cache: false,
		success: function(response) {
			response = JSON.parse(response);
			if(response.success == 1){
				window.location.href = 'articles.php?isDelete=success';
			}
			else if(response.error){
				$('#errorDatas').html(response.error);
				$('#errorModal').modal('show');
			}
		}
	});
	return false;
}
function setArticleLastChance(id, status){
	$.ajax({
		url: "ajax/getArticleRequests.php",
		type: "POST",
		data: {
			setArticleLastChance: true,
			articleStatus:status,
			articleID: id
		},
		success: function(response) {
			response = JSON.parse(response);
			if(response.success == 1){
				window.location.href = 'articles.php?isUpdate=success';
			}
			else if(response.error){
				$('#errorDatas').html(response.error);
				$('#errorModal').modal('show');
			}
		}
	});
	return false;
}

function setArticleIsActive(id, status){
	$.ajax({
		url: "ajax/getArticleRequests.php",
		type: "POST",
		data: {
			setArticleIsActive: true,
			articleStatus:status,
			articleID: id
		},
		success: function(response) {
			response = JSON.parse(response);
			if(response.success == 1){
				window.location.href = 'articles.php?isUpdate=success';
			}
			else if(response.error){
				$('#errorDatas').html(response.error);
				$('#errorModal').modal('show');
			}
		}
	});
	return false;
}

/*Payments methods*/

function getAddedPayment(){
	$.get('ajax/getPaymentInfos.php?isPaymentMethod=true&addPaymentMethod=true', function(response){
		$('#contentModal').modal('show');
		$('#addContentModal').html(response);
	});
	return false;
}

function setAddedPayment(){
	$('#contentModal').modal('hide');
	var addPaymentName = $('#addPaymentName').val();
	var addPaymentOrderDelais = $('#addPaymentOrderDelais').val();
	var IsActiveAddPayment = $('#IsActiveAddPayment').val();
	$.ajax({
		url: "ajax/getPaymentInfos.php",
		type: "POST",
		data: {
			addPayment: true,
			addPaymentName: addPaymentName,
			addPaymentOrderDelais: addPaymentOrderDelais,
			IsActiveAddPayment: IsActiveAddPayment
		},
		cache: false,
		success: function(response) {
			if($.trim(response) == 'success'){
				$('#loadingModal').modal('hide');
				window.location.href = 'payment-methods.php?addPayment=success';
			}
		}
	});
	return false;
}

function getEditPayment(val){
	$('#loadingModal').modal('show');
	$.get('ajax/getPaymentInfos.php?isPayment&editPayment=true&paymentID='+val, function(response){
		setTimeout(function(){
			if(response){
				$('#loadingModal').modal('hide');
				$('#contentModal').modal('show');
				$('#addContentModal').html(response);
			}
		},1000);
	});
	return false;
}

function setEditPayment(){
	$('#contentModal').modal('hide');
	$('#loadingModal').modal('show');
	var editPaymentID = $('#editPaymentID').val();
	var editPaymentName = $('#editPaymentName').val();
	var editPaymentOrderDelais = $('#editPaymentOrderDelais').val();
	var IsActiveEditPayment = $('#IsActiveEditPayment').val();
	$.ajax({
		url: "ajax/getPaymentInfos.php",
		type: "POST",
		data: {
			editPayment: true,
			editPaymentID: editPaymentID,
			editPaymentName: editPaymentName,
			editPaymentOrderDelais: editPaymentOrderDelais,
			IsActiveEditPayment: IsActiveEditPayment
		},
		cache: false,
		success: function(response) {
			if($.trim(response) == 'success'){
				$('#loadingModal').modal('hide');
				window.location.href = 'payment-methods.php?editPayment=success';
			}
		}
	});
	return false;
}

function getDeletePayment(val){
	$('#loadingModal').modal('show');
	$.get('ajax/getPaymentInfos.php?isPayment&deletePayment=true&paymentID='+val, function(response){
		setTimeout(function(){
			if(response){
				$('#loadingModal').modal('hide');
				$('#contentModal').modal('show');
				$('#addContentModal').html(response);
			}
		},1000);
	});
	return false;
}

function setDeletePayment(paymentID){
	$('#contentModal').modal('hide');
	$('#loadingModal').modal('show');
	$.ajax({
		url: "ajax/getPaymentInfos.php",
		type: "POST",
		data: {
			delPayment: true,
			deletePaymentID: paymentID
		},
		cache: false,
		success: function(response) {
			if($.trim(response) == 'success'){
				$('#loadingModal').modal('hide');
				window.location.href = 'payment-methods.php?deletePayment=success';
			}
		}
	});
	return false;
}

function setPaymentIsActive(id, status){
	$('#loadingModal').modal('show');
	$.ajax({
		url: "ajax/getPaymentInfos.php",
		type: "POST",
		data: {
			setPaymentIsActive: true,
			paymentStatus:status,
			paymentID: id
		},
		success: function(response) {
			$('#loadingModal').modal('hide');
			window.location.href = 'payment-methods.php?isUpdate=success';
		}
	});
	return false;
}


function getDeleteGiftCertificate(val){
	$('#loadingModal').modal('show');
	$.get('ajax/getRequests.php?isGiftCertificate=true&deleteGiftCertificate=true&giftCertificateID='+val, function(response){
		setTimeout(function(){
			if(response){
				$('#loadingModal').modal('hide');
				$('#contentModal').modal('show');
				$('#addContentModal').html(response);
			}
		},1000);
	});
	return false;
}

function setDeleteGiftCertificate(giftCertificateID){
	$('#contentModal').modal('hide');
	$('#loadingModal').modal('show');
	$.ajax({
		url: "ajax/getRequests.php",
		type: "POST",
		data: {
			setDelGiftCertificate: true,
			giftCertificateID: giftCertificateID
		},
		cache: false,
		success: function(response) {
			if($.trim(response) == 'success'){
				$('#loadingModal').modal('hide');
				window.location.href = 'gift_certificates.php?deleteGift=success';
			}
		}
	});
	return false;
}

function setGiftCertificateStatus(id, status){
	$('#loadingModal').modal('show');
	$.ajax({
		url: "ajax/getRequests.php",
		type: "POST",
		data: {
			setGiftCertificateStatus: true,
			giftCertificateStatus:status,
			giftCertificateID: id
		},
		success: function(response) {
			$('#loadingModal').modal('hide');
			window.location.href = 'gift_certificates.php?updateGift=success';
		}
	});
	return false;
}
