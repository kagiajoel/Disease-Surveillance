<?php
class District extends Doctrine_Record {

	public function setTableDefinition() {
		$this -> hasColumn('Name', 'varchar', 100);
		$this -> hasColumn('Province', 'int', 14);
		$this -> hasColumn('Comment', 'varchar', 32);
		$this -> hasColumn('Flag', 'int', 32);
<<<<<<< HEAD
		//$this -> hasColumn('Latitude', 'varchar', 100);
		//$this -> hasColumn('Longitude', 'varchar', 100);
		//$this -> hasColumn('Disabled', 'varchar', 1);
=======
		$this -> hasColumn('Latitude', 'varchar', 100);
		$this -> hasColumn('Longitude', 'varchar', 100);
		$this -> hasColumn('Disabled', 'varchar', 1);
>>>>>>> 0660fa74c7ed283e265533d3b72412a63f14c082
	}//end setTableDefinition

	public function setUp() {
		$this -> setTableName('districts');
		$this -> hasOne('Province as Province_Object', array('local' => 'Province', 'foreign' => 'id'));
		$this -> hasOne('Surveillance as Surveillance', array('local' => 'id', 'foreign' => 'District'));
	}//end setUp

	public function getAll() {
<<<<<<< HEAD
		$query = Doctrine_Query::create() -> select("*") -> from("District")->OrderBy("Name asc");
=======
		$query = Doctrine_Query::create() -> select("*") -> from("District")->where("Disabled = '0'")->OrderBy("Name asc");
>>>>>>> 0660fa74c7ed283e265533d3b72412a63f14c082
		$districtData = $query -> execute();
		return $districtData;
	}//end getAll

	public function getDistrict($id) {
		$query = Doctrine_Query::create() -> select("*") -> from("District") -> where("id = '$id'");
		$districtData = $query -> execute();
		return $districtData;
	}

	public static function getProvinceDistrict($id) {
<<<<<<< HEAD
		$query = Doctrine_Query::create() -> select("*") -> from("District") -> where("Province = '$id'");
=======
		$query = Doctrine_Query::create() -> select("*") -> from("District") -> where("Province = '$id' and Disabled = '0'");
>>>>>>> 0660fa74c7ed283e265533d3b72412a63f14c082
		$districtData = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $districtData;
	}

	public static function getDNRDistricts($year, $epiweek) {
<<<<<<< HEAD
		$query = Doctrine_Query::create() -> select("d.Name, d.Province") -> from("district d") -> leftJoin("d.Surveillance s on d.id = s.district and reporting_year = '$year' and epiweek = '$epiweek'") -> where("s.district is null");
=======
		$query = Doctrine_Query::create() -> select("d.Name, d.Province") -> from("district d") -> leftJoin("d.Surveillance s on d.id = s.district and reporting_year = '$year' and epiweek = '$epiweek'") -> where("s.district is null and d.Disabled = '0'");
>>>>>>> 0660fa74c7ed283e265533d3b72412a63f14c082
		$districts = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $districts;
	}

	public function getName($districtId) {
		$query = Doctrine_Query::create() -> select("Name") -> from("district") -> where(" id = '$districtId'");
		$results = $query -> execute();
		return $results[0];
	}

	public function getNameAndId($provinceId) {
		$query = Doctrine_Query::create() -> select("*") -> from("district") -> where("Province = '$provinceId'");
		$results = $query -> execute();
		return $results;
	}
	public static function getTotalNumber() {
<<<<<<< HEAD
		$query = Doctrine_Query::create() -> select("COUNT(*) as Total_Districts") -> from("District");
=======
		$query = Doctrine_Query::create() -> select("COUNT(*) as Total_Districts") -> from("District")->where("Disabled = '0'");
>>>>>>> 0660fa74c7ed283e265533d3b72412a63f14c082
		$count = $query -> execute();
		return $count[0] -> Total_Districts;
	}

	public function getPagedDistricts($offset, $items) {
<<<<<<< HEAD
		$query = Doctrine_Query::create() -> select("*") -> from("District") -> orderBy("name") -> offset($offset) -> limit($items);
=======
		$query = Doctrine_Query::create() -> select("*") -> from("District") ->where("Disabled = '0'")-> orderBy("name") -> offset($offset) -> limit($items);
>>>>>>> 0660fa74c7ed283e265533d3b72412a63f14c082
		$districts = $query -> execute();
		return $districts;
	}

}//end class
?>