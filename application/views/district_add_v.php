<div calss="view_content">
	<?php
	$attributes = array('id' => 'entry-form');
	echo form_open('district_management/save', $attributes);
	echo validation_errors('<p class="error">', '</p>');
	?>
	
	<table>
		<tr>
			<td>District Information</td>
		</tr>
		<tr>
			<td>District Name</td><td><input type="text" name="district" /></td>
		</tr>
		<tr>
			<td>Province Name</td>
			<td>
				<select id="provinces" name="provinces">					
					<?php
					foreach ($provinces as $province) {
						echo '<option value="' . $province->id . '">' . $province->Name . '</option>';
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Comment</td>
			<td><textarea name="comment" rows="3" cols="44"></textarea></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" class="submission_button" name="submit"/></td>
		</tr>
	</table>
</form>
</div>
