<?php

$this -> load -> helper('url');
$this -> load -> helper('form');
?>
<script type="text/javascript">
	$(function(){
var chart = new FusionCharts('<?php echo base_url().'Scripts/FusionCharts/Charts/MSLine.swf'?>', "ChartId", "500", "250", "0", "0");
	chart.setDataURL('<?php echo base_url().'home_controller/diseaseTrendGraph/'.$values[0]."/".$values[1];?>');
	chart.render("diseasetrends");
	});
$(function(){
var chart = new FusionCharts('<?php echo base_url().'Scripts/FusionCharts/Charts/MSLine.swf'?>', "ChartId2", "500", "250", "0", "0");
	chart.setDataURL('<?php echo base_url().'home_controller/positivityGraph/'.$values[0]."/".$values[2]."/".$values[3];?>');
	chart.render("positivities");
	});
</script>

<script type="text/javascript">
function getElementsByClassName(className, tag, elm){
	var testClass = new RegExp("(^|\\s)" + className + "(\\s|$)");
	var tag = tag || "*";
	var elm = elm || document;
	var elements = (tag == "*" && elm.all)? elm.all : elm.getElementsByTagName(tag);
	var returnElements = [];
	var current;
	var length = elements.length;
	for(var i=0; i<length; i++){
		current = elements[i];
		if(testClass.test(current.className)){
			returnElements.push(current);
		}
	}
	return returnElements;
}

function addClassName(elm, className){
    var currentClass = elm.className;
    if(!new RegExp(("(^|\\s)" + className + "(\\s|$)"), "i").test(currentClass)){
        elm.className = currentClass + ((currentClass.length > 0)? " " : "") + className;
    }
    return elm.className;
}

function removeClassName(elm, className){
    var classToRemove = new RegExp(("(^|\\s)" + className + "(\\s|$)"), "i");
    elm.className = elm.className.replace(classToRemove, "").replace(/^\s+|\s+$/g, "");
    return elm.className;
}

function activateThisColumn(column) {
	var table = document.getElementById('epidemictable');
	
	// first, remove the 'on' class from all other th's
	var ths = table.getElementsByTagName('th');
	for (var g=0; g<ths.length; g++) {
		removeClassName(ths[g], 'on');
	}
	// then, remove the 'on' class from all other td's
	var tds = table.getElementsByTagName('td');
	for (var m=0; m<tds.length; m++) {
		removeClassName(tds[m], 'on');
	}
	
	// now, add the class 'on' to the selected th
	var newths = getElementsByClassName(column, 'th', table);
	for (var h=0; h<newths.length; h++) {
		addClassName(newths[h], 'on');
	}
	// and finally, add the class 'on' to the selected td
	var newtds = getElementsByClassName(column, 'td', table);
	for (var i=0; i<newtds.length; i++) {
		addClassName(newtds[i], 'on');
	}
}
</script>

<div align="center">
	<?php echo form_open('home_controller/dave');?>
	<table>
		<tr>
			<td> Province
			<select name="province" id="province">
				<option value="0" selected>--Select Province--</option>
				<?php
				foreach ($provinces as $province) {
					echo "<option value='$province->id'>$province->Name</option>";
				}
				?>
			</select></td>
			<td> Epiweek
			<select name="epiweek" id="epiweek">
				<option value="0" selected>--Select Epiweek--</option>
				<?php
				foreach ($epiweeks as $epiweek) {
					echo "<option value='$epiweek->epiweek'>$epiweek->epiweek</option>";
				}
				?>
			</select></td>
			<td> Year
			<select name="year" id="year">
				<option value="0" selected>--Select Year--</option>
				<?php
				foreach ($years as $year) {
					echo "<option value='$year->filteryear'>$year->filteryear</option>";
				}
				?>
			</select></td>
			<td> Disease
			<select name="disease" id="disease">
				<option value="0" selected>--Select Disease--</option>
				<?php
				foreach ($diseases as $disease) {
					echo "<option value='$disease->id'>$disease->Name</option>";
				}
				?>
			</select></td>
			<td><input name="filter" type="submit" class="button" value="Filter"/></td>
		</tr>
	</table>
	<?php echo form_close();?>
	<table>
		<tr>
			<td>
				<div id="diseasetrends"></div>
			</td>
			<td>
				<div id="positivities"></div>
			</td>
		</tr>
	</table>
	
	<div id="epidemicdiseases">
		<table id="epidemictable">
			<caption><strong>Epidemic Prone Disease Occurences</strong></caption>
			<tr>
				<th>District</th>
				<th>Male Cases Under 5</th>
				<th>Female Cases Under 5</th>
				<th>Male Cases Above 5</th>
				<th>Female Cases Above 5</th>
					
			</tr>
					<?php
					foreach($epidemiks as $epidemic){
						echo "
						<tr>													 					
						<td class=district onclick=activateThisColumn('district');return false;>".$epidemic['District']."</td>						
						<td class=otherepidemictdsA onclick=activateThisColumn('otherepidemictdsA');return false;>".$epidemic['Lmcase']."</td>
						<td class=otherepidemictdsB onclick=activateThisColumn('otherepidemictdsB');return false;>".$epidemic['Lfcase']."</td>
						<td class=otherepidemictdsC onclick=activateThisColumn('otherepidemictdsC');return false;>".$epidemic['Gmcase']."</td>
						<td class=otherepidemictdsD onclick=activateThisColumn('otherepidemictdsD');return false;>".$epidemic['Gfcase']."</td>						
						</tr>";
					}
					?>
		</table>
	</div>

