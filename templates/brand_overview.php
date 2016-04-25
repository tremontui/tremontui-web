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
		<?php
			include "brand_ticker.php";
			include "brand_items.php";
		?>
	</div>
</body>
</html>

<script>
var api_config = <?php echo $api_config?>;
var brand_name = '<?php echo $brand_name?>';
var uri = api_config['home'];

window.onload = function(){
	var brand_can_value = document.getElementById( 'canonical-value' );
	var brand_can_quantity = document.getElementById( 'canonical-quantity' );
	var brand_items = document.getElementById( 'brand_items' );
	
	GetBrand( brand_can_value, brand_can_quantity, brand_name );
	PopulateBrandItems( brand_items,brand_name );
	
}

function GetBrand( brand_can_value, brand_can_quantity, brand_name ){
	
	GetAsynch( uri  + 'api/brands_canonical', '?brand_name=' + brand_name ).then(
		function( response ){
			var js_reponse = JSON.parse( response );
			console.log( js_reponse );
			brand_can_value.innerHTML = js_reponse['result']['0']['Value'];
			brand_can_quantity.innerHTML = js_reponse['result']['0']['Quantity'];
		},
		function( error ){
			console.log( error );
		}
	);
	
}

function PopulateBrandItems( brand_items, brand_name ){
	
	GetAsynch( uri  + 'api/brand_items', '?brand_name=' + brand_name ).then(
		function( response ){
			var js_response = JSON.parse( response );
			console.log( js_response );
			var result = js_response['result'];
			
			for(var i = 0, result_length = result.length; i < result_length; i++ ){
				var item_data = result['i'];
				InsertBrandItem( brand_items, item_data );
			}
			
		},
		function( error ){
			console.log( error );
		}
	);
	
}

function InsertBrandItem( brand_items, brand_item ){
	
	var div = document.createElement( 'div' );
	div.className = 'brand_item';
	
	brand_items.appendChild( div );
}

</script>
