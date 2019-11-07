<?php
	include 'db_conn.php';
	$pipe = new db_Conn();
	if($_GET['m'] == 't') {
		echo $pipe->describe_table_names($_GET['db']);
	}else if($_GET['m'] == 'db') {
		echo $pipe->describe_table($_GET['db'], $_GET['t']);
	}else if($_GET['m'] == 'q') {
		echo $pipe->render_query_results(urldecode($_GET['q']));
	}
?>
