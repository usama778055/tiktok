$(document).ready(function (e) {
	if ($("#add-to-cart").length > 0) {
		// Handle add to cart
		$("#add-to-cart").on("click", function (event) {
			event.preventDefault();

			handleAddToCart();
		});

		$("#pay_now").on("click", function () {
			// move to cart after ADD TO CART
			handleAddToCart(true);
		})

		function handleAddToCart(redirectToCart = false) {
			var url = base_url + "add-to-cart/";
			var data = { act: "add_to_cart" };

				var valid = checkIfAnyError();
				if (valid.success == 0) {
					toaster.error(valid.error);
					return false;
				}
				var selected = likesForm();
				if (Object.keys(selected).length) {
					data.selected_posts = selected;
				}

				var comments = getComments();
				//console.log(comments);return;
				if (Object.keys(comments).length) {
					data.com = comments;
				}
				//console.log(data);return;
			ajax_send(url, data, redirectToCart);
			return false;
		}

	}
});

function ajax_send(url, data, redirectToCart) {

	$.ajax({
		type: "POST",
		url: url,
		data: data,
		contentType: "application/x-www-form-urlencoded",
		// cache: false,
		dataType: "json",
		// async: true,
		success: function (res) {
			if (res.success == 0) {
				toaster.error(res.message);
				return false;
			}
			handleCart(res, redirectToCart);
		},
	});
}
function likesForm() {
	var selectedElem = $(".gallery-image.selected");

	let slctdElemId, likes, imageSrc, postId;
	var data = {};
	if (Object.keys(selectedElem).length) {
		$.each(selectedElem, function (key, valu) {
			slctdElemId = $(valu).find(".post_id").val();
			likes = parseInt($(valu).find(".per_quantity").val());
			// likes = parseInt($(".selQty" + slctdElemId).html());
			postId = slctdElemId;
			imageSrc = "";
			var likObj = { quantity: likes, post_id: postId };
			var dataObj = { [postId]: likObj };
			//console.log(dataObj);
			Object.assign(data, dataObj);
		});
	}
	console.log(data);
	return data;
}

function checkIfAnyError() {
	var username = $('.user_name#form-stacked-text').val();

	var result = { success: 1 };
	if (username == "") {
		result = {
			success: 0,
			error: "Error: Please enter your Tiktok username.",
		};
	} 
	else if ( $('.load-gallery.custom_image_class[data-found="1"]').length < 1 ) {
		result = {
			success: 0,
			error:
				"Error: Please enter valid username to find your account on Tiktok.",
		};
	} else if (result.success == 1) {
		result = checkError();
	}
	return result;
}
var checkError = function () {
	var selectedElem = $(".gallery-image.selected");
	var result = { success: 1 };
	if (auto_services.includes(sType)) {
		return result;
	}
	//var postCats = postOrderCats();
	if (selectedElem.length === 0) {
		result = { success: 0, error: "Error: Please select atleast one post." };
	} else if (sType == "comments") {
		result = emtpyCommentsError();
	}

	return result;
};

function getComments() {
	var selectedElem = $(".load-gallery").find(".selected");
	var postId;
	var data = {};
	if (Object.keys(selectedElem).length) {
		$.each(selectedElem, function (key, valu) {
			// elem = $(valu);
			postId = $(valu).find(".post_id").val();
			var commentobj = [];
			var comment = $(".com_" + postId).val();
			var quantity = $(".count_" + postId).html();
			commentobj.push({ comment: comment, quantity: quantity, post_id: postId });
			Object.assign(data, { [postId]: commentobj });
		});
	}
	return data;
}

function emtpyCommentsError() {
	var remaining = 0;
	var result = { success: 1 };
	$(".com_area").each(function (key, val) {
		var comElen = $(val);
		var lines = comElen.val().split("\n").filter(Boolean).length;
		var limit = comElen.attr("com-limit");

		if (lines < limit) {
			remaining += limit - lines;
		}
	});
	if (remaining > 0) {
		result = {
			success: 0,
			error: "Error: There are " + remaining + " comments left to add.",
		};
		$("html, body").animate(
			{ scrollTop: $(".wrap_selected_items").offset().top + 20 },
			"slow"
		);
	}
	return result;
}

function handleCart(res, redirectToCart) {
	if (res.success === 1) {
		if (redirectToCart || redirectToCart === true) {
			window.location.href = base_url + "cart#cart_pay_form";
		}
		$(".load-gallery").find(".selected").removeClass("selected");
		if ($(".wrap_selected_items").length > 0) {
			$(".wrap_selected_items").empty();
			//$(".selected_items").empty();
		}
		/*$(".wrap-form-control")
			.not(":first")
			.remove()
			.find(".service-link,.com_area")
			.val("");
		if ($(".service-link").length > 0) {
			$(".service-link").val("");
		}*/

		var cart_count = $("#sf-cart-counts").show().attr("data-count");
		if(typeof cart_count=="undefined"){cart_count=0;}
		if(cart_count > 0){var cart_count = $("#sf-cart-counts").show().attr("data-count") / 1;}
		//alert(cart_count);
		const new_count = cart_count + 1;
		$("#sf-cart-counts").show().attr("data-count", new_count).text(new_count);
		$("html, body").animate({ scrollTop: 0 }, "slow");
		var link =
			"<a class='uk-text-bold uk-text-uppercase uk-text-danger' href='" +
			base_url +
			"checkout/'>View Cart</a>";
		toaster.success(res.message + " " + link);
		setTimeout(function (){
			location.reload();
		}, 3000);
	} else if (res.message) {
		toaster.success(res.message);
	}
	return false;
}

