<div id="view_content">
<table>
	<th>District Listing</th>
	<tr>
		<td>Province</td><td>District</td>
	</tr>
	<?php
	foreach($provinces as $province){
		echo '<tr><td>' .$province->Name. '</td></tr>';
	}
	?>
</table>
</div>