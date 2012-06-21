<?php
class Weekly_Facility extends MY_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		
		$this -> add();
	}

	public function add($data = array()) {
		$access_level = $this -> session -> userdata('user_indicator');
		$facilities = Facilities::getAll();
		$districts = District::getAll();
		$diseases = Disease::getAllObjects();

		$data['facilities'] = $facilities;
		$data['districts'] = $districts;
		$data['diseases'] = $diseases;
		$data['editing'] = false;
		$data['prediction'] = Surveillance::getPrediction();
		$data['scripts'] = array("special_date_picker.js", "validationEngine-en.js", "validator.js");
		$data["styles"] = array("validator.css");
		$this -> base_params($data);
	}

	public function edit_weekly_data($epiweek, $reporting_year, $facility) {
		$facilities = Facilities::getAll();
		$districts = District::getAll();
		$diseases = Disease::getAllObjects();

		$data['facilities'] = $facilities;
		$data['districts'] = $districts;
		$data['diseases'] = $diseases;
		$data['prediction'] = Surveillance::getPrediction();
		$data['surveillance_data'] = Surveillance::getSurveillanceDataFacility($epiweek, $reporting_year, $facility);
		$data['lab_data'] = Lab_Weekly::getWeeklyFacilityLabData($epiweek, $reporting_year, $facility);
		$data['editing'] = true;
		$data['scripts'] = array("special_date_picker.js", "validationEngine-en.js", "validator.js");
		$data["styles"] = array("validator.css");
		$this -> base_params($data);
	}

	public function delete_weekly_data($epiweek, $reporting_year, $facility) {
		$data['surveillance_data'] = Surveillance::getSurveillanceDataFacility($epiweek, $reporting_year, $facility); 
		$data['title'] = "Delete Weekly Data";
		$data['content_view'] = "delete_weekly_data_v";
		$data['banner_text'] = "Delete Data";
		$data['link'] = "submissions_management";
		$this -> load -> view("template", $data);
	}

	public function confirm_delete_weekly_data($epiweek, $reporting_year, $facility) {
		$surveillance_data = Surveillance::getSurveillanceDataFacility($epiweek, $reporting_year, $facility);
		$lab_data = Lab_Weekly::getWeeklyFacilityLabData($epiweek, $reporting_year, $facility);
		//Delete the data
		foreach($surveillance_data as $disease_data){
			$disease_data->delete();
		}
		$lab_data->delete();
		//Log the action
		$log = new Data_Delete_Log(); 
		$log->Deleted_By = $this -> session -> userdata('user_id');
		$log->District_Affected = $district;
		$log->Epiweek = $epiweek;
		$log->Reporting_Year = $reporting_year;
		$log->Timestamp = date('U');
		$log->save();
		redirect("data_delete_management");
	}

	public function save() {
		$i = 0;
		$valid = $this -> _validate_submission();
		if ($valid == false) {
			$this -> add();
		} else {
			$editing = false;
			$diseases = Disease::getAllObjects();

			$weekending = $this -> input -> post("week_ending");
			$reporting_year = $this -> input -> post("reporting_year");
			$epiweek = $this -> input -> post("epiweek");
			$facility = $this -> input -> post("facility");
			$reportingfacilities = $this -> input -> post("reporting_facilities");
			$expectedfacilities = $this -> input -> post("expected_facilities");
			$lmcase = $this -> input -> post("lmcase");
			$lfcase = $this -> input -> post("lfcase");
			$lmdeath = $this -> input -> post("lmdeath");
			$lfdeath = $this -> input -> post("lfdeath");
			$gmcase = $this -> input -> post("gmcase");
			$gfcase = $this -> input -> post("gfcase");
			$gmdeath = $this -> input -> post("gmdeath");
			$gfdeath = $this -> input -> post("gfdeath");
			$sickness = $this -> input -> post("disease");
			$reported_by = $this -> input -> post("reported_by");
			$designation = $this -> input -> post("designation");
			$lab_id = $this -> input -> post("lab_id");
			$surveillance_ids = $this -> input -> post("surveillance_ids");
			$data_exists = Surveillance::getFacilityData($epiweek, $reporting_year, $facility);
			if ($lab_id > 0) {
				$editing = true;
			}
			if ($data_exists -> id && $editing == false) {
				$data = array();
				$data['duplicate_facility'] = Facilities::getFacility($facility);
				$data['duplicate_epiweek'] = $epiweek;
				$data['duplicate_reporting_year'] = $reporting_year;
				$data['existing_data'] = true;
				$this -> add($data);
				return;
			}
			$total_diseases = Disease::getTotal();
			$timestamp = date('d/m/Y');

			$i = 0;
			foreach ($diseases as $disease) {
				if ($editing == true) {
					$surveillance = Surveillance::getSurveillance($surveillance_ids[$i]);

				} else {
					$surveillance = new Surveillance();
				}

				$surveillance -> Week_Ending = $weekending;
				$surveillance -> Epiweek = $epiweek;
				$surveillance -> Facility = $facility;
				$surveillance -> Submitted = $reportingfacilities;
				$surveillance -> Expected = $expectedfacilities;
				$surveillance -> Lmcase = $lmcase[$i];
				$surveillance -> Lfcase = $lfcase[$i];
				$surveillance -> Lmdeath = $lmdeath[$i];
				$surveillance -> Lfdeath = $lfdeath[$i];
				if (isset($gmcase[$i])) {
					$surveillance -> Gmcase = $gmcase[$i];
					$surveillance -> Gfcase = $gfcase[$i];
					$surveillance -> Gmdeath = $gmdeath[$i];
					$surveillance -> Gfdeath = $gfdeath[$i];
				}
				$surveillance -> Disease = $disease;
				$surveillance -> Reporting_Year = $reporting_year;
				$surveillance -> Created_By = $this -> session -> userdata('user_id');
				$surveillance -> Date_Created = date("Y-m-d");
				$surveillance -> Reported_By = $reported_by;
				$surveillance -> Designation = $designation;
				$surveillance -> Total_Diseases = $total_diseases;
				$surveillance -> Date_Reported = $timestamp;
				$surveillance -> save();
				$i++;
			}//end foreach

			//Lab Data
			if ($editing == true) {
				$labdata = Lab_Weekly::getLabObject($lab_id);
			} else {
				$labdata = new Lab_Weekly();
			}

			$totaltestedlessfive = $this -> input -> post("total_tested_less_than_five");
			$totaltestedgreaterfive = $this -> input -> post("total_tested_greater_than_five");
			$totalpositivelessfive = $this -> input -> post("total_positive_less_than_five");
			$totalpositivegreaterfive = $this -> input -> post("total_positive_greater_than_five");
			$remarks = $this -> input -> post("remarks");

			$labdata -> Epiweek = $epiweek;
			$labdata -> Week_Ending = $weekending;
			$labdata -> Facility = $facility;
			$labdata -> Malaria_Below_5 = $totaltestedlessfive;
			$labdata -> Malaria_Above_5 = $totaltestedgreaterfive;
			$labdata -> Positive_Below_5 = $totalpositivelessfive;
			$labdata -> Positive_Above_5 = $totalpositivegreaterfive;
			$labdata -> Remarks = $remarks;
			$labdata -> Reporting_Year = $reporting_year;
			$labdata -> Date_Created = date("Y-m-d");
			$labdata -> save();
			if ($editing) {
				$data['success_message'] = "You have successfully edited data for " . $labdata -> Facility -> Name;
				$this -> add($data);
			}
			if (!$editing) {
				$data['success_message'] = "You have successfully added weekly data for " . $labdata -> Facility -> Name;
				$this -> add($data);
			}

			//redirect("weekly_facility/add");
		}
	}//end save

	private function _validate_submission() {
		$this -> form_validation -> set_rules('facility', 'Facility', 'trim|required|min_length[1]');

		return $this -> form_validation -> run();
	}//end validate_submission

	/*
	 * Function to check if district data for a particular week exists
	 *
	 */
	function check_facility_data($epiweek, $year, $facility) {
		$data = Surveillance::getFacilityData($epiweek, $year, $facility);
		if ($data -> id) {
			echo "yes";
		} else {
			echo "no";
		}
	}

	public function base_params($data) {
		$data['title'] = "Weekly Data";
		$data['content_view'] = "facility_data_add";
		$data['banner_text'] = "Weekly Data";
		//$data['link'] = "submissions_management";
		$data['quick_link'] = "weekly_facility";
		$this -> load -> view("template", $data);
	}

}//end class
