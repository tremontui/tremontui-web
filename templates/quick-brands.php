<form method="post" id="add-quick-brand">
	<input name="brand_name" placeholder="New Quick Brand. . .">
	<input type="submit" value="Add Quick Brand" formaction="brand_manage/quick_brand">
</form>

<div id="quick-brands">
	<?php
		$qb = json_decode( $quick_brands, true );
		foreach( $qb as $quick_brand ){
			$brand_name = $quick_brand['Brand_Name'];
			
			$html = '<div class="qb-box" id="qb-' . $brand_name . '"><h6>' . $brand_name . '</h6><input type="button" value="delete" onclick="Delete_QuickBrand(' . "'" . $brand_name . "'" . ')"/></div>';
			echo $html;
		}
	
	?>
</div>

<script>
var api_config = <?php echo $api_config?>;
var brands = <?php echo $quick_brands?>;
var uri = api_config['home'];

window.onload = function(){

	for( var i = 0, brands_max = brands.length; i < brands_max; i++ ){
		
		var brand_name = brands[i]['Brand_Name'];
		var qb_div = document.getElementById( 'qb-' + brand_name );
		console.log( brand_name );
		GetQuickBrandOverview( uri, qb_div, brand_name );
		
	}
	
}

function Delete_QuickBrand( brand_name ){
	console.log('DELETING: ' + brand_name);
	GetAsynch( uri  + 'brand_manage/quick_brand/delete', '?brand_name=' + escape( brand_name ) ).then(
		function( response ){
			var js_response = JSON.parse( response );
			console.log( js_response );
			location.reload();
		},
		function( error ){
			console.log( error );
		}
	);
}

function GetQuickBrandOverview( uri, parentdiv, brand_name ){
	GetAsynch( uri  + 'api/brands_canonical', '?brand_name=' + escape( brand_name ) ).then(
		function( response ){
			var js_response = JSON.parse( response );
			console.log( js_response );
			Insert_QuickBrand( parentdiv, brand_name, js_response['result'][0] );
		},
		function( error ){
			console.log( error );
		}
	);
}

function Insert_QuickBrand( parentdiv, brand_name, col_data ){
	var table = document.createElement( 'table' );
	
	var tr1 = document.createElement( 'tr' );
	var th1 = document.createElement( 'th' );
	th1.innerHTML = 'Qty';
	var th2 = document.createElement( 'th' );
	th2.innerHTML = 'Value';
	tr1.appendChild( th1 );
	tr1.appendChild( th2 );
	
	var tr2 = document.createElement( 'tr' );
	var c1 = document.createElement( 'td' );
	c1.innerHTML = col_data['Quantity'];
	var c2 = document.createElement( 'td' );
	c2.innerHTML = col_data['Value'];
	tr2.appendChild( c1 );
	tr2.appendChild( c2 );
	
	table.appendChild( tr1 );
	table.appendChild( tr2 );
	
	parentdiv.appendChild( table );
}
</script>