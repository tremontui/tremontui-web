<div id="doc_wrapper">
	<div id="doc_dir">
		<ul>
			<li>
				<a href="?topic=planned">Planned Features</a>
			</li>
			<li>
				<a href="?topic=brand_management">Brand Management</a>
			</li>
			<li>
				<a href="?topic=inventory_interface">Inventory Interface</a>
			</li>
		</ul>
	</div>
	<div id="doc_data">
		<?php
			if( $topic != '' ){
				include "docs/$topic.php";
			}
		?>
	</div>
</div>