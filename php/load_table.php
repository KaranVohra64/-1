<?php
	include 'db_conn.php';

	$table_name = $_REQUEST["q"];

	$pipe = new db_Conn();
	$pipe->describe_table("dev_testing_environment", $table_name);
?>
