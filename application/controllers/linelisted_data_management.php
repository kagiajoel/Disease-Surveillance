<?php
class Linelisted_Data_Management extends MY_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() { 
		$this -> add();
	}

	public function add() {
		$provinces = Province::getAll();
		$districts = District::getAll();
		$facilities = Facilities::getAll();
		$diseases = Disease::getAllObjects();

		$data['provinces'] = $provinces;
		$data['districts'] = $districts;
		$data['facilities'] = $facilities;
		$data['diseases'] = $diseases;
		
		$data['scripts'] = array("special_date_picker.js", "validationEngine-en.js", "validator.js");
		$data["styles"] = array("validator.css");

		$data['title'] = "Line List Data";
		$data['content_view'] = "linelist_data_add_v";
		$data['banner_text'] = "Linelist Data";
		$data['link'] = "submissions_management";
		$data['quick_link'] = "linelisted_data_management";
		//$this -> base_params($data);
		$this -> load -> view("template", $data);
	}

}