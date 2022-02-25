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
                    $(".user-img h5").text(data.data.user.full_name);
                    $(".user-img p").text('@'+data.data.user.user_name);
					$("#profile_image_tiktok").attr("src", data.data.user.profile_image);
					$(".load-gallery.custom_image_class").attr("data-found", 1);
					if (auto_services.includes(sType)) {
                        $(".load-gallery.custom_image_class").html(data.html);
                        displayTiktokProfile(data.data);
						// $('.gallery-image').show();
						return false;
					} else {
						$(".load-gallery.custom_image_class").html(data.html);
                        displayTiktokProfile(data.data);
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

//comments

$(document).on('click', ".selected_div", function () {
    $(this).toggleClass("selected");
    var length = $('.selected_div.selected').length;
    var commenttype =  $('.service_type').attr('id');
    var imagesrc =  $(this).children('img').attr('src');
    var post_id =  $(this).find(".post_id").val();
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

    if (length > 1 && per_input < service_limit){
        $(this).removeClass("selected");
        $(this).find(".putquentity").text('');
        return false;
    }
    
    if (sType == "comments" && $(".add_comment").length > 0) {
        handleCommentsHtml(length, per_input,remaining);
    }    
    if (quantity > 0) {
    $(".selected_div").each((index, post) => {

        if ($(post).hasClass("selected")) {
            if (index === length - 1) {
                per_input += remaining;
            }
            $(post).find(".putquentity").text(per_input);
            $(post).find(".per_quantity").val(per_input);

        } else {
            $(post).find(".putquentity").text("");
            $(post).find(".per_quantity").val(0);
        }

    });
    }
});


function handleCommentsHtml(length, per_input,remaining=0) {
        $(".add_comment").empty();
        $(".selected_div").each((index, post) => {
            if (index === length - 1) {
                per_input += remaining;
            }
            if ($(post).hasClass("selected")) {
                var html = commentsHtml(post, per_input, remaining);
                if (html != "") {
                    $(".add_comment").show();
                    $(".add_comment").append(html);
                }
            }
            else{
               $(".add_comment").append(html); 
            }
        });
        $(".com_area").ready(function () {
            commentCount();
        });
    }

    function commentsHtml(post, qty,remaining) {
        var postId = $(post).find(".post_id").val();
        var bg_img = $(post).find("img").attr('src');
        var html = "";
        html +=
            '<div class="comments_sec">' +
            '<div class="post_area cmntcol">' +
            '<div data-id="' +
            postId +
            '" style="background-image: url(' +
            bg_img +
            ')" class="selected_img"></div>' +
            "</div>" +
            '<div class="comments_field">' +
            '<div class="wrap_rem_counts uk-grid"><div class="comments_field-hdr uk-panel"><span>' +
            qty +
            "</span> Comments (1 per line)</div>" +
            '<div class="comments_field-ftr uk-panel">Quantity: <span class="count_' +
            postId +
            '">0</span> / <span class="total_com">' +
            qty +
            "</span></div></div>" +
            '<textarea placeholder="Write your comments here..." rows="' +
            qty +
            '" cols="50" spellcheck="true" class="uk-textarea com_area com_' +
            postId +
            '" data-id="' +
            postId +
            '" com-limit="' +
            qty +
            '"></textarea>' +
            "</div>" +
            "</div>";
        return html;
    }
    // Count comments (1 per line) on comments textarea
    function commentCount() {
        $(".com_area").keypress(function (event) {
            var comElen = $(this);
            var lines = comElen.val().split("\n");
            var limit = comElen.attr("com-limit");
            if (lines.length >= limit) {
                if (event.which == "13") {
                    event.preventDefault();
                    toaster.error(
                        "You can select minimum " + limit + " " + sType + " per post."
                        );
                }
            }
        });

        $(".com_area").keyup(function (event) {
            var comElen = $(this);
            var lines = comElen.val().split("\n");
            var postId = comElen.attr("data-id");
            $(".count_" + postId).text(lines.length);
        });
    }

    //end comments section

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

// Custom Toaster integrated with UKkit's Notification
function notification(alert_class, msg) {
    UIkit.notification({
        message: msg,
        status: alert_class,
        pos: "top-right",
        timeout: 3000,
    });
}

function primary(message) {
    notification("primary", message);
}
function success(message) {
    notification("success", message);
}
function error(message) {
    notification("danger", message);
}
function warning(message) {
    notification("warning", message);
}
const toaster = {
    primary: primary,
    success: success,
    error: error,
    warning: warning,
};

const transformQuantity = (quantity) => {
    if (quantity >= 1000000000) {
        return `${(quantity / 1000000000).toFixed(2)}b`; //one billion
    } else if (quantity >= 1000000) {
        return `${(quantity / 1000000).toFixed(2)}m`; // one million
    } else if (quantity >= 10000) {
        return `${(quantity / 1000).toFixed(2)}k`; // one k
    } else {
        return quantity;
    }
};


$( "#contact" ).click(function(event) {
  event.preventDefault();
  $.ajax({
   url:base_url+"contact",
   method:"POST",
   data:$('#contact_form').serialize(),
   dataType:"json",
   beforeSend:function(){
    $('#contact').attr('disabled', 'disabled');
   },
   success:function(data)
   {
    if(data.error)
    {
     if(data.name_error != '')
     {
      $('#name_error').html(data.name_error);
     }
     else
     {
      $('#name_error').html('');
     }
     if(data.email_error != '')
     {
      $('#email_error').html(data.email_error);
     }
     else
     {
      $('#email_error').html('');
     }
     if(data.subject_error != '')
     {
      $('#subject_error').html(data.subject_error);
     }
     else
     {
      $('#subject_error').html('');
     }
     if(data.message_error != '')
     {
      $('#message_error').html(data.message_error);
     }
     else
     {
      $('#message_error').html('');
     }
    }
    if(data.success)
    {
     $('#success_message').html(data.success);
     UIkit.notification('Thank you for Contact Us', {status:'success',pos: 'top-right'})
     $('.all_error p').html('');
     $('#contact_form')[0].reset();
    }
    $('#contact').attr('disabled', false);
   }
  })
 });



