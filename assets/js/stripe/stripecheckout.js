$(document).ready(function () {
    $('#payButton').on('click', function () {
        return buyClick(this);
    });
});

function buyClick(elem) {
    console.log('stripeSubmit');
    let checkout = new StripeCheckout();
    var valid = checkout.checkIfAnyError();
    console.log({ valid });

    if (valid.success == 0) {
        console.log(valid.error);
        alertError(valid.error);
        return false;
    }

    elem.textContent = 'Please wait...';
    elem.disabled = true;

    console.log('No error!');

    // post details for like
    var html = checkout.sendAjax();
    console.log(html);

    return false;
}


class StripeCheckout {
    constructor() {
        this.stripekey = Stripe($('#stripe_public_key').val());
        // this.buyBtn = document.getElementById('payButton'); 
        // this.buyClick(event);  
        // $('.com_area').keypress(); 
        // $('#payButton').click(function(event){
        //     this.buyClick(event);
        // });
    }

    sendAjax() {
        var data = this.preparePostObj();
        data.user_email = $('#user_email').val();

        console.log({ data });
        var res = {};
        $.ajax({
            url: base_url + 'setProductSetting/',
            method: 'post',
            data: data,
            dataType: 'post',
            success: function (response) {
                console.log(response);
                res = response;
            }
        });
        var parent = this;
        this.createCheckoutSession().then(function (data) {
            if (data.sessionId) {
                var stripe = parent.stripekey;
                stripe.redirectToCheckout({
                    sessionId: data.sessionId,
                }).then(parent.handleResult);
            } else {
                parent.handleResult(data);
            }
        });
    }

    // Username and email address validation.
    checkIfAnyError() {
        var email = $('#user_email').val();
        var username = $('#ig_username').val();
        var result = { success: 1 };
        if (email == '' || username == '') {
            result = { success: 0, error: 'Error: Please enter username and your email address.' };
        } else if ($('.get_grid[data-found="1"]').length < 1) {
            result = { success: 0, error: 'Error: Please enter valid username to find your account on instagram.' };
        } else if (result.success == 1) {
            result = this.checkError();
        }
        return result;
    }

    // Select post validation.
    checkError() {
        var selectedElem = $('.post_selected');
        var result = { success: 1 };
        var message = ''; var postCats = postOrderCats();
        if ((($.inArray(sType, postCats) != -1)) && selectedElem.length === 0) {
            result = { success: 0, error: 'Error: Please select atleast one post.' };
        } else if (sType == 'comments') {
            result = this.emtpyCommentsError();
        }

        return result;
    }

    emtpyCommentsError() {
        var left = 0; var result = { success: 1 };
        $('.com_area').each(function (key, val) {
            var comElen = $(val);
            var lines = comElen.val().split("\n").filter(Boolean).length;
            var limit = comElen.attr('com-limit');

            if (lines < limit) {
                left += limit - lines;
            }
        });
        if (left > 0) {
            result = { success: 0, error: 'Error: There are ' + left + ' comments left to add.' };
        }
        return result;
    }

    createCheckoutSession(stripe) {
        return fetch(base_url + "sessionstripe/", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                checkoutSession: 1,
            }),
        }).then(function (result) {
            return result.json();
        });
    }

    handleResult(result) {
        if (result.error) {
            alertError(result.error.message);
            return false;
        }
        buyBtn.disabled = false;
        buyBtn.textContent = 'Buy Now';
    }

    likesForm() {
        var html = '';
        var jsonObj = {};
        var likeformArray = [];
        var selectedElem = $('.post_selected');
        var slctdElemId, likes, imageSrc, postId;

        if (Object.keys(selectedElem).length) {
            $.each(selectedElem, function (key, valu) {
                slctdElemId = $(valu).attr('id');
                likes = parseInt($('.lkBtn' + slctdElemId).html());
                postId = $('.lkBtn' + slctdElemId).data('id');
                imageSrc = $('.lkBtn' + slctdElemId).data('src');
                jsonObj[postId] = {
                    "post_id": postId,
                    "post_like": likes,
                    "post_src": imageSrc
                };
            });
        }
        return jsonObj;
    }

    orderPosts() {
        var postObj = {};
        jQuery('.selected_sec').each(function (index, elem) {
            var post_id = $(elem).find('.selected_img').attr('data-id');
            var quantity = parseInt($(elem).find('.selected_qty').text().trim());
            var comObj = { 'post_id': post_id, 'post_like': quantity, 'post_src': '' };
            postObj[post_id] = comObj;
        });
        return { selected_posts: postObj };
    }

    orderComments() {
        var commentsArray = {};
        jQuery('.com_area').each(function (index, elem) {
            var id = $(elem).data('id');
            var comments = $(elem).val();
            var comObj = { 'post_id': id, 'comments': comments };
            commentsArray[id] = comObj;
        });

        return { com: commentsArray };
    }

    preparePostObj() {
        var data = {}; var postCats = postOrderCats();
        if ((($.inArray(sType, postCats) != -1))) {
            if (sType == "comments") {
                data = this.orderComments();
            } else {
                data = this.orderPosts();
            }
        }
        return data;
    }


    buyClick(event) {
        // console.log('buyClick');
        this.buyBtn.addEventListener("click", this.stripeSubmit, false);
        event.preventDefault();
    }

    setProductSetting(dataObj) {
        $.ajax({
            url: base_url + 'setProductSetting/',
            method: 'post',
            data: dataObj,
            dataType: 'post',
            success: function (response) {
                console.log(response);
                return false;
            }
        });
    }

    stripeSubmit(evt) {
        console.log('stripeSubmit');
        let checkout = new StripeCheckout();
        this.checkIfAnyError();
        this.textContent = 'Please wait...';
        this.disabled = true;

        var valid = checkError();
        if (valid.success == 0) {
            alertError(valid.error);
            return false;
        }
        // post details for like
        var html = this.likesForm();
        console.log(html);
    }
}
