// Header
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
$.ajax({
    method:"post",
    url : base_url+"get_tiktokuser_data",
    data : { "name": get_value },
    beforeSend: function() {
        $(".loader_class").show();
        $("#form-stacked-text"). attr('disabled','disabled');   
    },
    success : function(response){
        $(".loader_class").hide();
        $("#form-stacked-text"). removeAttr('disabled');
        $('.custom_image_class').html(response);
        if ($('.gallery-image:hidden').length !== 0) {
            $('#loadmore').show();
        }

        $('.gallery-image').slice(0, 4).show();
        $('#loadmore').on('click', function (e) {
            e.preventDefault();
            $('.gallery-image:hidden').slice(0, 1).slideDown();
            if ($('.gallery-image:hidden').length === 0) {
                $('#loadmore').hide();
            }
        });
    },
});
});



$(document).on('click', ".selected_div", function () {
    $(this).toggleClass("selected");
    var length = $('.selected_div.selected').length;
    var limit = 50;
    var packageQty = $('.js-example-basic-single').find(':selected').attr('data_id');
    const quantity = packageQty / 1;
    const service_limit = limit / 1;
    let per_input = Math.floor(quantity / length);
    const remaining = quantity % length;

    if (length > 1 && per_input < 50){
        console.log(per_input);
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
        } else {
            $(post).find(".putquentity").text("");
        }
    });
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
            $('.blog-article:hidden').slice(0, 2).slideDown(500);
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






