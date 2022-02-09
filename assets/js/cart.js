$(document).ready(function(e){
	$("#add-to-cart").on("click", function(event){
		event.preventDefault();

		var data = { act: "add_to_cart" };

		// const usernamePkgs = ['followers', 'autolikes', 'autoviews'];

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
		if (Object.keys(comments).length) {
			data.com = comments;
		}

		$.ajax({
			method:"POST",
			url : `${base_url}add-to-cart`,
			data : {"username": username },
			cache: false,
			dataType: "json",
			async: true,
			success: function(response){
				console.log(response);
				// if(response['success'])
			}
		});


		// if (usernamePkgs.includes(packageName)) 
		// {
		// 	//removing first '@' if its there
		// 	// after user exists and stuff
		// 	var username = $('.user_name#form-stacked-text').val();
		// 	console.log(username);

		// 	$.ajax({
		// 		method:"POST",
		// 		url : "<?= base_url('add-to-cart') ?>",
		// 		data : {"username": username },
		// 		cache: false,
		// 		dataType: "json",
		// 		async: true,
		// 		success: function(response){
		// 			console.log(response);
		// 			// if(response['success'])
		// 		}
		// 		// error: function (argument) {
		// 		// 	// body...
		// 		// }
		// 	});
		// }
		// else
		// {
		// 	var postId = []
		// 	var userData = $(".load-gallery .gallery-image.selected")
			
		// 	console.log('user posts');

		// 	$.ajax({
		// 		method:"POST",
		// 		url : "<?= base_url('add-to-cart') ?>",
		// 		data : {"userData": userData },
		// 		success: function(response){
		// 			console.log(response);
		// 		}
		// 	});
		// }
	})
})

function likesForm() {
	var selectedElem = $(".userdatalikes").find(".selected");
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
	var selectedElem = $(".proposts.selected");
	var result = { success: 1 };
	if (is_auto === "true") {
		return result;
	}
	var postCats = postOrderCats();
	if ($.inArray(sType, postCats) != -1 && selectedElem.length === 0) {
		result = { success: 0, error: "Error: Please select atleast one post." };
	} else if (sType == "comments") {
		result = emtpyCommentsError();
	}

	return result;
};

function getComments() {
	var selectedElem = $(".userdatalikes").find(".selected");
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
