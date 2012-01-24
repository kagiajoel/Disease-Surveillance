<?php
class district_management extends MY_Controller {

	function __construct() {
		parent::__construct();
	}//end constructor

	public function index() {
		$this -> listing();
	}//end index

	public function listing() {
		$data = array();
		$data['content_view'] = "district_listing_v";  
		$data['districts'] = Districts::getDistrictNames();
		$data['provinces'] = Province::getProvinceNames();
		$this -> base_params($data);
	}//end listing

	public function add() {
		$provinces = Province::getAll();
		$data['content-view'] = "district_add_v";
		$data['title'] = "Add New district";
		$data['provinces'] = $provinces;
		$this -> base_params($data);
	}//end add

	public function save() {
		$valid = $this -> _validate_submission();
		if ($valid == false) {
			$data['content-view'] = "district_add_v";
			$this -> base_params($data);
		} else {
			$districtName = $this -> input -> post("district");
			$relatedProvince = $this -> input -> post("provinces");
			$comment = $this -> input -> post("comment");

			$district = new Districts();
			//class instance.modelproperty
			$district -> Name = $districtName;
			$district -> Province = $relatedProvince;
			$district -> Comment = $comment;

			$district -> save();
			redirect("district_management/listing");
		}//end else
	}//end save

	private function _validate_submission() {
		$this -> form_validation -> set_rules('district', 'District', 'trim|required|min_length[2]|max_length[25]');
		
		return $this -> form_validation -> run();
	}//end validate_submission
	
	public function base_params($data){
		$data['styles'] = array("jquery-ui.css");
		$data['scripts'] = array("jquery-ui.js");
		$data['title'] = "";
		$this -> load -> view('district_listing_v', $data);
	}//end base_params

}
?>
