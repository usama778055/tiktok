$(document).ready(function () {
	$("#payButton").on("click", function () {
		return buyClick(this);
	});
});

const csrf_name = $('#csrf_token').attr('name');
const csrf_hash = $('#csrf_token').val();

function buyClick(elem) {
	let checkout = new StripeCheckout();
	var valid = checkout.checkIfAnyError();

	if (valid.success == 0) {
		toaster.error(valid.error);
		return false;
	}

	elem.textContent = "Please wait...";
	elem.disabled = true;

	// post details for like
	var html = checkout.sendAjax();

	return false;
}

class StripeCheckout {
	constructor() {
		this.stripekey = Stripe($("#stripe_public_key").val());
	}

	sendAjax() {
		var data = { [csrf_name]: csrf_hash };
		data.user_email = $("#user_checkout_email").val();
		var res = {};
		$.ajax({
			url: base_url + "setCartProductSetting/",
			method: "post",
			data: data,
			success: function (response) {
				res = response;
			},
			error: function (xhr, status, msg) {
				toaster.error(msg);
				$("#payButton").text("Pay Now").attr("disabled", false);
			},
		});
		var parent = this;
		this.createCheckoutSession(parent)
		// .then(function (data) {
		// 	if (data.sessionId) {
		// 		var stripe = parent.stripekey;
		// 		stripe
		// 			.redirectToCheckout({
		// 				sessionId: data.sessionId,
		// 			})
		// 			.then(parent.handleResult);
		// 	} else {
		// 		parent.handleResult(data);
		// 	}
		// });
	}
	checkIfAnyError() {
		var email = $("#user_checkout_email").val();
		email = email.trim();
		var result = { success: 1 };
		if (email == "" || !isEmail(email)) {
			result = {
				success: 0,
				error: "Error: Please provide correct email address for checkout.",
			};
		}
		return result;
	}
	async createCheckoutSession(parent) {
		$.ajax({
			url: base_url + "sessionstripeCart/",
			method: "POST",
			dataType: "json",
			async: true,
			data: {
				checkoutSession: 1,
				[csrf_name]: csrf_hash
			},
			success: function (response) {
				const data = response;
				if (data.sessionId && data.status == 1) {
					var stripe = parent.stripekey;
					stripe
						.redirectToCheckout({
							sessionId: data.sessionId,
						})
						.then(parent.handleResult);
				} else {
					parent.handleResult(data);
				}
			},
			error: function (xhr, status, msg) {
				toaster.error(msg);
				$("#payButton").text("Pay Now").attr("disabled", false);
			},
		});
	}

	handleResult(result) {
		if (result.error) {
			toaster.error(result.error.message);
			return false;
		}
		$("#payButton").text("Pay Now").attr("disabled", false);
	}
	buyClick(event) {
		// console.log('buyClick');
		this.buyBtn.addEventListener("click", this.stripeSubmit, false);
		event.preventDefault();
	}

	setProductSetting(dataObj) {
		// const csrf_name = $('#csrf_token').attr('name');
		// const csrf_hash = $('#csrf_token').val();
		$.ajax({
			url: base_url + "setCartProductSetting/",
			method: "post",
			data: { ...dataObj, [csrf_name]: csrf_hash },
			dataType: "post",
			success: function (response) {
				console.log(response);
				return false;
			},
		});
	}

	stripeSubmit(evt) {
		console.log("stripeSubmit");
		let checkout = new StripeCheckout();
		this.checkIfAnyError();
		this.textContent = "Please wait...";
		this.disabled = true;

		var valid = checkError();
		if (valid.success == 0) {
			toaster.error(valid.error);
			return false;
		}
		// post details for like
		var html = this.likesForm();
		console.log(html);
	}
}

function isEmail(email) {
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}
