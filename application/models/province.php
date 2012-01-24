<?php
class Province extends Doctrine_Record {

	public function setTableDefinition() {
		$this -> hasColumn('Name', 'varchar', 100);
	}//end setTableDefinition

	public function setUp() {
		$this -> setTableName('provinces');
	}//end setUp

	public function getAll() {
		$query = Doctrine_Query::create() -> select("ID, name") -> from("province");
		$provinceData = $query -> execute();
		return $provinceData;
	}//end getAll
	
	public function getProvinceNames() {
		$queryProvinces = Doctrine_Query::create() -> select("name") -> from("province");
		$provinceNames = $queryProvinces -> execute();
		return $provinceNames;
	}//end getProvinceNames

}//end class
?>