<?php
error_reporting(E_ALL ^ E_NOTICE);
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Home_Controller extends MY_Controller {
	function __construct() {
		parent::__construct();
	}

	public function index() {
		$this -> home();
	}

	public function home() {
		$currentyear = date('Y');
		$rights = User_Right::getRights($this -> session -> userdata('access_level'));
		$menu_data = array();
		$menus = array();
		$counter = 0;
		foreach ($rights as $right) {
			$menu_data['menus'][$right -> Menu] = $right -> Access_Type;
			$menus['menu_items'][$counter]['url'] = $right -> Menu_Item -> Menu_Url;
			$menus['menu_items'][$counter]['text'] = $right -> Menu_Item -> Menu_Text;
			$counter++;
		}
		$this -> session -> set_userdata($menu_data);
		$this -> session -> set_userdata($menus);

		$provinces = Province::getAll();
		$epiweeks = Surveillance::getEpiweek();
		$years = Surveillance::getYears();
		$diseases = Diseases::getAllObjects();

		$data['epiweeks'] = $epiweeks;
		$data['provinces'] = $provinces;
		$data['years'] = $years;
		$data['diseases'] = $diseases;
		$data['scripts'] = array("FusionCharts/FusionCharts.js");
		$data['title'] = "System Home";
		$data['content_view'] = "home_v";
		$data['banner_text'] = "System Home";
		$data['link'] = "home";
		$this -> load -> view("template", $data);

	}

	function graph() {
		$counties = Province::getAll();
		$epiweeks = Surveillance::getEpiweek();
		$num = 0;
		$strXML = "<chart palette='2' showBorder='0' labelStep='5' caption='Disease Trends' shownames='1' showvalues='0' useRoundEdges='1' legendBorderAlpha='0' xAxisName='Epiweek' yAxisName='Deaths and Cases'>
               <categories>";
		foreach ($epiweeks as $epiweek) {
			$num++;
			$epi = $epiweek -> epiweek;
			$strXML .= "<category label='$epi'/>";
		}
		$strXML .= "</categories>
               <dataset seriesName='Consumed' color='AFD8F8' showValues='0'>";
		for ($i = 0; $i < $num; $i++) {
			$strXML .= "<set value='25601'/>";
		}
		$strXML .= "</dataset>
               <dataset seriesName='Stock' color='F6BD0F' showValues='0'>";
		for ($i = 0; $i < $num; $i++) {
			$strXML .= "<set value='41941'/>";
		}
		$strXML .= "</dataset>        
               </chart>";
		echo $strXML; 
	}

	function filter() {
		$epiweek = $_POST['epiweek'];
		$filterdyear = $_POST['filteryear'];
		$provinceId = $_POST['province'];
		$districtId = $_POST['districts'];
		
		$district = District::getName($districtId);
		$districtName = $district -> Name;
		
		$districts = District::getAll();
		$provinces = Province::getAll();
		$diseases = Diseases::getAllObjects();
		$years = Surveillance::getYears();

		$data['selected_epiweek'] = $epiweek;
		$data['provinces'] = $provinces;
		$data['districts'] = $districts;
		$data['years'] = $years;
		$data['diseases'] = $diseases;
		$data['districtName'] = $districtName;
		
		//missing value
		$data['values'] = $this -> getPerDistrict($districtId, $epiweek, $provinceId, $filterdyear);
		$data['content_view'] = 'submissions_distr_v';
		$this -> base_params($data);
	}

}
