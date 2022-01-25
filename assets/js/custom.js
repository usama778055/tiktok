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
function myFunction() {
  document.getElementById("myPopup").classList.toggle("cartshow");
}

// Close the dropdown if the user clicks outside of it
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

// Gallery 



// Blog
$(function () {
  "use strict";
  $('.blog-article').slice(0, 3).show();
  $('#loadmoreBlog').on('click', function (e) {
    e.preventDefault();
    $('.blog-article:hidden').slice(0, 2).slideDown();
    if ($('.blog-article:hidden').length === 0) {
        $('#loadmoreBlog').replaceWith("<a id='nomore-blog' class='serv-btn' href=''><span class='spanbtn'>No More</span></a>");
    }
});
});

// Counter
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
                //"bread_name": "australian"
            },
            success : function(response){
                var result= $.parseJSON(response); 
                var url = window.location.origin;
                var html = `<small><a href="#">Home</a>/<a class="active" href="#">Tiktok ${result.serviceType}</a></small>
                <h3>Buy ${result.packageQty} ${result.packageTitle}</h3>
                <strong>${result.priceUnit} ${result.packagePrice}</strong>
                <p>${result.package_description}</p>
                <ul class="uk-list">
                <li>High Quality</li>
                <li>Active and Real Users </li>
                <li>Instant Delivery</li>
                <li>24/7 Support</li>
                </ul>
                <div class="purchase-btn">
                <a class="serv-btn" href='${result.url}'><span class="spanbtn">Purchase</span></a>
                </div>`;
                $('.pakage-details').html(html);
                
                

            }
        });
});



function from_get_api() {
    $(this).keypress(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
        }
    });
    var get_value = $('.user_name').val();
    if(get_value === ''){
        console.log('usama');
        UIkit.notification({message: 'Field empty', pos: 'top-right',status:'danger'});
        return false;
    }
    $.ajax({
        method:"post",
        url : base_url+"get_tiktokuser_data",
        data : { "name": get_value },
        success : function(response){

            var result= $.parseJSON(response);
            var images = result.post_links;
            var html = '';
            $.each(images , function( index, value ) {
                html += "<div>"+
                "<div class='gallery-image uk-transition-toggle' tabindex='0'>"+
                "<img class='uk-transition-scale-up uk-transition-opaque selected_div' src='"+value+"'>"+
                "<div class='uk-position-bottom uk-overlay-default get_select' style='display: none;' data_id='get_select'>"+
                "<p class='uk-h4 uk-margin-remove'>200</p>"+
                "</div>"+
                "</div>"+
                "</div>"; 
                $('.custom_image_class').prepend(html);
                
            });
            $('.gallery-image').slice(0, 10).show();
                $('#loadmore').on('click', function (e) {
                    e.preventDefault();
                    $('.gallery-image:hidden').slice(0, 4).slideDown();
                    if ($('.gallery-image:hidden').length === 0) {
                        $('#loadmore').replaceWith("<a id='nomore-image' class='serv-btn' href=''><span class='spanbtn'>No More</span></a>");
                    }
                });


        }
    });
}

$(".selected_div").on('click' ,function () {
    console.log('usama');
    /*return false;
    if($(this).hasClass("selected"))
    {
        $(this).removeClass("selected");
        $(this).find('.get_select').hide();
        return false;
    }
    else{
    $('.selected_div').addClass("selected");
    $(this).find('.get_select').show();
    return false;
    }*/

    
});


function myFunction() {
  var load = $('.js-example-basic-single').val();
  window.location.href = load;
  console.log(x);
}



