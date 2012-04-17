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

		$epiweek = $_POST['epiweek'];
		$province = $_POST['province'];
		$year = $_POST['year'];

		$provinces = Province::getAll();
		$epiweeks = Surveillance::getEpiweek();
		$years = Surveillance::getYears();

		$data['epiweeks'] = $epiweeks;
		$data['provinces'] = $provinces;
		$data['years'] = $years;
		$data['scripts'] = array("FusionCharts/FusionCharts.js");
		$data['title'] = "System Home";
		$data['content_view'] = "home_v";
		$data['banner_text'] = "System Home";
		$data['link'] = "home";
		$this -> load -> view("template", $data);

	}

	function graph() {
		$counties = Province::getAll();
		$num = 0;
		$strXML = "<chart palette='2' caption='County Comparison' shownames='1' showvalues='0' numberPrefix='\$' useRoundEdges='1' legendBorderAlpha='0'>
               <categories>";
		foreach ($counties as $counties) {
			$num++;
			$county = $counties -> Name;
			$strXML .= "<category label='$county'/>";
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

}
