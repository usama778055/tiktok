// Header
const auto_services = [
	"followers",
	"autolikes",
	"autoviews",
	"livestream",
];
$(function() {
    $(window).on("scroll", function() {
        if($(window).scrollTop() > 50) {
            $("header").addClass("header-active");
        } else {
            //remove the background property so it comes transparent again (defined in your css)
            $("header").removeClass("header-active");
        }
    });
});

// Cart-Popup
function cardfunction() {
  document.getElementById("myPopup").classList.toggle("cartshow");
}

window.onclick = function(event) {
  if (!event.target.matches('.popupbtn')) {
    var dropdowns = document.getElementsByClassName("popupbtn-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('cartshow')) {
        openDropdown.classList.remove('cartshow');
    }
}
}
}

$('.custom-count').each(function () {
    $(this).prop('Counter',0).animate({
        Counter: $(this).text()
    }, {
        duration: 4000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
});

$('.package_button').bind("click",function () {
    $('.package_button.selected').removeClass('selected');

    $(this).addClass('selected');
    var id = $(this).attr('data_id');

    $.ajax({
        method:"post",
        url : base_url+"package_data",
        data : {
            "id": id,
        },
        success : function(response){

            $('.pakage-details').html(response);
        }
    });
});

jQuery(document).on("keypress", 'input', function (e) {
    var code = e.keyCode || e.which;
    if (code === 13) {
        e.preventDefault();
        return false;
    }
});

$( "#form-stacked-text" ).change(function() {


 var getclass = $('.js-example-basic-single').find(':selected').attr('data_id');


 var get_value = $('.user_name').val();
 var find = $(this).find('.user_name');
 if(get_value === ''){

    UIkit.notification({message: 'Field empty', pos: 'top-right',status:'danger'});
    return false;
}
	sendAjax(".user_name#form-stacked-text", get_value);
});

function sendAjax(selector, username) {

	jQuery.ajax({
		url: `${base_url}find`,
		method: "POST",
		dataType: "json",
		data: {
			action: "get_tiktok_user",
			user_name: username,
			// user_email: email,
		},
		beforeSend: function() {
            $(".load-gallery.custom_image_class").html("");
			$(".loader_class").show();
			$("#form-stacked-text"). attr('disabled','disabled');

		},
		success: function (data, status){
			$(".loader_class").hide();
			$("#form-stacked-text").removeAttr('disabled');

			$(".load-gallery.custom_image_class").removeClass("shown");
			$(selector).attr("disabled", false);
			if (status === "success") {
				if (data.success === true || data.success === 1) {
					toaster.success("Tiktok Data Loaded Succesfully!");
					$(".load-gallery.custom_image_class").attr("data-found", 1);
					if (auto_services.includes(sType)) {
						displayTiktokProfile(data.data);
						$('.gallery-image').show();
						return false;
					} else {
						$(".load-gallery.custom_image_class").html(data.html);
						$('.gallery-image').show();
						//fetchThumbnails(data.data);
						return false;
					}
				} else {
					$(".load-gallery.custom_image_class").attr("data-found", 0);
					toaster.error(data.message);
				}
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			$(".load-gallery.custom_image_class").removeClass("shown");
			$(selector).attr("disabled", false);
			toaster.error(errorThrown);
		},
	});
}

$(document).on('click', ".selected_div", function () {
    $(this).toggleClass("selected");
    var length = $('.selected_div.selected').length;
    var commenttype =  $('.service_type').attr('id');
    var imagesrc =  $(this).children('img').attr('src');
    var data_id =  $(this).find('p.putquentity').attr('data_id');
    console.log(data_id);
    $select = $(this).attr("class");
    if (commenttype == 'comments') {
        var limit = 5;
    }
    else{
        var limit = 50;
    }

    var packageQty = $('.js-example-basic-single').find(':selected').attr('data_id');
    const quantity = packageQty / 1;
    const service_limit = limit / 1;
    let per_input = Math.floor(quantity / length);
    const remaining = quantity % length;

    if (length > 1 && per_input < limit){
        $(this).removeClass("selected");
        $(this).find(".putquentity").text('');
        return false;
    }
    $(".selected_div").each((index, post) => {

        if ($(post).hasClass("selected")) {
            if (index === length - 1) {
                per_input += remaining;
            }
            $(post).find(".putquentity").text(per_input);
            $(post).find(".per_quantity").val(per_input);

        } else {
            $(post).find(".putquentity").text("");
            $(post).find(".per_quantity").val('');
        }

    });
    if ($(this).hasClass("selected")) {
        if(commenttype == 'comments'){
            var quenty = $('#quenty_'+data_id).text();
            $.ajax({
                method:"post",
                url : base_url+"comments",
                data : {image : imagesrc,
                        length : data_id
                    },
                success : function(response){
                    $('#add_comment').append(response);
                    $(".comments_sec").each((index, post) => {
                    $(post).find(".total_com").text(quenty);
                    $(post).find(".comment_length").text(quenty);

                });
            }
        });
            
        }
    }
    else{
        $('#add_comment').children('#wrap_selected_items'+data_id).remove();
    }
});


function myFunction() {
  var load = $('.js-example-basic-single').val();
  window.location.href = load;
}

$(function () {
   $('.blog-article').show();
});

$(document).on('click', "#loadmoreBlog", function (e) {
    e.preventDefault();
    $slug = $(this).attr("data_id");
    $.ajax({
        method:"post",
        url : base_url+"moreBlogs",
        data : {'slug': $slug },
        success : function(response){
            $("#loadmoreBlog").remove();
            $(".vertical-blog-sec .uk-container").append(response);             
            $('.blog-article:hidden').slice(0, 3).slideDown('slow');
        }
    });

});



$(document).on('click', "#email_button", function () {

    var hasError = false;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var email = $('.apply_cop_email').val();
    if(email == '') {
        $(".error").show();
        $(".error").html("<small class='' style='color:red;'>Please enter your email address.</small>");
        hasError = true;
    }
    else if(!emailReg.test(email)) {
        $(".error").show();
        $(".error").html('<small class="" style="color:red;">Enter a correct email address.</small>');
        hasError = true;
    }
    if(hasError == true) { return false; }
    $.ajax({
        method:"post",
        url : base_url+"apply_copon",
        data : {
            "email": email,
        },
        success : function(response){
            if(response == 'false'){
                $(".error").show();
                $(".error").html("<small class='' style='color:red;'>Email already store in database</small>");
                return false;
            }
            else{
                $('.apply_cop_email').val('');
                $(".error").show();
                $(".error").html("<small class='' style='color:red;'>Success Data</small>");
            }
        }
    });
});



$(document).on('click', ".submit_apply_cop", function () {

    $(".erroremail").hide();
    var hasError = false;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var email = $('.email_submit').val();
    if(email == '') {
        $(".erroremail").show();
        $(".erroremail").html("<small class='' style='color:red;'>Please enter your email address.</small>");
        hasError = true;
    }
    else if(!emailReg.test(email)) {
        $(".erroremail").show();
        $(".erroremail").html('<small class="" style="color:red;">Enter a correct email address.</small>');
        hasError = true;
    }
    if(hasError == true) { return false; }
    $.ajax({
        method:"post",
        url : base_url+"subcribe_for_news",
        data : {
            "email": email,
        },
        success : function(response){
            if(response == 'false'){
                $(".erroremail").show();
                $(".erroremail").html("<small class='' style='color:red;'>Email already store in database</small>");
                return false;
            }
            else{
                $('.email_submit').val('');
                $(".erroremail").show();
                $(".erroremail").html("<small class='' style='color:red;'>Success Data</small>");
            }
        }
    });
});

$(document).on('click', "#promo_div", function () {
    $(".promo_input_div").slideToggle();
    
});

$(document).on('click', "#cart-remove-id", function () {
    $(".tr_container").remove();
    
});






