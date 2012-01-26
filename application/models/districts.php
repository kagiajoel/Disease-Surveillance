<?php
class Districts extends Doctrine_Record {

	public function setTableDefinition() {
		$this -> hasColumn('Name', 'varchar', 100);
		$this -> hasColumn('Province', 'int', 14);
		$this -> hasColumn('Comment', 'varchar', 32);
		$this -> hasColumn('Flag', 'int', 32);
	}//end setTableDefinition

	public function setUp() {
		$this -> setTableName('districts');
		$this -> hasOne('Province as Province_Object', array('local' => 'Province', 'foreign' => 'id'));
	}//end setUp

	public function getAll() {
		$query = Doctrine_Query::create() -> select("*") -> from("Districts");
		$districtData = $query -> execute();
		return $districtData;
	}//end getAll

	public function getDistrict($id) {
		$query = Doctrine_Query::create() -> select("*") -> from("Districts") -> where("id = '$id'");
		$districtData = $query -> execute();
		return $districtData;
	}

	public function getSpecifiedDistrict($province) {
		$query = Doctrine_Query::create() -> select("*") -> from("Districts") -> where("id = '$province'");
		$specifiedDistrict = $query -> execute();
		return $specifiedDistrict;
	}

	public function getDistrictNames() {
		$queryDistricts = Doctrine_Query::create() -> select("name") -> from("Districts");
		$districtNames = $queryDistricts -> execute();
		return $districtNames;
	}//end getDistrictNames

	public static function getProvinceDistrict($id) {
		$query = Doctrine_Query::create() -> select("*") -> from("District") -> where("Province = '$id'");
		$districtData = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $districtData;
	}

}//end class
?>