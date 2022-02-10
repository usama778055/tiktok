<?php
if (!function_exists('show_cart_count')) {
	function show_cart_count()
	{
		$cartData = (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) ? $_SESSION['cart'] : array();
		$item_count =  isset($cartData["items"]) ? count($cartData["items"]) : 0;
		return $item_count;
	}
}
