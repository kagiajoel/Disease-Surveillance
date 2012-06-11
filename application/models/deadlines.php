<?php
class Deadlines extends Doctrine_Record{
	
	public function setTableDefinition(){
		$this -> hasColumn('Epiweek', 'int', 11);
		$this -> hasColumn('Deadline', 'varchar', 32);
	}//end setTableDefintion
	
	public function setUp(){
		$this -> setTableName('deadlines');
	}//end setUp
	
	public function getDeadlines(){
		$query = Doctrine_Query::create() -> select("epiweek, deadline") -> from("Deadlines");
		$deadline = $query -> execute();
		return $deadline;
	}
<<<<<<< HEAD
	
	public function tableLateReports(){
		$query = Doctrine_Query::create() -> select("Deadline,Date_Reported,Epiweek") -> from("Deadlines,Surveillance") -> where ("Surveillance.Reporting_Year = '$year' and Deadlines.Epiweek = Surveillance.Epiweek");
		$deadline = $query -> execute();
		return $deadline;
	}
=======
>>>>>>> 0660fa74c7ed283e265533d3b72412a63f14c082
		
}//end class
