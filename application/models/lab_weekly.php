<?php
class Lab_Weekly extends Doctrine_Record {

	public function setTableDefinition() {
		$this -> hasColumn('Epiweek', 'varchar', 32);
		$this -> hasColumn('Weekending', 'varchar', 100);
		$this -> hasColumn('District', 'varchar', 32);
		$this -> hasColumn('Facility', 'varchar', 11);
		$this -> hasColumn('Remarks', 'varchar', 50);
		$this -> hasColumn('Malaria_below_5', 'varchar', 32);
		$this -> hasColumn('Malaria_above_5', 'varchar', 32);
		$this -> hasColumn('Positive_below_5', 'varchar', 32);
		$this -> hasColumn('Positive_above_5', 'varchar', 32);
		$this -> hasColumn('Datecreated', 'varchar', 32);
		$this -> hasColumn('Reporting_Year', 'varchar', 10);
	}//end setTableDefinition

	public function setUp() {
		$this -> setTableName('lab_weekly');
		$this -> hasOne('District as District_Object', array('local' => 'District', 'foreign' => 'ID'));
		//$this -> hasOne('Facility as Facility_Id', array('local' => 'Facility', 'foreign' => 'Facility code'));
	}//end setUp

	public static function getRawData($year, $start_week, $end_week) {
		$query = Doctrine_Query::create() -> select("*") -> from("lab_weekly") -> where("Reporting_Year = '$year' and epiweek between '$start_week' and '$end_week'");
		$lab_data = $query -> execute();
		return $lab_data;
	}

	public static function getWeeklyLabData($year, $epiweek, $district) {
		$query = Doctrine_Query::create() -> select("Malaria_Below_5+Malaria_Above_5 as Tested, Positive_Below_5+Positive_Above_5 as Positive ") -> from("lab_weekly") -> where("Reporting_Year = '$year' and Epiweek = '$epiweek' and District = '$district'") -> limit(1);
		$lab_weekly = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $lab_weekly[0];
	}

	public static function getWeeklyLabSummaries($year, $epiweek) {
		$query = Doctrine_Query::create() -> select("sum(Malaria_Below_5+Malaria_Above_5) as Tested, sum(Positive_Below_5+Positive_Above_5) as Positive ") -> from("lab_weekly") -> where("Reporting_Year = '$year' and Epiweek = '$epiweek'");
		$lab_weekly = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);

		return $lab_weekly[0];
	}

	public static function getAnnualLabSummaries($year) {
		$query = Doctrine_Query::create() -> select("sum(Malaria_Below_5+Malaria_Above_5) as Tested, sum(Positive_Below_5+Positive_Above_5) as Positive ") -> from("lab_weekly") -> where("Reporting_Year = '$year'");
		$lab_weekly = $query -> execute(array(), Doctrine::HYDRATE_ARRAY);
		return $lab_weekly[0];
	}

}//end class
?>