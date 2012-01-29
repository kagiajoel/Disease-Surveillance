<div class="view_content">
	<?php
	$attributes = array('id' => 'entry-form');
	echo form_open('weeklydata_management/save', $attributes);
	echo validation_errors('<p class="error">', '</p>');
	?>
</div>
<table>
	<tr>
		<td>Week Ending:</td><td>
		<input type="text" name="weekending" id="weekending"/>
		</td><td> Epiweek: </td><td>
		<input type="text" name="epiweek" id="epiweek"/>
		</td>
	</tr>
	<tr>
		<td>Province: </td><td>
		<select name="province" id="province">
			<option value="">Select Province</option>
			<?php
			foreach ($provinces as $province) {
				echo '<option value="' . $province -> id . '">' . $province -> Name . '</option>';
			}//end foreach
			?>
		</select></td><td>District: </td><td>
		<input type="text" name="district" id="district"/>
		</td>
	</tr>
	<tr>
		<td>No. of Health Facility/Site reporting</td><td>
		<input type="text" name="reportingfacilities" id="reportingfacilities"/>
		</td><td>No. of Health Facility/Site reports expected</td><td>
		<input type="text" name="expectedfacilities" id="expectedfacilities"/>
		</td>
	</tr>
</table>
<table>
	<tr>
		<td colspan="2"></td>
		<th colspan="4">&le;5 Years</th>
		<th colspan="4">&ge;5 Years</th>
		<th colspan="4"></th>
	</tr>
	<th>No.</th>
	<th>Disease</th>
	<th colspan="2" >Cases</th>
	<th colspan="2" >Deaths</th>
	<th colspan="2" >Cases</th>
	<th colspan="2" >Deaths</th>
	<th colspan="2" ></th>
	<tr class="even">
		<td colspan="2">&nbsp;</td>
		<th >Males</th>
		<th >Females</th>
		<th >Males</th>
		<th >Females</th>
		<th >Males</th>
		<th >Females</th>
		<th >Males</th>
		<th >Females</th>
		<th colspan="2">Zero Reporting (Check as appropriate)</th>
	</tr>
	<?php
foreach ($diseases as $disease) {
if($disease -> id != "12"){
echo '<tr>
<td>' .$disease-> id . '</td>
<td>' . $disease -> Name . '</td>';
	?>
	<td style="background-color: #C4E8B7">
	<input type="text" name="lmcase[]" id="<?php echo "lmcase_" . $disease -> id;?>" size="10" value=""/>
	</td>
	<td style="background-color: #C4E8B7">
	<input type="text" name="lfcase[]" id="<?php echo "lfcase_" . $disease -> id;?>" size="10" value=""/>
	</td>
	<td style="background-color: #C4E8B7">
	<input type="text" name="lmdeath[]" id="<?php echo "lmdeath_" . $disease -> id;?>" size="10" value=""/>
	</td>
	<td style="background-color: #C4E8B7">
	<input type="text" name="lfdeath[]" id="<?php echo "lfdeath_" . $disease -> id;?>" size="10" value=""/>
	</td>
	<td style="background-color: #C4E8B7">
	<input type="text" name="gmcase[]" id="<?php echo "gmcase_" . $disease -> id;?>" size="10" value=""/>
	</td>
	<td style="background-color: #C4E8B7">
	<input type="text" name="gfcase[]" id="<?php echo "gfcase_" . $disease -> id;?>" size="10" value=""/>
	</td>
	<td style="background-color: #C4E8B7">
	<input type="text" name="gmdeath[]" id="<?php echo "gmdeath_" . $disease -> id;?>" size="10" value=""/>
	</td>
	<td style="background-color: #C4E8B7">
	<input type="text" name="gfdeath[]" id="<?php echo "gfdeath_" . $disease -> id;?>" size="10" value=""/>
	</td>
	<td>
	<input type="checkbox" id ="<?php echo "check_" . $disease -> id;?>" class="zero_reporting">
	</td>
	<?php
	echo '</tr>';
	}else{
	echo '<tr>
	<td>' .$disease-> id . '</td>
	<td>' . $disease -> Name . '</td>';
	?>
	<td style="background-color: #C4E8B7">
	<input type="text" name="lmcase[]" id="<?php echo "lmcase_" . $disease -> id;?>" size="10" value=""/>
	</td>
	<td style="background-color: #C4E8B7">
	<input type="text" name="lfcase[]" id="<?php echo "lfcase_" . $disease -> id;?>" size="10" value=""/>
	</td>
	<td style="background-color: #C4E8B7">
	<input type="text" name="lmdeath[]" id="<?php echo "lmdeath_" . $disease -> id;?>" size="10" value=""/>
	</td>
	<td style="background-color: #C4E8B7">
	<input type="text" name="lfdeath[]" id="<?php echo "lfdeath_" . $disease -> id;?>" size="10" value=""/>
	</td>
	<?php
	echo '</tr>';
	}//end else if
	}//end foreach
	?>
</table>

<table>
	<tr >
	    <td></td>
        <th colspan="1">Laboratory Weekly Malaria Confirmation</th>
        <th colspan="2">&le;5 years</th>
        <th colspan="7">&ge;5years</th>
    </tr>
    <tr >
    	<td></td>
        <td colspan="1"><strong> Total Number Tested </strong></td>
        <td colspan="2" style="background-color: #C4E8B7"><input type="text"  id="totaltestedmalarials" name="totaltestedlessfive" ></td>
        <td colspan="7" style="background-color: #C4E8B7"><input type="text" name="totaltestedmalariagr" id="totaltestedgreaterfive"></td>
    </tr>
    <tr >
        <td></td>
        <td colspan="1"><strong> Total Number Positive </strong></td>
        <td colspan="2" style="background-color: #C4E8B7"><input type="text" id="totalpositivemalarials" name="totalpositivelessfive"></td>
        <td colspan="7" style="background-color: #C4E8B7"><input type="text" id="totalpositivemalariagr" name="totalpositivegreaterfive"></td>
    </tr>
    <tr >
        <td></td>
        <td colspan="1"><strong> Remarks </strong></td>
        <td colspan="9"><textarea name="remarks" rows="2" cols="50"></textarea></td>
    </tr>
    <tr>
    	<td></td>
    	<td><strong> Reported by </strong></td>
        <td style="background-color: #C4E8B7"  colspan="4"><input type="text" name="reportedby" id="reportedby"></td>
        <td colspan="2"><strong> Designation </strong></td>
        <td style="background-color: #C4E8B7"  colspan="4"><input type="text" name="designation" id="designation"></td>
    </tr>
    <tr >
        <td></td>
        <td colspan="10"><input name="save" type="submit" class="button" value="Save " /></td>
    </tr>
</table>
