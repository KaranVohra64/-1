<?php
	class db_Conn {

		protected $conn;
		
		public function __construct() {
			$this->conn = $this->db_login();
			//echo 'The class "' . __CLASS__ . '" was initiated!<br>';
		}

		public function __destruct(){	
        		//echo 'The class "' . __CLASS__ . '" was destroyed!'; 
    		} 

		private function db_login() {
		    $f = fopen("/var/www/html/bin/.dbkey", "r") or die("Unable to open file!");
                    $_pk = explode(" ", fgets($f));
                    fclose($f);  

		    $servername = "localhost";
		    $username = $_pk[0];
		    $password = str_replace(array("\n","\r"), '', $_pk[1]);

		    $c = new mysqli($servername, $username, $password);

		    // Check connection
		    if ($c->connect_error) {
		        die("Connection failed: " . $c->connect_error);
		    }else{
			    return $c;
		    }
		}

		private function get_tables($database_name) {
		    $sql = "SHOW TABLES FROM " . $database_name;
		    $result = mysqli_query($this->conn,$sql);
		    if ($result->num_rows > 0) {
		        return $result;
		    }else {
		        return null;
		    }
		}

		private function get_databases() {
			$sql = "SHOW DATABASES" . $database_name;
                        $result = mysqli_query($this->conn,$sql);
                        if ($result->num_rows > 0) {
                        	return $result;
                        }else {
                        	return null;
                        }
		}

		private function query_db($sql) {
                        $result = mysqli_query($this->conn,$sql);
                        if ($result->num_rows > 0) {
                                return $result;
                        } else {
                                return null;
                        }
                }

		public function get_last_id() {
			return $this->conn->insert_id;
		}

		public function send_insert($stmnt) {
			mysqli_query($this->conn,$stmnt);
		}

		public function describe_table_names($database_name) {
		    $table_names = $this->get_tables($database_name);
		    if (!($table_names == null)) {
		        while ($row = mysqli_fetch_array($table_names)) {
				echo "<div class='sys-ul-button'>" . $row[0] . "</div>";
			}
		    }else {
		        return "ERROR: no tables found";
		    }
		}

		public function describe_database_names() {
                    $database_names = $this->get_databases();
		    if (!($database_names == null)) {
			    while ($row = mysqli_fetch_array($database_names)) {
                                echo "<div class='sys-ul-button'>" . $row[0] . "</div>";
                        }
                    }else {
                        echo "ERROR: no tables found";
                    }
                }

		private function get_table_headers($database_name, $table_name) {
		    $sql = "SHOW COLUMNS FROM " . $database_name . "." . $table_name;
		    $result = mysqli_query($this->conn,$sql);
		    if ($result->num_rows > 0) {
		        return $result;
		    }else {
		        return null;
		    }
		}

		private function get_table_body($database_name, $table_name) {
		    $sql = "SELECT * FROM " . $database_name . "." . $table_name;
		    $result = $this->conn->query($sql);

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

		public function render_query_results($sql) {
			$raw = $this->query_db($sql);
			if($raw != null) {
				echo "<table id='t-data' class='t-init def-state'><tbody>";
				while($row = $raw->fetch_assoc()) {
                            		echo "<tr>";
                            		foreach ($row as $key => $value) {
                                		echo "<td>" . $value . "</td>";
                            		}
                            		echo "</tr>";
				}
				echo "</tbody></table>";
			}else {
				echo "No Results Found: " . $sql;
			}
		}
	}
?>
