<!DOCTYPE html>
<html>
	<title>
		<?php 
			//Title Var from args['title'] as $title
			echo $title;
		?>
	</title>
	<link rel="stylesheet" href="templates/style/<?php //THEME NAME ?>theme-base.css">
	<link rel="stylesheet" href="templates/style/<?php //THEME NAME ?>theme-base-responsive.css">
	<script src="js/main.js"></script>
<head>
</head>
<body>
	<div id="wrapper">
		<div id="main-header">
			<h1>
				TREMONT UI
			</h1>
			<?php
				if( isset($_SESSION['user_details'] ) ){
					$user = $_SESSION['user_details'];
					$f_name = ucwords( $user->First_Name );
					$l_name = ucwords( $user->Last_Name );
					$username = $user->Username;
					$user_id = $user->User_ID;
					echo "<h6>$f_name $l_name ($username) $user_id</h6>";
				}
			?>
		</div>
		<?php
			//foreach include for all forms and modules to include on page
			if( isset( $modules ) ){
				foreach( $modules as $module ){
					include "$module.php";
				}
			}
		?>
	</div>
</body>
</html>