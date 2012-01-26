<?php
class weeklydata_management extends MY_Controller{
	
	function __construct(){
		parent::__construct();
	}//end constructor
	
	public function index(){
		$this -> listing();
	}//end index
	
	public function listing(){
		$data = array();
		$data['content_view'] = "submission_v";
	}//end listing
	
	public function add(){
		$provinces = Province::getAll();
		$districts = Districts::getspecifiedDistrict();
		$diseases = Diseases::getAll();
		
		$data['content-view'] = "weeklydata_add_v";
		$data['title'] = "Add Weekly Data";
		$data['provinces'] = $provinces;
		$data['districts'] = $districts;
		$data['diseases'] = $diseases;
		$this -> base_params($data);
	}//end add 
	
	public function save(){
		$i = 0;
		$diseases = Diseases::getAll();
		$valid = $this -> _validate_submission();
		if($valid == false){
			$data['content-view'] = "weeklydata_add_v";
			$this -> base_params($data);
		}else{
			foreach($diseases as $disease){
			$weekending = $this -> input -> post("weekending");
			$epiweek = $this -> input -> post("epiweek");
			$province = $this -> input -> post("province");
			$district = $this -> input -> post("district");
			$reportingfacilities = $this -> input -> post("reportingfacilities");
			$expectedfacilities = $this -> input -> post("expectedfacilities");
			$lmcase = $this -> input -> post("lmcase");
			$lfcase = $this -> input -> post("lfcase");
			$lmdeath = $this -> input -> post("lmdeath");
			$lfdeath = $this -> input -> post("lfdeath");
			$gmcase = $this -> input -> post("gmcase");
			$gfcase = $this -> input -> post("gfcase");
			$gmdeath = $this -> input -> post("gmdeath");
			$gfdeath = $this -> input -> post("gfdeath");
			$sickness = $this -> input -> post($disease);
						
			}//end foreach
			
			//Lab Data
			$totaltestedlessfive = $this -> input -> post("totaltestedlessfive");
			$totaltestedgreaterfive = $this -> input -> post("totaltestedgreaterfive");
			$totalpositivelessfive = $this -> input -> post("totalpostitivelessfive");
			$totalpositivegreaterfive = $this -> input -> post("totalpositivegreaterfive");
			$remarks = $this -> input -> post("remarks");
			$reporter = $this -> input -> post("reporter");
			$designation =$this -> input -> post("designation");
		} 
	}//end save
}//end class
