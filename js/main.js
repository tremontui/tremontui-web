function GetAsynch( url, params ){
	return new Promise(function(resolve, reject){
		var request = new XMLHttpRequest();
		request.open("GET", url + params, false);
		request.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
		//request.withCredentials = true;
		
		request.onload = function(){
			if(request.status == 200){
				resolve(request.response);
			} else {
				reject(Error(request.statusText));
			}

		};
		
		request.onerror = function( e ){
			reject(Error("Network Error: " + e.target.status));
		};
		
		request.send();
	});
}

function PostAsynch( url, params ){
	return new Promise( function( resolve, reject ){
		var request = new XMLHttpRequest();
		request.open("POST", url, true);
		request.setRequestHeader( 'Content-Type', 'application/x-www-form-urlencoded' );
		
		request.onload = function(){
			if(request.status == 200){
				resolve(request.response);
			} else {
				reject(Error(request.statusText));
			}
		};
		
		request.onerror = function(){
			reject(Error("Network Error"));
		};
		
		request.send( params );
	});
}
