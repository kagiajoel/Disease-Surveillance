<div id="view_content">
	<table>
		<th>District Listing</th>
		<tr>
			<th>Province</th><th>District</th>
		</tr>
		<?php
		foreach ($mkoa as $province) {
			echo '<tr><th>' . $province -> Name . '</th><td></td></tr>';
			foreach ($districts as $district) {
				if ($district['Province'] == $province -> id) {
					echo '<tr><td></td><td>' . $district['Name'] . '</td></tr>';
				}
			}
		}
		?>
	</table>
</div>