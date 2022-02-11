$(document).ready(function (e) {
	// remove from cart
	if ($(".cart-remove").length > 0) {
		$(document).on("click", ".cart-remove", function (e) {
			var prod_id = $(this).data("id");
			$(".wrap-spinner").show();
			var url = base_url + "checkout/";
			var data = { act: "remove_cart_prod", prod_id: prod_id };
			var functionName = "delCartProd";
			ajax_send(url, data, functionName);
			return false;
		});
	}

	if ($("#getpromo").length > 0) {
		$("#getpromo").on("click", function () {
			var promo = $("#discount_coupon").val();
			if (!promo || promo === "") {
				toaster.error("Please provide a valid coupon code!");
				return false;
			}
			promo = promo.trim();
			var url = base_url + "checkout/";
			var data = { act: "applypromo", promo: promo };
			var functionName = "applyPromo";
			ajax_send(url, data, functionName);
			return false;
		});
	}

	if ($("#proceedPaypal").length > 0) {
		$("#proceedPaypal").on("click", function () {
			var user_email = $("#user_email").val();
			user_email = user_email.trim();
			if (user_email == "") {
				toaster.error("Error: Please enter your email for checkout.");
				$(".wraploader").hide();
				return false;
			}
			if (!isEmail(user_email)) {
				toaster.error("Error: Please enter correct email for checkout.");
				$(".wraploader").hide();
				return false;
			}

			$("#paymentForm").submit();
		});
	}
});

function isEmail(email) {
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}

function ajax_send(url, data, functionName) {

	$.ajax({
		type: "POST",
		url: url,
		data: data,
		cache: false,
		dataType: "json",
		async: true,
		success: function (res) {
			handleAction(res, functionName);
		},
	});
}

function handleAction(res, functionName) {
	switch (functionName) {
		case "delCartProd":
			delCartProd(res);
			break;
		case "applyPromo":
			applyPromo(res);
			break;
	}
}

function delCartProd(res) {
	const cart_badge = "#sf-cart-counts";
	if (res.success === 1) {
		// window.location.reload();
		$(".wrap-spinner").hide();
		var cart_count = $(cart_badge).attr("data-count") / 1;
		const new_count = cart_count - 1;
		$(cart_badge).attr("data-count", new_count).text(new_count);
		if (new_count === 0) {
			$(cart_badge).hide();
		}
		$("#wrap_cart_detail").load(base_url + "checkout #cart-details-sec");
		$("html, body").animate(
			{ scrollTop: $("#wrap_cart_detail").offset().top },
			"slow"
		);
	} else {
		toaster.error("Error: " + res.message);
	}
	return false;
}

function applyPromo(res) {
	if (res.success === 1) {
		var data = res.data;
		var prcnt = data.discountPercent;
		var offAmount = data.discountPrice;
		var discountedAmount = data.discount_pkgprice;
		// $(".invodis_h").html("<h4>Discount (" + prcnt + "%)</h4>");
		// $(".invodis_v").html("£ " + offAmount);
		$(".invodis_v").html(`${prcnt}%`);
		$(".invototal_v").html("£ " + discountedAmount);
		$(".promoDiscount").show();
		toaster.success("Promo successfully applied.");
	} else {
		const msg = res.data
			? res.data
			: res.message
				? res.message
				: "An unhandled error occured, please try again.";
		toaster.error("Error: " + msg);
	}
	return false;
}
