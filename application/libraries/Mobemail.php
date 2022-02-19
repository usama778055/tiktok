<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Custom liberary which handles all the emails,
 * sent from the site, while online process.
 *
 * Auther: Numan
 */
class Mobemail
{

	private $_CI;
	private $mail;
	public function __construct()
	{
		$this->_CI = &get_instance();

		$this->mailConfigSetting();
	}
	public function mailConfigSetting()
	{
		/*$config = array(
		     'protocol' => 'sendmail',
		     'smtp_host' => 'mail.socialfollowers.uk',
		     'smtp_port' => 465,
		     'smtp_user' => 'info@socialfollowers.uk',
		     'smtp_pass' => 'Social@followers123',
		     'mailtype' => 'html',
		     'charset' => 'utf-8',
		     'wordwrap' => TRUE
		 );*/

		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'mail.tiktoklikes.co',
			'smtp_port' => 465,
			'smtp_user' => 'demo@tiktoklikes.co',
			'smtp_pass' => 'Tiktokdemo@1234',
			//'smtp_crypto' => 'tls',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'wordwrap' => TRUE
		);

		$this->_CI->load->library('email', $config);
		$this->mail = $this->_CI->email;
		$this->mail->set_newline("\r\n");
		$this->mail->from('demo@tiktoklikes.co');
		//$this->mail->cc('info@socialfollowers.uk');
	}

	/**
	 * Success order email.
	 * @param type $data (data array includes user and order details.)
	 * @return bol
	 */
	public function mobSuccesOrderMail($data = array())
	{
		$emaildata['email_data'] = $data;
		$body = $this->_CI->load->view('emails/mob_success_email.php', $emaildata, TRUE);
		//$this->mail->to($_SESSION['user_email']);
		$this->mail->to($data['user_email']);
		$this->mail->subject('Order detail - Order id is ' . $data['orderId']);
		$this->mail->message($body);
		return $this->mail->send();
	}

	public function mobMultiSuccesOrderMail($data = array())
	{
		$body = $this->_CI->load->view('emails/order_success_email.php', $data, TRUE);
		$this->mail->to($_SESSION['user_email']);
		$this->mail->subject('Order detail - Order# ' . $data['emailData']['orderId']);
		$this->mail->message($body);
		return $this->mail->send();

	}


	/**
	 * A simple testing email function.
	 * @param type $data
	 * @return type
	 */
	public function testMobMail($data = array())
	{
		$this->mail->to("farazdigitalaimz@gmail.com");
		//$body = $this->_CI->load->view('emails/mob_multiple_order_success_email.php', $data, TRUE);
		$this->mail->subject('Test email from SocialFollowersUk');
		$this->mail->message("test email");
		if (!$this->mail->send(false)) {
			echo $this->mail->print_debugger();
		}
	}

	/**
	 * Invitation email
	 * @param type $data
	 */
	public function mobInvitationMail($data = array())
	{
		$body = $this->_CI->load->view('emails/mob_inv_email.php', $data, TRUE);

		$this->mail->to($data['friendEmail']);
		$this->mail->subject('Your friend ' . $data['name'] . ' has invited you.');
		$this->mail->message($body);

		return $this->mail->send();
	}

	/**
	 * Reward email, send when someone
	 * accepts invitation and make an order.
	 * @param type $data
	 * @return type
	 */
	public function mobRewardMail($data = array())
	{
		$body = $this->_CI->load->view('emails/mob_rewarded_email.php', $data, TRUE);

		$this->mail->to($data['user_email']);
		$this->mail->subject('Your invitation has accepted.');
		$this->mail->message($body);
		return $this->mail->send();
	}

	/**
	 * Email when order is completed.
	 * @param type $data
	 * @return type
	 */
	public function mobCompletedOrderMail($data = array())
	{
		$body = $this->_CI->load->view('emails/order-completed.php', $data, TRUE);

		$this->mail->to($data['user_email']);
		$this->mail->subject('Your order has completed successfully. - Order# ' . $data['order_id']);
		$this->mail->message($body);
		return $this->mail->send();
	}

	/**
	 * Success email of manually placed order.
	 * @param type $data
	 * @return type
	 */
	public function mobCustomSuccesOrderMail($data = array())
	{
		$body = $this->_CI->load->view('emails/mob_success_email.php', $data, TRUE);

		//      $this->mail->to($_SESSION['user_email']);
		$this->mail->to($data['user_email']);
		$this->mail->subject('Order detail - Order# ' . $data['orderId']);
		$this->mail->message($body);

		return $this->mail->send();
	}

	/**
	 * Reorder email (Cancel order)
	 * @param type $data
	 * @return type
	 */
	public function sendReorderEmail($data = array())
	{
		$body = $this->_CI->load->view('emails/re-ordermail.php', $data, TRUE);

		$this->mail->to($data['user_email']);    //
		$this->mail->subject('Missing order details - ' . time());
		$this->mail->message($body);

		$mail = $this->mail->send();
		if ($mail) {
			$this->_CI->Mob_admin->updatePaymentStatus($data['orderId'], 'emailsent');
		}
		return $mail;
	}

	/**
	 * Promo email
	 * @param type $data
	 * @return type
	 */
	public function mobSendPromoMail($data)
	{
		$body = $this->_CI->load->view('emails/mob_promo_email.php', $data, TRUE);

		$this->mail->to($data);
		$this->mail->subject('Hurra you got FLAT 10% discount at SocialFollowers.uk');
		$this->mail->message($body);

		return $this->mail->send();
	}

	/**
	 * Error paypal email
	 * @param type $data
	 */
	public function paymentErrorEmail($data, $message = '')
	{
		$orderID = $_SESSION['new_order'];
		unset($data['meta']);
		unset($data['detail']);
		$this->mail->to("numanbasit@gmail.com");
		$this->mail->subject($message . " Payment status not completed. Order#" . $orderID);
		$this->mail->message("Payment result: " . json_encode($data) . ' session: ' .  json_encode($_SESSION));
		return $this->mail->send();
	}

	/**
	 * Simple text without view.
	 * @param type $data
	 */
	public function simpleTextEmail($data = array())
	{
		$to = $data['to'];
		$message = $data['message'];
		$subject = $data['subject'];

		$this->mail->to($to);
		$this->mail->subject($subject);
		$this->mail->message($message);
		return $this->mail->send();
	}

	/**
	 * Reseller error email
	 * @param type $data
	 * @param type $reqData
	 */
	public function mobResellerError($data, $reqData)
	{
		$orderID = $_SESSION['new_order'];
		$serviceType = ucfirst($_SESSION['package_detail']['serviceType']);

		$this->mail->to("numanbasit@gmail.com");
		$this->mail->subject($serviceType . " order (" . $orderID . ") failed due to reseller error.");
		$this->mail->message("Reseller returns error: " . json_encode($data) . "Request: " . json_encode($reqData));
		return $this->mail->send();
	}

	public function mobNotifyMail($mailData = array())
	{
		$orderID = $_SESSION['new_order'];
		$serviceType = ucfirst($_SESSION['package_detail']['serviceType']);

		$this->mail->to($mailData['to']);
		$this->mail->subject($mailData['subject']);
		$this->mail->message("Service type: " . $serviceType . " <br> Reseller returns " . $mailData['message']);

		return $this->mail->send();
	}
}
