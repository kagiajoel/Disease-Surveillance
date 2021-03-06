<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once('/connection/config.php');
include('functions.php');

$username = $_POST['username'];
$password = $_POST['password'];

// To protect MySQL injection
$username = stripslashes($username); //Un-quotes a quoted string.
$password = stripslashes($password); 
$username = mysql_real_escape_string($username); //Escapes special characters in a string for use in an SQL statement
$password = mysql_real_escape_string($password);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head><title>Integrated Diseases Surveillance Response</title>

<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">

<link href="css/styles.css" rel="stylesheet" type="text/css">
<link href="css/table.css" rel="stylesheet" type="text/css">

<!-- stylesheets -->
  	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
  	<link rel="stylesheet" href="css/slide.css" type="text/css" media="screen" />
	
  	<!-- PNG FIX for IE6 -->
  	<!-- http://24ways.org/2007/supersleight-transparent-png-in-ie6 -->
	<!--[if lte IE 6]>
		<script type="text/javascript" src="js/pngfix/supersleight-min.js"></script>
	<![endif]-->
	 
    <!-- jQuery - the core -->
	<script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
	<!-- Sliding effect -->
	<script src="js/slide.js" type="text/javascript"></script>
	
	<link rel="stylesheet" href="css/dropdown.css" type="text/css" />
<script type="text/javascript" src="js/dropdown.js"></script>


<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/fadeslideshow.js"></script>
<script type="text/javascript">

var mygallery=new fadeSlideShow({
	wrapperid: "fadeshow1", //ID of blank DIV on page to house Slideshow
	dimensions: [665, 385], //width/height of gallery in pixels. Should reflect dimensions of largest image
	imagearray: [
		["images/p1010242.jpg", "", "", "Nothing beats relaxing next to the pool when the weather is hot."],
		["images/dsc04286.jpg", "", "_new", "Some day I'd like to explore these caves!"],
		["images/28.jpg"],
		["images/45.jpg"], 
		["images/45.jpg"]//<--no trailing comma after very last image element!
	],
	displaymode: {type:'auto', pause:3500, cycles:0, wraparound:false},
	persist: false, //remember last viewed slide and recall within same session?
	fadeduration: 5000, //transition duration (milliseconds)
	descreveal: "ondemand",
	togglerid: ""
})

</script>
<link href="css/simpleTicker.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="pro_dropdown_2/pro_dropdown_2.css" />

<script src="pro_dropdown_2/stuHover.js" type="text/javascript"></script>
</head>

<body>
<div class="main" id="main-two-columns-left">
	<div>
		<?php
		if ($_REQUEST['Login'])
		{
			if ((strlen($username) <1) || (strlen($username) > 32))
			{
				?>
				<div class="error">
				<?php
				echo "<strong>Login failed, Please enter Username</strong>";
				?>
				</div>
				<?php
		
			}
			else if ((strlen($password) < 1) || (strlen($password) > 32))
			{
				?>
				<div class="error">
				<?php
				echo "<strong>Login failed, Please enter Password</strong>";
				?>
				</div>
				<?php
		
			}
			else
			{
				//$password = md5($password); //encrypt the password
				$checkuser = "SELECT id,role,accounttype FROM users WHERE username='$username' AND password='$password' AND flag = 1";
				$result = mysql_query($checkuser) or die(mysql_error());
				$count = mysql_num_rows($result);
			
				if ($result)
				{
					if($count > 0)
					{
							$userrec = mysql_fetch_assoc($result);
							
							$_SESSION['id'] = $userrec['id']; //the userid
							$_SESSION['role'] = $userrec['role'];
							$_SESSION['accounttype'] = $userrec['accounttype'];
							session_write_close();
														
							//save the log in time
							$sessionuserid = $_SESSION['id'];
							$sessionuserrole = $_SESSION['role'];
							$sessionaccounttype = $_SESSION['accounttype'];
							$logindate = date('Y-m-d');
							$logintime = date("h:i:s A");
							
							$savelog = "INSERT INTO loghistory(user,logindate,logintime)VALUES('$sessionuserid','$logindate','$logintime')";
							$loghist = @mysql_query($savelog) or die(mysql_error());
							
							if ($loghist)
							{
								//////////////////////////////////////////////////////////////////////////////////////
								if ($_SESSION['role'] == '3')
								{
									echo '<script type="text/javascript">' ;
									echo "window.location.href='dashboard.php'";
									echo '</script>';
								}
								else if ($_SESSION['role'] == '5')
								{
									echo '<script type="text/javascript">' ;
									echo "window.location.href='admin/admin.php'";
									echo '</script>';
								}
								
								else if ($_SESSION['role'] == '4')
								{
									echo '<script type="text/javascript">' ;
									echo "window.location.href='submissionlist.php'";
									echo '</script>';
								}
								else
								{
									//echo "Wait";
									echo '<script type="text/javascript">' ;
									echo "window.location.href='overall.php'";
									echo '</script>';
								}
							}
							
							else
							{
								?>
								<div class="error">
								<?php
								echo "<strong>Unable to save Details. Please try again.</strong><br/>";
								?>
								</div>
								<?php
							}
					}
					else 
					{
							?>
							<?php
							echo '<script type="text/javascript">' ;
									echo "window.location.href='wrong.php'";
									echo '</script>';
							?>
							<?php
					}
				}
				else
				{
					die("Query failed");
				}
				session_write_close();
			}
			
		}?>
	</div>
<!-- Panel -->
<div id="toppanel">
	<div id="panel">
		<div class="content clearfix">
			
			<div class="left">
            
				<!-- Login Form -->
				<form class="clearfix" name="form1" method="post">
                <table width="950" border="0">
  <tr>
    
    <th scope="col"><label class="grey" for="username">Username:</label></th>
    <th scope="col"><input class="field" type="text" name="username" id="username" value="" size="23" /></th>
    <th scope="col"><label class="grey" for="password">Password:</label></th>
    <th scope="col"><input class="field" type="password" name="password" id="password" size="23" /></th>
    <th scope="col"><input type="submit" name="Login" value="Login" class="bt_login" /></th>
    <th scope="col"><a class="lost-pwd" href="#">Forgot your password?</a></th>
  </tr>
</table>

		  	
        			<div class="clear"></div>
					
					
				</form>
			</div>
			
		</div>
</div> <!-- /login -->	

	<!-- The tab on top -->	
	<div class="tab">
		<ul class="login">
			<li class="left">&nbsp;</li>
			<li>Hello Guest!</li>
			<li class="sep">|</li>
			<li id="toggle">
				<a id="open" class="open" href="#">Log In Here</a>
				<a id="close" style="display: none;" class="close" href="#">Close Panel</a>			
			</li>
			<li class="right">&nbsp;</li>
		</ul> 
	</div> <!-- / top -->
	
</div> <!--panel -->
<div align="center">
<table width="950" border="0">
  <tr>
    <td height="856"><table width="15" border="0" height="700px" align="center">
  <tr>
    <td><img src="images/template_r10_c2.gif" alt="Border"></td>
  </tr>
</table></td>
    <td><table class="frame" border="0" cellpadding="0" cellspacing="0" width="900" align="center">
      <tbody>
        <tr>
          <td colspan="19"><img src="images/banner.jpg" alt="" height="125" width="896"></td>
          <td width="1"><img src="images/spacer.gif" alt="" height="25" width="1"></td>
        </tr>
        <tr>
         <td colspan="19"><ul id="nav">
	<li class="top"><a href="#nogo1" class="top_link"><span>Home</span></a></li>
	<li class="top"><a href="#nogo2" id="products" class="top_link"><span class="down">About Us</span></a>
		<ul class="sub">
			<li><a href="#nogo3" class="fly">Cameras</a>
					<ul>
						<li><a href="#nogo4">Nikon</a></li>
						<li><a href="#nogo5">Minolta</a></li>
						<li><a href="#nogo6">Pentax</a></li>
					</ul>
			</li>
			<li class="mid"><a href="#nogo7" class="fly">Lenses</a>
					<ul>
						<li><a href="#nogo8">Wide Angle</a></li>
						<li><a href="#nogo9">Standard</a></li>
						<li><a href="#nogo10">Telephoto</a></li>
						<li><a href="#nogo11" class="fly">Zoom</a>
							<ul>
								<li><a href="#nogo12">35mm to 125mm</a></li>
								<li><a href="#nogo13">50mm to 250mm</a></li>
								<li><a href="#nogo14">125mm to 500mm</a></li>
							</ul>
						</li>
						<li><a href="#nogo15">Mirror</a></li>
						<li><a href="#nogo16" class="fly">Non standard</a>
							<ul>
								<li><a href="#nogo17">Bayonet mount</a></li>
								<li><a href="#nogo18">Screw mount</a></li>
							</ul>
						</li>
					</ul>
			</li>
			<li><a href="#nogo19">Flash Guns</a></li>
			<li><a href="#nogo20">Tripods</a></li>
			<li><a href="#nogo21">Filters</a></li>
		</ul>
	</li>
	<li class="top"><a href="#nogo22" id="services" class="top_link"><span class="down">Resources</span></a>
		<ul class="sub">
			<li><a href="#nogo23">Printing</a></li>
			<li><a href="#nogo24">Photo Framing</a></li>
			<li><a href="#nogo25">Retouching</a></li>
			<li><a href="#nogo26">Archiving</a></li>
		</ul>
	</li>
	<li class="top"><a href="#nogo27" id="contacts" class="top_link"><span class="down">Events</span></a>
		<ul class="sub">
			<li><a href="#nogo28">Support</a></li>
			<li><a href="#nogo29" class="fly">Sales</a>
				<ul>
					<li><a href="#nogo30">USA</a></li>
					<li><a href="#nogo31">Canadian</a></li>
					<li><a href="#nogo32">South American</a></li>
					<li><a href="#nogo33" class="fly">European</a>
						<ul>
							<li><a href="#nogo34" class="fly">British</a>
								<ul>
									<li><a href="#nogo35">London</a></li>
									<li><a href="#nogo36">Liverpool</a></li>
									<li><a href="#nogo37">Glasgow</a></li>
									<li><a href="#nogo38" class="fly">Bristol</a>
										<ul>
											<li><a href="#nogo39">Redland</a></li>
											<li><a href="#nogo40">Hanham</a></li>
											<li><a href="#nogo41">Eastville</a></li>
										</ul>
									</li>
									<li><a href="#nogo42">Cardiff</a></li>
									<li><a href="#nogo43">Belfast</a></li>
								</ul>
							</li>
							<li><a href="#nogo44">French</a></li>
							<li><a href="#nogo45">German</a></li>
							<li><a href="#nogo46">Spanish</a></li>
						</ul>
					</li>
					<li><a href="#nogo47">Australian</a></li>
					<li><a href="#nogo48">Asian</a></li>
				</ul>
			</li>
			<li><a href="#nogo49">Buying</a></li>
			<li><a href="#nogo50">Photographers</a></li>
			<li><a href="#nogo51">Stockist</a></li>
			<li><a href="#nogo52">General</a></li>
		</ul>
	</li>
	<li class="top"><a href="#nogo53" id="shop" class="top_link"><span class="down">Clinicians Booklet</span></a>
		<ul class="sub">
			<li><a href="#nogo54">Online</a></li>
			<li><a href="#nogo55">Catalogue</a></li>
			<li><a href="#nogo56">Mail Order</a></li>
		</ul>
	</li>
	<li class="top"><a href="#nogo57" id="privacy" class="top_link"><span>Contact Us</span></a></li>
    <li class="top"><a href="#nogo57" id="privacy" class="top_link"><span>FAQs</span></a></li>
</ul></td>
          <td><img src="images/spacer.gif" alt="" height="25" width="1"></td>
        </tr>
        <tr>
          <td colspan="19"><table width="900" border="0" height="250">
              <tr>
                
                <td width="700"><div id="mytable"><table width="100%" border="0">
  <tr>
    <td colspan="2" class="mytable_th">OTHER DISEASES OF PUBLIC IMPORTANCE - Report Monthly</td>
    </tr>
  <tr>
    <td class="mytable_td2"><strong>Conditions present at first contact</strong></td>
    <td class="mytable_td2"><strong>Suspect</strong></td>
  </tr>
  <tr>
    <td class="mytable_td"><div class="dv"><div id="img"></div>Living in an area in which there are rumours/reports of deaths of domestic fowls</div>
    <p class="p"><strong>OR:</strong></p>
    <p class="dv">Any person requiring hospitalization due to influenza like illness (ILI).</p>
    <p class="dv">Any individual presenting with fever (temperature &ge; 38&deg;C) cough, sore throat and shortness of breath.</p>
    <p class="p"><strong>Other symptoms may include:</strong></p>
    <div class="dv">chills, myalgia, muscle pains and headache.</div>
    <p class="p"><strong>N/B:</strong></p>
    <p class="dv">Oropharyngeal swab should be taken for testing in selected sentinel surveillance sites for cases of influenza like illnesses and SARD.</p>
    </td>
    <td class="mytable_td3"><strong>Unexplained severe acute respiratory disease (SARD)</strong></td>
  </tr>
  <tr>
    <td class="mytable_td"><p class="p"><strong>Above 5 yrs excluding pregnancy:</strong></p>
    <p class="dv">Any person with fever or fever with headache, backpains, jointpains, chills, sweats, myalgia, nausea and vomiting with presence of peripheral parasitaemia.</p>
    <p class="p"><strong>Below 5 years:</strong></p>
    <p class="dv">Any child below 5 years with fever, chills, sweating, diarrhoea, nausea, vomiting, irritability and refusal to feed diagnosed clinically</p>
    <p class="p"><strong>Malaria in pregnancy:</strong></p>
    <p class="dv">A pregnant woman with signs and symptoms of uncomplicated malaria</p></td>
    <td class="mytable_td3"><strong>Unexplained severe acute respiratory disease (SARD)</strong></td>
  </tr>
  <tr>
    <td class="mytable_td"> <p class="p"><strong>Adults:</strong></p>
     <p class="dv">The case definition for AIDS is fulfilled if at least 2 major signs and at least 1 minor sign are present. The absence of either generalized Kaposi sarcoma or cryptococcal Menengitis is sufficient for the case definition of AIDS.</p>
     <p class="p"><strong>Children &lt; 12 years:</strong></p>
     <p class="dv">The case definition for AIDS is fulfilled if at least 2 major signs and at least 2 minor signs are present (if there is no other known cause of immunosuppressant). Confirmed HIV infection in the mother counts as a minor criterion.</p>
     <p class="prpl"><strong>MAJOR SIGNS</strong></p>
     <div class="dv"><div id="img"></div>Weight loss &gt; 10% of body weight or abnormal slow growth in children</div>
     <div class="dv"><div id="img"></div>Chronic diarrhoea for more than 1 month</div>
     <div class="dv"><div id="img"></div>Prolonged fever for more than 1 month</div></td>
    <td class="mytable_td3"><strong>New AIDS cases</strong></td>
  </tr>
  <tr>
    <td colspan="2" class="btm"><ul id="pagination-digg">
<li class="previous-off">�Previous</li>
<li class="active"><a href="other.php">1</a></li>
<li><a href="otherz.php">2</a></li>
<li><a href="others.php">3</a></li>
<li><a href="?page=4">4</a></li>
<li><a href="?page=5">5</a></li>
<li><a href="?page=6">6</a></li>
<li><a href="?page=7">7</a></li>
<li class="next"><a href="?page=2">Next �</a></li>
</ul></td>
    </tr>
</table>



</div>
</td>
                <td width="185"><table border="0" 
cellpadding="0" cellspacing="3"><form method="get" action="search.php"></form><tbody><tr
 align="left"><td><font class="style5">Search:</font></td><td><input 
class="textfield" name="keywords" size="15" type="text"></td><td><input 
src="images/Serach.jpg" value="Search Site" alt="Search" 
type="image" border="0" width="25" height="23"></td></tr></tbody></table>

	
	              <table width="180" border="0" height="330">
                    <tr>
                      <td><img src="images/wn.jpg" width="180" height="35" alt="News"></td>
                    </tr>
                    <tr>
                      <td><div id="tickerContainer">
      <dl id="ticker">
        <dt class="heading">The specific goals of IDSR are to:</dt>
        <dd class="text">
          <ul>
            <li>Strengthen district level surveillance and response for priority diseases,</li>
          </ul>
          <ul>
            <li></li>
          </ul>
        </dd>
        <dt class="heading">Disease control </dt>
        <dd class="text">Health surveillance, monitoring and analysis </dd>
        <dt class="heading">Malaria Control</dt>
        <dd class="text">Malaria Control Programme</dd>
        <dt class="heading">Non-Communicable Disease Control</dt><dd class="text">Investigation of disease outbreaks, epidemics and risk to health </dd>
        <dt class="heading">Government Chemist</dt><dd class="text">Undertake operational research in order to develop&nbsp; development and evaluate innovations on disease control interventions .</dd>
      </dl>
    </div></td>
                    </tr>
                  </table>
	              <script type="text/javascript" src="js/jquery.min.js"></script>
                  <table width="100%" border="0">
                    <tr>
                      <td><img src="images/implementattion.jpg" width="183" height="368" alt="IDSR in Kenya"></td>
                    </tr>
                  </table>
                  <script type="text/javascript">
	  $(function() {
	  
		//cache the ticker
		var ticker = $("#ticker");
		  
		//wrap dt:dd pairs in divs
		ticker.children().filter("dt").each(function() {
		  
		  var dt = $(this),
		    container = $("<div>");
		  
		  dt.next().appendTo(container);
		  dt.prependTo(container);
		  
		  container.appendTo(ticker);
		});
				
		//hide the scrollbar
		ticker.css("overflow", "hidden");
		
		//animator function
		function animator(currentItem) {
		    
		  //work out new anim duration
		  var distance = currentItem.height();
			duration = (distance + parseInt(currentItem.css("marginTop"))) / 0.025;

		  //animate the first child of the ticker
		  currentItem.animate({ marginTop: -distance }, duration, "linear", function() {
		    
			//move current item to the bottom
			currentItem.appendTo(currentItem.parent()).css("marginTop", 0);

			//recurse
			animator(currentItem.parent().children(":first"));
		  }); 
		};
		
		//start the ticker
		animator(ticker.children(":first"));
				
		//set mouseenter
		ticker.mouseenter(function() {
		  
		  //stop current animation
		  ticker.children().stop();
		  
		});
		
		//set mouseleave
		ticker.mouseleave(function() {
		          
          //resume animation
		  animator(ticker.children(":first"));
		  
		});
	  });
    </script>	</td>
              </tr>
          </table></td>
          <td><img src="images/spacer.gif" alt="" height="25" width="1"></td>
        </tr>
		<tr>
        <td colspan="19">
        
		<table width="100%" border="0">
  <tr>
    <td width="20%" bgcolor="#999999" style="font-size:16px; font-weight:bold; color:#FFF;" height="30" align="center">Public</td>
    <td width="26%" bgcolor="#666666" style="font-size:16px; font-weight:bold; color:#FFF;" height="30" align="center">Popular</td>
    <td width="33%" bgcolor="#333333" style="font-size:16px; font-weight:bold; color:#FFF;" height="30" align="center">Our Services</td>
    <td width="21%" bgcolor="#111111" style="font-size:16px; font-weight:bold; color:#FFF;" height="30" align="center">Polls</td>
  </tr>
  <tr>
    <td><img src="images/corruption.jpg" width="182" height="94" alt="Corruption"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><img src="images/forum.jpg" width="182" height="94" alt="Forum"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

        </td>
         
        </tr>
        <tr>
          <td colspan="19"><img src="images/down.gif" alt="" height="25" width="900"></td>
          <td><img src="images/spacer.gif" alt="" height="25" width="1"></td>
        </tr>
        <tr>
          <td colspan="5" class="text3" align="center" bgcolor="#ffffff" valign="middle"> Copyright 2011 � MOH <br></td>
          <td colspan="14" class="text4" align="center" bgcolor="#ffffff" valign="middle"><a href="#">Home</a> | <a href="#">About Us</a> | <a href="#">Events</a> | <a href="#">Resources</a> | <a href="#">News</a> | <a href="#">Contact Us</a></td>
          <td><img src="images/spacer.gif" alt="" height="34" width="1"></td>
        </tr>
        <tr>
          <td><img src="images/spacer.gif" alt="" height="1" width="16"></td>
          <td width="48"><img src="images/spacer.gif" alt="" height="1" width="48"></td>
          <td><img src="images/spacer.gif" alt="" height="1" width="121"></td>
          <td width="14"><img src="images/spacer.gif" alt="" height="1" width="12"></td>
          <td width="71"><img src="images/spacer.gif" alt="" height="1" width="61"></td>
          <td><img src="images/spacer.gif" alt="" height="1" width="25"></td>
          <td width="161"><img src="images/spacer.gif" alt="" height="1" width="139"></td>
          <td><img src="images/spacer.gif" alt="" height="1" width="37"></td>
          <td width="59"><img src="images/spacer.gif" alt="" height="1" width="51"></td>
          <td width="5"><img src="images/spacer.gif" alt="" height="1" width="4"></td>
          <td width="16"><img src="images/spacer.gif" alt="" height="1" width="14"></td>
          <td><img src="images/spacer.gif" alt="" height="1" width="16"></td>
          <td width="6"><img src="images/spacer.gif" alt="" height="1" width="5"></td>
          <td width="14"><img src="images/spacer.gif" alt="" height="1" width="12"></td>
          <td><img src="images/spacer.gif" alt="" height="1" width="37"></td>
          <td><img src="images/spacer.gif" alt="" height="1" width="143"></td>
          <td><img src="images/spacer.gif" alt="" height="1" width="21"></td>
          <td width="9"><img src="images/spacer.gif" alt="" height="1" width="8"></td>
          <td><img src="images/spacer.gif" alt="" height="1" width="5"></td>
          <td></td>
        </tr>
      </tbody>
    </table></td>
    <td><table width="15" border="0" height="700px" align="center">
  <tr>
    <td><img src="images/template_r10_c2.gif" alt="Border"></td>
  </tr>
</table></td>
  </tr>
</table>


 
    
</div>

</body></html>