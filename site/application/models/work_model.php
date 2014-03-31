<?php  if ( ! defined('BASEPATH')) header('HTTP/1.1 403 Forbidden'); 

class Work_model extends CI_Model {

    function __construct() {
        parent::__construct();
		$this->load->database();
    }

	public function getAll() {	
		$all = $this->db->query('SELECT * FROM work');
		return $all;
	}
	public function getArt2D() {	
		$art2D = $this->db->query('SELECT * FROM work WHERE category="art2D"');
		return $art2D;
	}
	public function getArt3D() {	
		$art3D = $this->db->query('SELECT * FROM work WHERE category="art3D"');
		return $art3D;
	}
	public function getAudio() {	
		$audio = $this->db->query('SELECT * FROM work WHERE category="audio"');
		return $audio;
	}
	public function getCode() {	
		$code = $this->db->query('SELECT * FROM work WHERE category="code"');
		return $code;
	}
	public function getDesign() {	
		$design = $this->db->query('SELECT * FROM work WHERE category="design"');
		return $design;
	}
	public function getFlash() {	
		$flash = $this->db->query('SELECT * FROM work WHERE category="flash"');
		return $flash;
	}
	public function getGames() {	
		$games = $this->db->query('SELECT * FROM work WHERE category="games"');
		return $games;
	}
	public function getWeb() {	
		$web = $this->db->query('SELECT * FROM work WHERE category="web"');
		return $web;
	}
}