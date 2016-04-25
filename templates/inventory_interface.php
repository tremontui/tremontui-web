<!DOCTYPE html>
<html>
	<title>
		<?php 
			//Title Var from args['title'] as $title
			echo $title;
		?>
	</title>
	<link rel="stylesheet" href="/templates/style/<?php //THEME NAME ?>theme-base.css">
	<link rel="stylesheet" href="/templates/style/<?php //THEME NAME ?>theme-base-responsive.css">
	<script src="/js/main.js"></script>
	<script src="/js/Promise.min.js"></script>
<head>
</head>
<body>
	<div id="wrapper">
		<div id="main-header">
			<h1>
				<a href="/">
					TREMONT UI
				</a>
			</h1>
			<?php
				if( isset($_SESSION['user_details'] ) ){
					$user = $_SESSION['user_details'];
					$f_name = ucwords( $user->First_Name );
					$l_name = ucwords( $user->Last_Name );
					$username = $user->Username;
					$user_id = $user->User_ID;
					$docs = '<a href="/documentation">docs</a>';
					$logoff = '<a href="/logoff">logoff</a>';
					echo "<h6>$f_name $l_name ($username) $user_id $logoff $docs</h6>";
				}
			?>
		</div>
		
		<div id="inventory_interface_wrapper">
			<input type="button" value="New Task" onclick="CreateNewTask()">
			<input type="button" value="Load Task">
			<div id="inventory_interface_grid">
				<div id="ii_scaffold">
				</div>
			</div>
		</div>
		
	</div>
</body>
</html>

<script>
var api_config = <?php echo $api_config?>;
var uri = api_config['home'];

window.onload = function(){
	
}

function CreateNewTask(){
	var data = {
		task_type:'RECEIVING'
	};
	
	var paramsString = encodeURIComponent( JSON.stringify( data ) );
	console.log( paramsString.length );
	PostAsynch( uri + 'api/inventory_tasks', 'data=' + paramsString ).then(
		function( response ){
			var js_reponse = JSON.parse( response );
			console.log( js_reponse );
		},
		function( error ){
			console.log( error );
		}
	);
}

function InstantateScaffold( colLen, rowLen ){
		
		var ii_scaffold = document.getElementById('ii_scaffold');
		
	
}

function InsertRow( colLen ){
	
}

function InsertColumn( rowLen ){
	
}

</script>
