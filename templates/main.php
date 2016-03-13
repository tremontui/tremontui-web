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
<head>
</head>
<body>
	<div id="wrapper">
		<div id="main-header">
			<h1>
				TREMONT UI
			</h1>
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