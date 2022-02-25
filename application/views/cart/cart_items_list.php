<?php
$cartData = (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) ? $_SESSION['cart'] : array();
if(!empty($cartData['items'])){ ?>
	<div class="shopping-details">
		<div class="uk-panel-scrollable">
			<table class="uk-table uk-table-striped">
				<thead>
				<tr class="shopping-detail-head">
					<th>Services</th>
					<th>Qty</th>
					<th>Price</th>
				</tr>
				</thead>
				<tbody>
				<?php
				foreach($cartData['items'] as $item) { ?>
					<tr class="shopping-detail-body">
						<td><?= $item['service_detail']['packageTitle'] ?></td>
						<td><?= $item['service_detail']['packageQty'] ?></td>
						<td><?= $item['priceUnit'].' '.$item['amount_payable'] ?></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
		<div class="cart-btn">
			<a href="<?= base_url() ?>">I want to shop more</a>
			<a class="payment-btn" href="<?= base_url('checkout') ?>">Proceed To Payment</a>
		</div>
	</div>
<?php }
else { ?>
	<div class="cart-empty">
		<span>Cart is empty</span>
		<div>
<?php } ?>
