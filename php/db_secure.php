<?php
    class db_Secure {

        private $conn;

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

            $this->$conn = new mysqli($servername, $username, $password);

            // Check connection
            if ($this->$conn->connect_error) {
                die("Connection failed: " . $this->$conn->connect_error);
            }
        }

        public function verify_session($input_id) {
            $database_name = "dev_testing_environment";
            $table_name = "user_authentication";

            $sql = "SELECT uid FROM " . $database_name . "." . $table_name . " WHERE id=" . $input_id;
            $result = mysqli_query($this->$conn,$sql);
            if ($result->num_rows > 0) {
                $dat = mysqli_fetch_array($result);
                session_start();
                if(isset($_SESSION['user']) && $_SESSION['user'] == $dat[0]) {
                    return 1;
                }else {
                    //echo "your username or password was incorrect...";
                    return 0;
                }
            }else {
                //echo "your username or password was incorrect...";
                return 0;
            }
        }

        public function verify_hash($input_id, $input_password) {
            $database_name = "dev_testing_environment";
            $table_name = "user_authentication";

            $sql = "SELECT hash_key, uid, id FROM " . $database_name . "." . $table_name . " WHERE username='" . $input_id . "'";
            $result = mysqli_query($this->$conn,$sql);
            if ($result->num_rows > 0) {
                $dat = mysqli_fetch_array($result);
                //echo $dat . "<br>" . $dat[0] . "<br>" . $dat[1];
                if(password_verify($input_password, $dat[0])) {
                        //echo "100% Match!!";
                        session_start();
                        $_SESSION['user'] = $dat[1];
                        return $dat[2];
                }else {
                    //echo "your username or password was incorrect...";
                    return -1;
                }
            }else {
                //echo "your username or password was incorrect...";
                return -1;
            }
        }
    }
?>
