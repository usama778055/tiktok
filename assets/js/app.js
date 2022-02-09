$(document).ready(function () {
	const auto_services = [
		"followers",
		"autolikes",
		"autoviews",
		"livestream",
	];
	// set username from session to input field.
	setTimeout(function () {
		$(".user_name#form-stacked-text").val(user_name ? user_name : "");
		// $("#user_email").val(user_email ? user_name : "");
		showInitUserPosts();
	}, 1000);

	// if ($("#ig_username").length > 0) {
	// 	$("#ig_username").on("change", function () {
	// 		showInitUserPosts();
	// 	});
	// }

	function showInitUserPosts() {
		var userName = $('input[name="tiktok_username"]').val();
		// var userEmail = $('input[name="user_email"]').val();
		if (userName && userName !== "") {
			showUserPosts();
		}
	}

	function showUserPosts() {
		$(".load-gallery.custom_image_class").addClass("shown");
		var userName = $('input[name="tiktok_username"]').val();
		// var userEmail = $('input[name="user_email"]').val();

		if (userName === "") {
			toaster.error(
				"Error: Please enter correct details to find your account on tiktok."
			);
			$(".load-gallery.custom_image_class").removeClass("shown");
			return false;
		}

		// sendAjax('username field', username, 'email');
		sendAjax(".user_name#form-stacked-text", userName);
	}

	// get instagram data (ajax)
	function sendAjax(selector, username) {
		jQuery.ajax({
			url: `${base_url}find`,
			method: "POST",
			dataType: "json",
			data: {
				action: "get_tiktok_user",
				user_name: username,
				// user_email: email,
			},
			beforeSend: function() {
			    $(".loader_class").show();
			    $("#form-stacked-text"). attr('disabled','disabled');   
			}, 
			success: function (data, status){
				$(".loader_class").hide();
				$("#form-stacked-text").removeAttr('disabled');

				$(".load-gallery.custom_image_class").removeClass("shown");
				$(selector).attr("disabled", false);
				if (status === "success") {
					if (data.success === true || data.success === 1) {
						toaster.success("Tiktok Data Loaded Succesfully!");
						$(".load-gallery.custom_image_class").attr("data-found", 1);
						if (auto_services.includes(sType)) {
							displayTiktokProfile(data.data);
							return false;
						} else {
							$(".load-gallery.custom_image_class").replaceWith(data.html);
							fetchThumbnails(data.data);
							return false;
						}
					} else {
						$(".load-gallery.custom_image_class").attr("data-found", 0);
						toaster.error(data.message);
					}
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				$(".load-gallery.custom_image_class").removeClass("shown");
				$(selector).attr("disabled", false);
				toaster.error(errorThrown);
			},
		});
	}

	// change package using dropdown
	$(document).on("change", ".apconMain #select-pkg", function (e) {
		const url = $(this).val();
		window.location.replace(url);
	});

	// Get user instagram data on input focus out
	$(document).on("focusout", ".wrpinputap #ig_username", function (e) {
		const value = $(this).val();
		if (value && value !== user_name) {
			const _this = $(this);
			$("#profile_overlay").addClass("shown");
			const username = $(_this).attr("disabled", true).val();
			// const email = $(".wrpinputap #email").val();
			sendAjax("#ig_username", username);
		}
	});

	$("#form_evt").on('submit', (e) => {
		e.preventDefault();
	})

	// $(document).on("keyup", ".wrpinputap #ig_username", function (e) {
	// 	if(e.which == '13')
	// 	{
	// 		const value = $(this).val();
	// 		if (value && value !== user_name) {
	// 			const _this = $(this);
	// 			$("#profile_overlay").addClass("shown");
	// 			const username = $(_this).attr("disabled", true).val();
	// 			// const email = $(".wrpinputap #email").val();
	// 			sendAjax("#ig_username", username);
	// 		}
	// 	}
	// });

	// handle thumbnails for instagram data
	function fetchThumbnails(data) {
		const user = data.user;
		showNextButton(user);
		// Intagram Profile Picture
		showProfilePicture(user);
		const posts = data.posts;
		// Instagram Posts Thumbnails
		showPostThumbnails(posts);
	}

	// handle base64 thumbnail for profile picture
	function showProfilePicture(user) {
		const profile_pic = user.profile_pic;
		showImage("#ig_profile_thumb", "profile_img", profile_pic);
	}

	// handle base64 thumbnails for posts
	function showPostThumbnails(posts) {
		$.each(posts, function (n, post) {
			showImage("#post_" + post.id, post.id, post.link);
		});
	}

	// Get base64 thumbnail
	function showImage(selector, imageId, image) {
		$.ajax({
			type: "POST",
			url: base_url + "find/",
			async: true,
			cache: false,
			dataType: "json",
			data: {
				action: "fetchImage",
				imageId: imageId,
				image: image,
			},
			success: function (res) {
				$(selector)
					.css({
						"background-image": "url(" + res + ")",
						backgroundSize: "100%",
					})
					.find(".post_thumbnail")
					.val(res);
			},
			error: function (_, __, resText) {
				console.log(resText);
			},
		});
	}

	function displayTiktokProfile(data) {
		const user = data.user;
		showProfilePicture(user);
		displayIgCounts(user);
	}

	function displayIgCounts(user) {
		const username = user.user_name,
			fullname = user.full_name,
			following = user.following,
			followers = user.followers,
			post_count = user.post_count;
		$("#ig-d-fullname").text(fullname);
		$("#ig-d-username").text("@" + username);
		$("#ig-post-count").text(transformQuantity(post_count));
		$("#ig-followers-count").text(transformQuantity(followers));
		$("#ig-following-count").text(transformQuantity(following));
	}

	// Show next button if more posts exist.
	function showNextButton(user) {
		const next_page = user.next_page;
		const next_token = user.next_token;
		if (!next_page || !next_token) {
			$(".moredata").remove();
		}
	}

	// Load more Posts
	$(document).on("click", "#load_more_posts", function () {
		const _this = $(this);
		$(this).attr("disabled", true).text("Loading Posts...");
		$.ajax({
			type: "POST",
			url: base_url + "find/",
			data: { action: "load_more" },
			cache: false,
			dataType: "json",
			async: true,
			success: function (dataRes, status) {
				$(_this).attr("disabled", false).text("Load More");
				if (status === "success") {
					if (dataRes.success === true) {
						$(".userdatalikes").append(dataRes.html);
						const user = dataRes.user;
						showNextButton(user);
						const posts = dataRes.posts;
						showPostThumbnails(posts);
						return false;
					} else {
						toaster.error(dataRes.msg);
					}
				}
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				$(_this).attr("disabled", false).text("Load More");
				toaster.error("Please confirm your username and try again");
			},
		});
		return false;
	});

	// Select Posts handler
	$(document).on("click", ".userdatalikes .proposts", function () {
		$(this).toggleClass("selected");
		const length = $(".proposts.selected").length;
		const quantity = packageQty / 1;
		const service_limit = limit / 1;
		// const serviceType = sType;
		let per_input = Math.floor(quantity / length);
		const remaining = quantity % length;
		if (length > 1 && per_input < service_limit) {
			$(this).addClass("shake animated");
			$(this).removeClass("selected");
			UIkit.notification({
				message: `Minimum ${sType} per post are ${service_limit}.`,
				status: "danger",
				pos: "top-right",
				timeout: 5000,
			});
			if (sType === "comments" && $(".wrap_selected_items").length > 0) {
				$("html, body").animate(
					{ scrollTop: $(".wrap_selected_items").offset().top + 20 },
					"slow"
				);
			}
			setTimeout(() => {
				$(this).removeClass("shake animated");
			}, 600);
			return false;
		}
		if (sType == "comments") {
			handleCommentsHtml(length, per_input);
		}
		if (quantity > 0) {
			$(".proposts").each((index, post) => {
				if ($(post).hasClass("selected")) {
					if (index === length - 1) {
						per_input += remaining;
					}
					$(post).find(".selected_qty").text(per_input);
					$(post).find(".per_quantity").val(per_input);
				} else {
					$(post).find(".selected_qty").text("");
					$(post).find(".per_quantity").val(0);
				}
			});
		}
	});

	function handleCommentsHtml(length, per_input) {
		if (length < 1) {
			$(".selected_items").empty();
			$(".wrap_selected_items").hide();
			return false;
		}
		$(".selected_items").empty();
		$(".proposts").each((index, post) => {
			if ($(post).hasClass("selected")) {
				var html = commentsHtml(post, per_input);
				if (html != "") {
					$(".wrap_selected_items").show();
					$(".selected_items").append(html);
				}
			}
		});
		$(".com_area").ready(function () {
			commentCount();
		});
	}

	function commentsHtml(post, qty) {
		var postId = $(post).find(".post_id").val();
		var bg_img = $(post)
			.css("background-image")
			.replace(/^url\(['"](.+)['"]\)/, "$1");
		var html = "";
		html +=
			'<div class="comments_sec">' +
			'<div class="post_area cmntcol">' +
			'<div data-id="' +
			postId +
			'" style="background-image: url(' +
			bg_img +
			')" class="selected_img"></div>' +
			"</div>" +
			'<div class="comments_field">' +
			'<div class="wrap_rem_counts"><div class="comments_field-hdr"><span>' +
			qty +
			"</span> Comments (1 per line)</div>" +
			'<div class="comments_field-ftr">Quantity: <span class="count_' +
			postId +
			'">0</span> / <span class="total_com">' +
			qty +
			"</span></div></div>" +
			'<textarea placeholder="Write your comments here..." rows="' +
			qty +
			'" cols="50" spellcheck="true" class="com_area com_' +
			postId +
			'" data-id="' +
			postId +
			'" com-limit="' +
			qty +
			'"></textarea>' +
			"</div>" +
			"</div>";
		return html;
	}
	// Count comments (1 per line) on comments textarea
	function commentCount() {
		$(".com_area").keypress(function (event) {
			var comElen = $(this);
			var lines = comElen.val().split("\n");
			var limit = comElen.attr("com-limit");
			if (lines.length >= limit) {
				if (event.which == "13") {
					event.preventDefault();
					toaster.error(
						"You can select minimum " + limit + " " + sType + " per post."
					);
				}
			}
		});

		$(".com_area").keyup(function (event) {
			var comElen = $(this);
			var lines = comElen.val().split("\n");
			var postId = comElen.attr("data-id");
			$(".count_" + postId).text(lines.length);
		});
	}
}); // JQUERY ENDS

// Email validity
function isEmail(email) {
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}
