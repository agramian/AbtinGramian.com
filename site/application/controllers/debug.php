<?php  if ( ! defined('BASEPATH')) header('HTTP/1.1 403 Forbidden'); 
class Debug extends CI_Controller {
	public function index() {
		$this->load->view('debug_view');
	}
}


