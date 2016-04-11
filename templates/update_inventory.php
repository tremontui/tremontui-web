<input type="button" value="Initialize Items" onclick="update_item_initializations()">
<input type="button" value="Update Items" onclick="update_all_items()">

<div id="">

</div>

<script>
var api_config = <?php echo $api_config?>;
var uri = api_config['home'];

function update_all_items(){
	var item_count;
	var update_rounds;
	var items_per_update = 25;
	var rounds_complete = 0;
	
	GetAsynch( uri  + 'items/count', '' ).then(
		function( response ){
			var js_response = JSON.parse( response );
			console.log( js_response );
			item_count = js_response['result'][0]['Count'];
			update_rounds = Math.ceil( ( item_count / items_per_update ) );
			console.log( update_rounds );
			/*for( var i = 0; i < update_rounds; i++ ){
				console.log('queuing round: ' + i);
				setTimeout( function(){console.log(i)}, 2000 );
			}*/
			
			var queued_rounds = 0;
			(function run_queue(i){
				setTimeout( function(){
					console.log( 'queuing round: ' + queued_rounds );
					queued_rounds++;
					send_item_update( rounds_complete );
					if(--i) run_queue(i);
				}, 1500)
			})(update_rounds);
			
		},
		function( error ){
			console.log( error );
		}
	);
}

function send_item_update( rounds_complete ){
	GetAsynch( uri  + 'items/update_round', '' ).then(
		function( response ){
			var js_response = JSON.parse( response );
			console.log( js_response );
			rounds_complete++;
			console.log( 'round complete: ' + rounds_complete );
		},
		function( error ){
			console.log( error );
		}
	);
}

function update_item_initializations(){
	var all_items = [];
	
	GetAsynch( uri  + 'channel_advisor/base_items', '' ).then(
		function( response ){
			var js_response = JSON.parse( response );
			for( var i = 0, js_response_length = js_response.length; i < js_response_length; i++ ){
				var page = js_response[i];
				for( var x = 0, page_length = page.length; x < page_length; x++ ){
					var product = page[x];
					all_items.push(product);
				}
			}
			var interval = 0;
			var interval_max = 1000;
			var set_i = 0;
			var set = [[]];
			for( var i = 0, all_items_length = all_items.length; i < all_items_length; i++ ){
				var item = all_items[i];
				if( interval < interval_max && i != all_items_length ){
					set[set_i].push(item);
					interval++;
				} else if ( interval = interval_max || i == all_items_length ){
					set[set_i].push(item);
					interval = 0;
					set_i++;
					set.push([]);
				}
			}
			for( var i = 0, sets_length = set.length; i < sets_length; i++ ){
				var current_set = set[i];
				initialize_item_bundle( current_set );
			}
			//console.log( all_items );
		},
		function( error ){
			console.log( error );
		}
	);
}

function initialize_item_bundle( set ){
	//var arr = ['test','test1','test2','test3'];
	var params = set.reduce(function(o, v, i){
		o[i] = v;
		return o;
	},{});
	//var params = {1:'test',2:'test1'};
	var paramsString = encodeURIComponent(JSON.stringify(params));
	PostAsynch( uri  + 'initialize_items', 'items=' + paramsString ).then(
		function( response ){
			var js_response = JSON.parse( response );
			console.log( js_response );
		},
		function( error ){
			console.log( error );
		}
	);
}

</script>