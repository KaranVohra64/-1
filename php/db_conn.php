<?php
	class db_Conn {

		private $conn;
		
		public function __construct() {
			$this->conn = $this->db_login();
			//echo 'The class "' . __CLASS__ . '" was initiated!<br>';
		}

		public function __destruct(){ 
        		//echo 'The class "' . __CLASS__ . '" was destroyed!'; 
    		} 

		private function db_login() {
		    $f = fopen(".dbkey", "r") or die("Unable to open file!");
                    $_pk = explode(" ", fgets($f));
                    fclose($f);  

		    $servername = "localhost";
		    $username = $_pk[0];
		    $password = str_replace(array("\n","\r"), '', $_pk[1]);

		    $this->$conn = new mysqli($servername, $username, $password);

		    // Check connection
		    if ($this->$conn->connect_error) {
		        die("Connection failed: " . $this->$conn->connect_error);
		    }
		}

		private function get_tables($database_name) {
		    $sql = "SHOW TABLES FROM " . $database_name;
		    $result = mysqli_query($this->$conn,$sql);
		    if ($result->num_rows > 0) {
		        return $result;
		    }else {
		        return null;
		    }
		}

		public function describe_table_names($database_name) {
		    $table_names = $this->get_tables($database_name, $this->$conn);
		    $t_name;
		    
		    if (!($table_names == null)) {
			echo "<div class='t-wrapper'>";
			echo "<table id='t-list' class='t-init'><tbody>";
			echo "<tr><th>Table Names:</th></tr>";

			$trig = 1;
		        while ($row = mysqli_fetch_array($table_names)) {
				if($trig == 0) {
					echo "<tr class='def-state'>";
				}else {
					echo "<tr class='def-state active'>";
					$trig = 0;
					$t_name=$row[0];
				}	     
			        echo "<td> > " . $row[0] . "</td>";
		                echo "</tr>";
		        }
			echo "</tbody></table>";
			echo "</div>";
			return $t_name;
		    }else {
		        echo "ERROR: no tables found";
		    }
		}

		private function get_table_headers($database_name, $table_name) {
		    $sql = "SHOW COLUMNS FROM " . $database_name . "." . $table_name;
		    $result = mysqli_query($this->$conn,$sql);
		    if ($result->num_rows > 0) {
		        return $result;
		    }else {
		        return null;
		    }
		}

		private function get_table_body($database_name, $table_name) {
		    $sql = "SELECT * FROM " . $database_name . "." . $table_name;
		    $result = $this->$conn->query($sql);

		    if ($result->num_rows > 0) {
		        return $result;
		    } else {
		        return null;
		    }

		}

		 public function describe_table($database_name, $table_name) {
		    
		    echo "<table id='t-data' class='t-init def-state'><tbody>";
		    $headers = $this->get_table_headers($database_name, $table_name);

		    if (!($headers == null)) {
		        echo "<tr>";
		        while($row = mysqli_fetch_array($headers)){
		            echo "<th>" . $row['Field'] . "</th>";
		        }
		        echo "</tr>";
		    }else {
		        echo "ERROR: no headers found";
		    }

		    $body = $this->get_table_body($database_name, $table_name);

		    if (!($body == null)) {
		        while($row = $body->fetch_assoc()) {
		            echo "<tr>";
		            foreach ($row as $key => $value) {
		                echo "<td>" . $value . "</td>";
		            }
		            echo "</tr>";
		        }
		    }else {
		        echo "ERROR: no body found";
		    }
		    echo "</tbody></table>";
		}
	}
?>
