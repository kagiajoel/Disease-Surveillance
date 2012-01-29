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
		$districts = Districts::getAll();
		$diseases = Diseases::getAllObjects();
		
		$data['content-view'] = "weeklydata_add_v";
		$data['title'] = "Add Weekly Data";
		$data['provinces'] = $provinces;
		$data['districts'] = $districts;
		$data['diseases'] = $diseases;
		$this -> base_params($data);
	}//end add 
	
	public function save(){
		$i = 0;
		//$diseases = Diseases::getAll();
		$valid = $this -> _validate_submission();
		if($valid == false){
			$data['content-view'] = "weeklydata_add_v";
			$this -> base_params($data);
		}else{
			$diseases = new Diseases();
			$i = 0;
			$weekending = $this -> input -> post("weekending");
			$epiweek = $this -> input -> post("epiweek");
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
			$sickness = $this -> input -> post("disease");
			
			foreach($diseases as $disease){
		
			
			$surveillance = new Surveillance();
			$surveillance -> Week_Ending = $weekending;
			$surveillance -> Epiweek = $epiweek;
			$surveillance -> District = $district;
			$surveillance -> Submitted = $reportingfacilities;
			$surveillance -> Expected = $expectedfacilities;
			$surveillance -> Lmcase = $lmcase[$i];
			$surveillance -> Lfcase = $lfcase[$i];
			$surveillance -> Lmdeath = $lmdeath[$i];
			$surveillance -> Lfdeath = $lfdeath[$i];
			$surveillance -> Gmcase = $gmcase[$i];
			$surveillance -> Gfcase = $gfcase[$i];
			$surveillance -> Gmdeath = $gmdeath[$i];
			$surveillance -> Gfdeath = $gfdeath[$i];						
			$surveillance -> Disease = $sickness;		
			$surveillance -> save();	
			$i++;			
			}//end foreach
			
			//Lab Data
			$labdata = new Lab_Weekly();
			$epiweek = $this -> input -> post("epiweek");
			$weekending = $this -> input -> post("weekending");
			$district = $this -> input -> post("district");
			
			$totaltestedlessfive = $this -> input -> post("totaltestedlessfive");
			$totaltestedgreaterfive = $this -> input -> post("totaltestedgreaterfive");
			$totalpositivelessfive = $this -> input -> post("totalpostitivelessfive");
			$totalpositivegreaterfive = $this -> input -> post("totalpositivegreaterfive");
			$remarks = $this -> input -> post("remarks");
			
			$labdata -> Epiweek = $epiweek;
			$labdata -> Weekending = $weekending;
			$labdata -> District = $district;
			$labdata -> Malaria_below_5 = $totaltestedlessfive;
			$labdata -> Malaria_above_5 = $totaltestedgreaterfive;
			$labdata -> Positive_below_5 = $totalpositivelessfive;
			$labdata -> Positive_above_5 = $totalpositivegreaterfive;
			$labdata -> Remarks = $remarks;
			$labdata -> save();
		} 
	}//end save
	
	public function base_params($data){
		$data['styles'] = array("jquery-ui.css");
		$data['scripts'] = array("jquery-ui.js");
		$data['title'] = "";
		$this -> load -> view('weeklydata_add_v', $data);
	}//end base_params
}//end class
