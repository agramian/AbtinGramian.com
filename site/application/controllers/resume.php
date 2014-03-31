<?php  if ( ! defined('BASEPATH')) header('HTTP/1.1 403 Forbidden'); 
class Resume extends CI_Controller {
	public function index() {
		$this->load->view('resume_view');
	}
    public function getResumePath() {
        if($this->input->get('deviceType')=="true") {
            $this->data['resumePath'] = "https://docs.google.com/file/d/0B0SfdUeEmg-KNURjLXAzVlltN0k/edit?usp=sharing";
        }
        else {
            $this->data['resumePath'] = "cv/Gramian_Abtin_Resume.pdf";   
        }
        
        $this->load->view('resume_ajax', $this->data);
    }
}


