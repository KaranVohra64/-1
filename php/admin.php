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

			include 'db_conn.php';
                        $pipe = new db_Conn();
        	?>
		<link rel="stylesheet" href="../../css/admin_styles.css">
		<link href='https://fonts.googleapis.com/css?family=Orbitron' rel='stylesheet'>
		<script src="../../scripts/admin_scripts.js"></script>
	</head>
	<body onload="init_sys_menu(); list_response('select-db', 't-menu'); display_menu_response(); init_query();">

		<div id="display-bg">
			<div id="display-interface">
				<div id="display-menu-wrapper">
					<div id="k-db" class="display-pair">
						<div class="d-button-rim">
							<div class="display-button db-active">a</div>
						</div>
						<div class="dl-base"></div>
						<div class="display-light dl-active"></div>
					</div>
					<div id='k-insp' class="display-pair">
						<div class="d-button-rim">
							<div class="display-button">b</div>
						</div>
						<div class="dl-base"></div>
						<div class="display-light"></div>
					</div>
					<div id='k-q' class="display-pair">
						<div class="d-button-rim">
							<div class="display-button">c</div>
						</div>
						<div class="dl-base"></div>
						<div class="display-light"></div>
					</div>
					<div class="display-pair">
						<div class="d-button-rim">
							<div class="display-button">d</div>
						</div>
						<div class="dl-base"></div>
						<div class="display-light"></div>
					</div>
				</div>
			</div>
		</div>

<!--........................................................-->

		<div id="content">
			<!--DATABASE MENU-->
			<div id="database-module" class="wrapper-1 static">
				<div class="sys-message">Select a Database:</div>
				<div class="sys-responder">
					<div id="select-db" class="sys-ul-options">
					<?php
                                                $pipe->describe_database_names();
                                        ?>
					</div>
				</div>
				<div class="sys-continue-button">&gt;</div>
			</div>

			<div id="inspector-module" class="wrapper-1 static">
				<div id="t-menu" class="module-group">
					<div class="sys-message">Tables:</div>
					<div class="sys-responder">
						<div id="select-t" class="sys-ul-options">
						
						</div>
					</div>
				</div>

				<!--DATABASE-->
				<div id="database" class="module-group">
					<div class="sys-message">Data:</div>
					<div id="db-content" class="sys-responder">
					
					</div>
				</div>
			</div>

			<!--QUERY-->
			<div id="query-module" class="wrapper-1 scalable">
				<div id="query-result">
					<div class="sys-message">Query Result:</div>
					<div id="q-results" class="sys-responder">
						<div style="width: 900px; height: 1000px;"></div>
					</div>
				</div>

				<div id="query">
					<div class="sys-message">Query:</div>
					<textarea name="q" class="sys-responder">Run query...</textarea>
					<div class="sys-continue-button">&gt;</div>
				</div>
			</div>
		</div>
	</body>
</html>
