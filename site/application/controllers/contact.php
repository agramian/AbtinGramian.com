<?php  if ( ! defined('BASEPATH')) header('HTTP/1.1 403 Forbidden'); 
class Contact extends CI_Controller {

	public function index() {
		$this->load->view('contact_view', $this->data);	
	}
	
	public function checkPhoneNumber($number) {
        $phoneRegExp = "/^((\+)?[1-9]{1,2})?([-\s\.])?((\(\d{1,4}\))|\d{1,4})(([-\s\.])?[0-9]{1,12}){1,2}$/";
        $numberLen = preg_match_all( '/\d/', $number, $matches );
        if (10 <= $numberLen && $numberLen <= 20) {
            return preg_match($phoneRegExp, $number) ? true : false;
        }
		return false;
	}
	
	public function checkEmail($email) 
	{
		// checks proper syntax
		if( filter_var( $email, FILTER_VALIDATE_EMAIL ) )
		{	
			// gets domain name
			list($username,$domain)=explode('@',$email);
			// checks for if MX records in the DNS
			if(!checkdnsrr($domain, 'MX')) 
			{
				return false;
			}
			// attempts a socket connection to mail server
			if(!fsockopen($domain,80,$errno,$errstr,30)) 
			{
				return false;
			}
			return true;
		}
		return false;
	}
	
	public function sendMessage() {
		$this->data['messageSent'] = "false";
		$this->data['messageType'] = $this->input->get('messageType');
		$this->data['senderContact'] = $this->input->get('senderContact');
		$this->data['message'] = $this->input->get('message');
		$this->data['messageTitle'] = $this->input->get('messageTitle');
		if($this->data['messageType'] == "email")
			$this->sendEmail();
		else
			$this->sendText();
	}
	
	public function sendEmail() {
		if($this->checkEmail($this->data['senderContact'])) {
			$headers = 'From: abtin.gramian@abtingramian.com' . "\r\n" . 'Reply-To: ' . $this->data['senderContact'];
			mail("abtin.gramian@gmail.com",strip_tags($this->data['messageTitle']),strip_tags($this->data['message']),$headers);
			$this->data['messageSent'] = "true";
		}
		$this->load->view('contact_ajax', $this->data);
	}
	
	public function sendText() {
		if($this->checkPhoneNumber($this->data['senderContact'])) {
			$tm = "From: ". $this->data['senderContact'];
			$tm .= "\nTitle: " .	$this->data['messageTitle'];
			$tm .= "\nMessage: " . $this->data['message'];	
			$url = 'http://www.txtdrop.com/send.php';
			$body = 'number=8ytlmh052b6i&body='.$tm;
			
			$c = curl_init($url);
			curl_setopt($c, CURLOPT_POST, true);
			curl_setopt($c, CURLOPT_POSTFIELDS, $body);
			curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
			curl_exec($c);
			curl_close($c);
			$this->data['messageSent'] = "true";	  
		}
		$this->load->view('contact_ajax', $this->data);
	}
}


