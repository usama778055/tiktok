
<?php $this->load->view('layouts/header'); ?>

<div class="uk-section faq-1-banner custom-padding-top">
	<div class="faq-1-banner-watermark">
		<img src="<?php echo base_url('assets/images/faq-1-polygon.png'); ?>">
	</div>
	<div class="faq-2-banner-watermark">
		<img src="<?php echo base_url('assets/images/faq-1-polygon2.png'); ?>">
	</div>
	<div class="uk-container">
		<div class="uk-width-3-4@s faq-1-banner-content">
			<h3>we are here to make it happen.</h3>
			<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
		</div>
		<div class="uk-width-3-4@s about-sec">
			<h4>About Us</h4>
			<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem 
				Ipsum has been the industry's standard dummy text ever since the 1500s, when an 
			unknown printer took a galley of type.</p>
		</div>
	</div>
</div>


<!---------------Counter-Sec------------------>
<div class="counter-sec uk-section">
	<div class="uk-container">
		<div class="uk-child-width-1-4@m uk-child-width-1-2@s uk-grid-small uk-text-center" uk-grid>
			<div>
				<div class="count-box"><h4>No<span class="custom-count">1</span></h4><p>In Our <br>Compatitors</p></div>
			</div>
			<div>
				<div class="count-box"><h4><span class="custom-count">1</span>M+</h4><p>Likes Sold</p></div>
			</div>
			<div>
				<div class="count-box"><h4><span class="custom-count">10</span>K+</h4><p>Happy <br> Clients</p></div>
			</div>
			<div>
				<div class="count-box"><h4><span class="custom-count">865</span></h4><p>Regular <br>Customers</p></div>
			</div>
		</div>
	</div>
</div>
<!-------------------------------------------->


<!----------------Contact-Form------------------->
<div id="contact_sec" class="contact-sec">
	<div class="uk-container">
		<div class="custom-bar"></div>
	</div>
	<div class="uk-section">
		<div class="uk-container">
			<h3>Contact With Us</h3>
			<div class="contact-form">
				<form method="post" id="contact_form">
					<div class="" uk-grid>
						<div class="uk-width-1-2@s">
							<div class="contact-input"><legend class="uk-legend">Your Name</legend>
								<div class="uk-margin">
									<input class="uk-input contact_name" type="text" name="name" placeholder="John Doe" value="<?php echo set_value('name'); ?>">
									<span id="name_error" class="text-danger all_error uk-text-danger"></span>
								</div>
							</div>
						</div>
						<div class="uk-width-1-2@s">
							<div class="contact-input contact_email"><legend class="uk-legend">Email Address</legend>
								<div class="uk-margin">
									<input class="uk-input contact_email" type="email" name="email" placeholder="someone@domain.com" value="<?php echo set_value('email'); ?>">
									<span id="email_error" class="text-danger all_error uk-text-danger"></span>
								</div>
							</div>
						</div>
						<div class="uk-width-1-1@s">
							<div class="contact-textarea"><legend class="uk-legend">Your Message</legend>
								<div class="uk-margin">
									<textarea class="uk-textarea contact_message" name="message" rows="5" placeholder="Your message ..."><?php echo set_value('message'); ?></textarea>
									<span id="message_error" class="text-danger all_error uk-text-danger"></span>
								</div>
							</div>
						</div>
					</div>
					<button type="submit" id="contact" name="contact">Submit</button>

				</form>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('layouts/footer'); ?>
