$(document).ready(function (e) {
	if ($("#trackOrder").length > 0) {
		$("#trackOrder").on("click", function () {
			const _this = $(this);
			var orderId = $.trim($("#orderCode").val());
			if (!orderId || orderId == "") {
				toaster.error("Error: Please enter a valid order id.");
				return false;
			}
			$(_this).attr("disabled", true).text("Please Wait...");
			$("#orderCode").attr("disabled", true);
			$(".wraptrackresults").empty();
			if (trackUrl === "tracking") {
				var url = base_url + "tracking/" + orderId + "/";
			}
			else if (trackUrl === "track-order") {
				var url = base_url + "track-order/" + orderId + "/";
			}
			$.ajax({
				type: "POST",
				dataType: "json",
				url: url,
				data: { action: "trackOrder", order_id: orderId },
				success: function (response) {
					$(_this).attr("disabled", false).text("Track Now");
					$("#orderCode").attr("disabled", false);
					if (response.success == 0) {
						toaster.error('Invalid Order ID, please check your email for order details.');
						return false;
					} else if (response.error) {
						toaster.error(response.error);
						return false;
					}
					var data = response.data;
					var html = trackOrderHtml(data);
					$(".wraptrackresults").html(html);
					$(".wraptrackresults").show();
				},
				error: function (msg, xhr, status) {
					$(_this).attr("disabled", false).text("Track Now");
					$("#orderCode").attr("disabled", false);
					console.log(msg, xhr, status);
				}
			});
		});
	}
});

function trackOrderHtml(data) {
	var body = "";
	$.each(data, function (key, value) {
		var post_id =
			"<a href='" +
			ig_url +
			"p/" +
			value.post_id +
			"' target='_blank'>" +
			value.post_id +
			"</a>";
		var startcount = value.start_count ? value.start_count : "";
		var remains = value.remains ? value.remains : "";
		var status = value.status ? value.status : "";
		body +=
			"<tr>" +
			"<td>" +
			post_id +
			"</td>" +
			"<td>" +
			startcount +
			"</td>" +
			"<td>" +
			remains +
			"</td>" +
			"<td>" +
			status +
			"</td>" +
			"</tr>";
	});
	var html =
		'<div class="order_stus_sec uk-overflow-auto">' +
		'<table class="track_table uk-table-divider uk-table">' +
		"<thead>" +
		"<tr>" +
		"<th>Target</th>" +
		"<th>Start count</th>" +
		"<th>Remains</th>" +
		"<th>Status</th>" +
		"</tr>" +
		"<thead>" +
		"<tbody>" +
		body +
		"</tbody>" +
		"</table></div>";
	return html;
}