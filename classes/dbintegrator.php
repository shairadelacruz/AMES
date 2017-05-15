<?php

class dbintegrator {

	public $debug_on = false;

	//CHANGE THE FOLLOWING VALUES BASED ON YOUR DATABASE SETTINGS
	private $username = "root";
	private $password = "";
	private $database = "dbaccounting";
	public $conn;
	
	public function __construct(){
		$this->connect();
		$this->close();
	}	

	private function connect(){
		//This is the main connection
		$this->conn = new mysqli("localhost",$this->username,$this->password,$this->database);

		//Test the connection
		if($this->conn->connect_error){
			die("Connection Failed: " . $conn->connect_error);
		}

		if($this->debug_on)
			echo "Databse connected. <br />";
	}

	private function close(){
		$this->conn->close();
	}

	public function getFields(){
		if($this->debug_on) {
			echo $this->username.":".
				  $this->password.":".
				  $this->database."<br />";
		}
	}

	public function execute($sqlstatement){
		$this->connect();

		if($this->conn->query($sqlstatement) === true){
			echo "Successfully executed the query.";
		} else {
			echo "Error: " . $sqlstatement . "<br>" . $this->conn->error;
		}

		$this->close();		
	}

	public function executemultiple($sqlstatement){
		/*$sql = "INSERT INTO MyGuests (firstname, lastname, email)
		VALUES ('John', 'Doe', 'john@example.com');";
		$sql .= "INSERT INTO MyGuests (firstname, lastname, email)
		VALUES ('Mary', 'Moe', 'mary@example.com');";
		$sql .= "INSERT INTO MyGuests (firstname, lastname, email)
		VALUES ('Julie', 'Dooley', 'julie@example.com')";*/

		$this->connect();

		if($this->conn->multi_query($sqlstatement) === true){
			if($this->debug_on) echo "Successfully executed multiple queries.";
		} else {
			echo "Error: " . $sqlstatement . "<br>" . $this->conn->error;
		}

		$this->close();		
	}

	public function select($sqlstatement){
		$this->connect();

		$result = $this->conn->query($sqlstatement);
		$resulttable = array();


		if(!is_bool($result) && $result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				array_push($resulttable, $row);
			}

			return $resulttable;

		}else {
			return $resulttable = 0;
		}

		$this->close();		
	}

}//end of class"
?>