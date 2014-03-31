<?php  if ( ! defined('BASEPATH')) header('HTTP/1.1 403 Forbidden'); 
class Home extends CI_Controller {
	public function index() {
		$this->load->view('home_view');
	}
    public function error404() {
        $this->load->view('error_view');
    }
}