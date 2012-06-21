<?php
class Facilities extends Doctrine_Record {
	public function setTableDefinition() {
		$this -> hasColumn('facilitycode', 'int', 32);
		$this -> hasColumn('Name', 'varchar', 100);
		$this -> hasColumn('facilitytype', 'varchar', 5); 
		$this -> hasColumn('District', 'varchar', 5);
		$this -> hasColumn('flag', 'varchar', 2);
		$this -> hasColumn('email', 'varchar', 50);
		$this -> hasColumn('phone', 'varchar', 50);
	}

	public function setUp() {
		$this -> setTableName('facilities');
		$this -> hasOne('Districts as Parent_District', array('local' => 'District', 'foreign' => 'id'));
		$this -> hasOne('Facility_Types as Type', array('local' => 'facilitytype', 'foreign' => 'id'));
	}

	public function getDistrictFacilities($district) {
		$query = Doctrine_Query::create() -> select("facilitycode,Name") -> from("Facilities") -> where("District = '" . $district . "'");
		$facilities = $query -> execute();
		return $facilities;
	}

	public function getAll() {
		$query = Doctrine_Query::create() -> select("*") -> from("Facilities");
		$facilities = $query -> execute();
		return $facilities;
	}
	
	public function getFacility($id) {
		$query = Doctrine_Query::create() -> select("*") -> from("Facilities") -> where("id = '$id'");
		$facilityData = $query -> execute();
		return $facilityData;
	}
	
	public static function search($search) {
		$query = Doctrine_Query::create() -> select("facilitycode,Name") -> from("Facilities") -> where("Name like '%" . $search . "%'");
		$facilities = $query -> execute();
		return $facilities;
	}

	public static function getFacilityName($facility_code) {
		$query = Doctrine_Query::create() -> select("Name") -> from("Facilities") -> where("facilitycode = '$facility_code'");
		$facility = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $facility[0]['Name'];
	}

	public static function getTotalNumber($district = 0) {
		if ($district == 0) {
			$query = Doctrine_Query::create() -> select("COUNT(*) as Total_Facilities") -> from("Facilities");
		} else if ($district > 0) {
			$query = Doctrine_Query::create() -> select("COUNT(*) as Total_Facilities") -> from("Facilities") -> where("District = '$district'");
		}
		$count = $query -> execute();
		return $count[0] -> Total_Facilities;
	}

	public function getPagedFacilities($offset, $items, $district = 0) {
		if ($district == 0) {
			$query = Doctrine_Query::create() -> select("*") -> from("Facilities") -> orderBy("Name") -> offset($offset) -> limit($items);
		} else if ($district > 0) {
			$query = Doctrine_Query::create() -> select("*") -> from("Facilities") -> where("District = '$district'") -> orderBy("Name") -> offset($offset) -> limit($items);
		}

		$facilities = $query -> execute();
		return $facilities;
	}

}
