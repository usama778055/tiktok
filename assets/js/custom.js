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
        $(this).prop('disabled', true);
    },
    success : function(response){
        $(".loader_class").hide();
        $(this).prop('disabled', false);
        
        var result= $.parseJSON(response);
        var images = result.post_links;
        var len = images.length;
        var html = '';
        var count = 1;
            /*const quantity = packageQty / 1;
            const service_limit = limit / 1;*/
            $.each(images,function(index, post){
                console.log(post);
                
                html += `<div data_id=''>
                <div class='gallery-image uk-transition-toggle selected_div' tabindex='0'>
                <img class='uk-transition-scale-up uk-transition-opaque' src='${post}'>
                <div class='uk-position-bottom uk-overlay-default get_select' style=''>
                <p class='uk-h4 uk-margin-remove putquentity'></p>
                </div>
                </div>
                </div>`; 
                
                /*if(i === 0){
                console.log(issue);
                }
                else{
                issue = -getclass / 2 + issue;
                console.log(issue);
                
                
            }*/

        });
            $('.custom_image_class').html(html);
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
                else{
                    
                }
                
            });


        }   
    });
});



$(document).on('click', ".selected_div", function () {
    $(this).toggleClass("selected");
    /*if ($(this).hasClass("selected")) {
      $(this).removeClass("selected");  
  }*/
  /*   $(this).find('.get_select').show();*/
  var length = $('.selected_div.selected').length;
  console.log(length);
  var limit = 50;
  var packageQty = $('.js-example-basic-single').find(':selected').attr('data_id');
  const quantity = packageQty / 1;
  const service_limit = limit / 1;
  let per_input = Math.floor(quantity / length);

  const remaining = quantity % length;
  if (length > 1 && per_input < 50){
    /*$(this).addClass("shake animated");*/
    console.log(per_input);
    $(this).removeClass("selected");
    $(this).find(".putquentity").text('');

    console.log('error');

            /*setTimeout(() => {
                $(this).removeClass("shake animated");
            }, 600);*/
            return false;
        }

        $(".selected_div").each((index, post) => {

            if ($(post).hasClass("selected")) {
                if (index === length - 1) {
                    per_input += remaining;
                }
                $(post).find(".putquentity").text(per_input);
                /*$(post).find(".per_quantity").val(per_input);*/
            } else {
                $(post).find(".putquentity").text("");
                /*$(post).find(".per_quantity").val(0);*/
            }
        });


        /*console.log(select);*/


    });


function myFunction() {
  var load = $('.js-example-basic-single').val();
  window.location.href = load;
}

/*$(document).on('click', ".aboutus", function () {
  $.ajax({
        method:"post",
        url : base_url+"about-us",
        data : {
            },
            success : function(response){
                
               window.location.href = '';
               window.scrollTo(0,document.body.scrollHeight); 
                

            }
        });
    });*/



