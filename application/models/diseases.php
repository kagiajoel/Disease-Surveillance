<?php
class Diseases extends Doctrine_Record{
	
	public function setTableDefinition(){
		$this -> hasColumn('Name', 'varchar', 100);
		$this -> hasColumn('Type', 'int', 32);
		$this -> hasColumn('Flag', 'int', 1);
	}//end setTableDefinition
	
	public function setUp(){
		$this -> hasTableName("diseases");
	}//end setUp
	
	public function getDiseaseData(){
		
	}
}

?>