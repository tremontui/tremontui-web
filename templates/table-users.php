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
<div class="blurb-mod">
	<h3>
		New User
	</h3>
	<form id="new_user_form">
		<p class="error"></p>
		<input name="username" placeholder="Username. . .">
		<input type="password" name="password" placeholder="Password. . .">
		<input type="password" name="password2" placeholder="Confirm Password. . .">
		<input name="f_name" placeholder="First Name. . .">
		<input name="l_name" placeholder="Last Name. . .">
		<input type="email" name="email" placeholder="Email. . .">
		<input type="button" onclick="AddUser( username.value, f_name.value, l_name.value, email.value, password.value, password2.value )" value="Add User">
	</form>
</div>


<script>
var api_config = <?php echo $api_config?>;
var uri = api_config['home'];

window.onload = function(){

	var table = document.getElementById( 'user_table' ).getElementsByTagName( 'tbody' )[0];
	
	GetAllUsers( uri, table );
	
}

function AddUser( username, f_name, l_name, email, password, password2 ){
	var form = document.getElementById( 'new_user_form' );
	var error = form.getElementsByClassName( 'error' )[0];
	
	if( username != '' && f_name != '' && l_name != '' && email != '' && password != '' && password2 != '' ){
		
		if( password != password2 ){
			
			error.innerHTML = "Must Provide Matching Passwords";
			
		} else {
			
			var email_pattern = /[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$/;
			
			if( !email_pattern.test( email ) ){
				
				error.innerHTML = "Must Provide valid email";
				
			} else {
				
				error.innerHTML = '';
				
				var userData = {
					username:username,
					f_name:f_name,
					l_name:l_name,
					email:email,
					password:password
				};
				
				PostNewUser( userData );
				
			}
			
		}
		
	} else {

		error.innerHTML = "All Fields Required";
		
	}
}

function PostNewUser( userData ){
	
	var paramsString = encodeURIComponent( JSON.stringify( userData ) );
	console.log( paramsString.length );
	PostAsynch( uri + 'api/users', 'userData=' + paramsString ).then(
		function( response ){
			var js_reponse = JSON.parse( response );
			console.log( js_reponse );
			if( js_reponse['api_success'] == 'true' ){
				location.reload();
			}
		},
		function( error ){
			console.log( error );
		}
	);
	
}

function GetAllUsers( uri, table ){
	GetAsynch( uri  + 'api/users', '' ).then(
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
	);
}

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
</script>