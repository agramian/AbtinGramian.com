<?php  if ( ! defined('BASEPATH')) header('HTTP/1.1 403 Forbidden'); 
class Work extends CI_Controller {

	public $data = array();

	public function index() {
		$this->data['currentDisplay'] = 0;
		$this->load->view('work_view', $this->data);
	}
	
	public function queryDatabase() {
		$this->data['currentDisplay'] = $this->input->get('currentDisplay');
		$this->load->model('Work_model');
		
		switch($this->data['currentDisplay']) {
			case 0:
				//this data was retrieved from the database
				$this->data['query'] = $this->Work_model->getAll();	
				break;
			case 1:
				//this data was retrieved from the database
				$this->data['query'] = $this->Work_model->getArt2D();
				break;
			case 2:
				//this data was retrieved from the database
				$this->data['query'] = $this->Work_model->getArt3D();
				break;	
			case 3:
				//this data was retrieved from the database
				$this->data['query'] = $this->Work_model->getAudio();
				break;
			case 4:
				//this data was retrieved from the database
				$this->data['query'] = $this->Work_model->getCode();
				break;
			case 5:
				//this data was retrieved from the database
				$this->data['query'] = $this->Work_model->getDesign();
				break;
			case 6:
				//this data was retrieved from the database
				$this->data['query'] = $this->Work_model->getGames();
				break;
			case 7:
				//this data was retrieved from the database
				$this->data['query'] = $this->Work_model->getWeb();
				break;
		}
		
		$this->load->view('work_ajax', $this->data);
	}

    public function getVideoSrc() {
        $this->data['source'] = $this->input->get('src');
		if( $this->input->get('speed') < $this->input->get('minHiQSpeed') ) {
			$this->load->view('video_view_ajax-slow', $this->data);
		}
		else {
        	$this->load->view('video_view_ajax-fast', $this->data);
		}   
    }

    public function getAudioSrc() {
        $this->data['source'] = $this->input->get('src');
        $this->load->view('audio_view_ajax', $this->data);
    }
    
    public function getFlashSrc() {
        $this->data['source'] = $this->input->get('src');
        $this->load->view('flash_view_ajax', $this->data);  
    }
    
    public function getGameSrc() {
        $this->data['source'] = $this->input->get('src');
        $this->data['mediaType'] = $this->input->get('mediaType');
        $this->data['hasPlugin'] = $this->input->get('hasPlugin');
        if($this->data['mediaType']=='Panda3D') {
            $this->load->view('panda3D_view_ajax', $this->data);
        }
        else if($this->data['mediaType']=='Ogre') {
            $this->data['platform'] = $this->input->get('platform'); 
            $this->data['width'] = $this->input->get('width'); 
            $this->data['height'] = $this->input->get('height'); 
            $this->load->view('ogre_view_ajax', $this->data);
        }
    }
    
    public function getCodeSrc() {
        $this->data['source'] = $this->input->get('src');
        $this->load->view('code_view_ajax', $this->data);
    }
}