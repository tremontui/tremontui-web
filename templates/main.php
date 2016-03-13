<!DOCTYPE html>
<html>
	<title>
		<?php 
			//TITLE NAME
		?>
	</title>
	<link rel="stylesheet" href="templates/style/<?php //THEME NAME ?>theme-base.css">
	<link rel="stylesheet" href="templates/style/<?php //THEME NAME ?>theme-base-responsive.css">
<head>
</head>
<body>
	<div id="main-header">
		<h2>
			TREMONT UI
		</h2>
	</div>
	<div id="wrapper">
		<?php
			//foreach include for all forms and modules to include on page
			foreach( $modules as $module ){
				include "$module.php";
			}
		?>
	</div>
</body>
</html>