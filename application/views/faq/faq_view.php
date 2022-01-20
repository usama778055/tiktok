
<?php $this->load->view('layouts/header');  ?>
<div id="faq-lottie" class="uk-section faq-banner custom-padding-top">
	<div class="uk-container">
		<div class="uk-width-3-4@s">
			<h3>HELP CENTRE</h3>
			<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
			Lorem Ipsum has been the industry's standard</p>
		</div>
	</div>
</div>


<!--------------FAQ-sec------------------->
<div class="faq-sec uk-section">
	<div class="uk-container">
		<ul uk-accordion>

			<?php

			 foreach ($data as $key => $value){

				$title = $value['title'];
				$description = $value['description'];
				if($key == 0){
				?>
				<li class="uk-open">
					<a class="uk-accordion-title" href="#"><?php echo $title; ?></a>
					<div class="uk-accordion-content">
						<p><?php echo $description; ?></p>
					</div>
				</li>

			<?php }
			else{
				?>
				<li class="">
					<a class="uk-accordion-title" href="#"><?php echo $title; ?></a>
					<div class="uk-accordion-content">
						<p><?php echo $description; ?></p>
					</div>
				</li>
				<?php
			}
			 } ?>				
			

			

			
			
		</ul>
	</div>
</div>
<!---------------------------------------->
<?php $this->load->view('layouts/footer'); ?>