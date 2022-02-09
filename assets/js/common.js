$(document).ready(function () {

	if (window.innerWidth > 992) {
		$(".nav-item.dropdown > .nav-link").on("click", function (e) {
			e.preventDefault();
			return false;
		})
		$(".nav-bar__menu__main .nav-item.dropdown")
			.each(function (index, navItem) {
				$(navItem).on("mouseover", function (e) {
					$(navItem).addClass("show");
					let el_link = $(navItem).find("a.nav-link");
					if (el_link != null) {
						let nextEl = $(el_link).next();
						$(el_link).addClass("shown");
						$(nextEl).addClass("shown");
					}
				});
				$(navItem).on("mouseleave", function (e) {
					$(navItem).removeClass("show");
					let el_link = $(navItem).find("a.nav-link");
					if (el_link != null) {
						let nextEl = $(el_link).next();
						$(el_link).removeClass("shown");
						$(nextEl).removeClass("shown");
					}
				});
			});
	}

}); // Document ready ends

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
// Custom toaster ends

// transform quantities to millions, billions etc.
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