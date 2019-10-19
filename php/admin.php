<!DOCTYPE html>
<html>
	<head>
		<title> input_encoding </title>
		<?php
			include 'db_secure.php';
			
			$guard = new db_Secure();
                        if($guard->verify_session($_GET["id"]) == 0) {
                	       header("Location: ../../index.html");
                	}
		?>

		<link rel="stylesheet" type="text/css" href="../../css/db_styles.css">
		<script src="../../scripts/db_script.js"></script>
	</head>
	<body onload="tn_menu_selector();">
		<?php
                	include 'db_conn.php';
			$pipe = new db_Conn();
			$table_name = $pipe->describe_table_names('dev_testing_environment'); 
			echo "<div class='t-wrapper' id='d-dyn'>";
                        	$pipe->describe_table("dev_testing_environment", $table_name);
			echo "</div>";
		?>
	</body>
</html>
