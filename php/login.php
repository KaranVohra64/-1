<!DOCTYPE html>
<html>
	<head>
		<title>t_LOGIN</title>
	</head>
	<body>
		<?php
			
			include 'db_secure.php';
			
			$guard = new db_Secure();
			$id = $guard->verify_hash($_POST["Username"], $_POST["Password"]);
			if ($id != -1) {
				header("Location: admin.php/?id=" . $id);	
			}else {
				header("Location: ../index.html");  
			}
		?>    
	</body>	
</html>
