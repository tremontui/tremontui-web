<table id="user_table">
	<tr>
		<th>
			ID
		</th>
		<th>
			Username
		</th>
		<th>
			First Name
		</th>
		<th>
			Last Name
		</th>
		<th>
			Email
		</th>
	</tr>
</table>

<script>
window.onload = function(){
	var api_config = <?php echo $api_config?>;

	var table = document.getElementById( 'user_table' ).getElementsByTagName( 'tbody' )[0];
	
	var uri = api_config['home'] + 'api/users';
	
	GetAsynch( uri, '' ).then(
		function( response ){
			var js_reponse = JSON.parse( response );
			console.log( js_reponse );
			for( var i = 0, max_i = js_reponse.length; i < max_i; i++ ){
				InsertRow_User_Table( table, js_reponse[i] );
			}
		},
		function( error ){
			console.log( error );
		}
	)
	
	function InsertRow_User_Table( tbody, colData ){
		var row = document.createElement( 'tr' );
		var c1 = document.createElement( 'td' );
		c1.innerHTML = colData['ID'];
		var c2 = document.createElement( 'td' );
		c2.innerHTML = colData['Username'];
		var c3 = document.createElement( 'td' );
		c3.innerHTML = colData['First_Name'];
		var c4 = document.createElement( 'td' );
		c4.innerHTML = colData['Last_Name'];
		var c5 = document.createElement( 'td' );
		c5.innerHTML = colData['Email'];
		
		row.appendChild( c1 );
		row.appendChild( c2 );
		row.appendChild( c3 );
		row.appendChild( c4 );
		row.appendChild( c5 );
		tbody.appendChild( row );
	}
}
</script>