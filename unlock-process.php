<?php
session_start();
if(isset($_SESSION['session_retail_username']) && isset($_SESSION['session_retail_password'])){
include("./Admin/dbconnect.php");

	extract($_REQUEST);
	$sel_serc_id=$_REQUEST['un_id'];
	/*if(isset($_REQUEST['submit'])){
		
		$selected_service=$_REQUEST['selected_service'];
		$imei_no=$_REQUEST['imei_no'];
		$customer_name=$_REQUEST['customer_name'];
		$cust_name=$_REQUEST['customer_name'];
		$customer_phone_no=$_REQUEST['customer_phone_no'];
		$customer_email_id=$_REQUEST['customer_email_id'];
		
		$sql_ins=INSERT INTO `cust_service_requests`(`service_requested`, `imei`, `customer_name`, `contact_no`, `email`, `add_date`) VALUES 
		($selected_service,'"'.$imei_no.'"','"'.$customer_name.'"','"'.$customer_phone_no.'"','"'.$customer_email_id.'"',NOW());
	}*/

?>
<!DOCTYPE html>
<html lang="en" dir="ltr"
  xmlns:content="http://purl.org/rss/1.0/modules/content/"
  xmlns:dc="http://purl.org/dc/terms/"
  xmlns:foaf="http://xmlns.com/foaf/0.1/"
  xmlns:og="http://ogp.me/ns#"
  xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#"
  xmlns:sioc="http://rdfs.org/sioc/ns#"
  xmlns:sioct="http://rdfs.org/sioc/types#"
  xmlns:skos="http://www.w3.org/2004/02/skos/core#"
  xmlns:xsd="http://www.w3.org/2001/XMLSchema#"
  xmlns:fb="http://ogp.me/ns/fb#"
  xmlns:article="http://ogp.me/ns/article#"
  xmlns:book="http://ogp.me/ns/book#"
  xmlns:profile="http://ogp.me/ns/profile#"
  xmlns:video="http://ogp.me/ns/video#">
<head>
<meta charset="utf-8" />
<meta about="/Phone-Unlocks" property="sioc:num_replies" content="0" datatype="xsd:integer" />
<link rel="shortcut icon" href="http://www.kolorsmobileservices.com/sites/default/files/favicon-kolors.png" type="image/png" />
<meta content="Unlocks Available Currently" about="/Phone-Unlocks" property="dc:title" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta name="description" content="Phone Model Price Duration Iphone Carrier Check 100 1 Hour (Max) Iphone 4S AT&amp;T US 2300 7 Days Iphone 5S AT&amp;T US 3500 3 Days" />
<meta name="generator" content="Drupal 7 (http://drupal.org)" />
<link rel="canonical" href="http://www.kolorsmobileservices.com/Phone-Unlocks" />
<link rel="shortlink" href="http://www.kolorsmobileservices.com/node/5" />
<meta property="og:site_name" content="Kolors Mobile Solutions" />
<meta property="og:type" content="article" />
<meta property="og:url" content="http://www.kolorsmobileservices.com/Phone-Unlocks" />
<meta property="og:title" content="Unlocks Available Currently" />
<meta property="og:description" content="Phone Model Price Duration Iphone Carrier Check 100 1 Hour (Max) Iphone 4S AT&amp;T US 2300 7 Days Iphone 5S AT&amp;T US 3500 3 Days" />
<meta property="og:updated_time" content="2014-09-17T16:05:06+05:30" />
<meta property="article:published_time" content="2014-09-17T15:59:34+05:30" />
<meta property="article:modified_time" content="2014-09-17T16:05:06+05:30" />
<title>I Phone Unlocks, Mobile Phone unlock, i phone unlock in hyderabad, cheapsrt i phone unlock prices in hyderabad, at&t unlock | Kolors Mobile Solutions</title>
<style type="text/css" media="all">@import url("http://www.kolorsmobileservices.com/modules/system/system.base.css?nc5aro");
@import url("http://www.kolorsmobileservices.com/modules/system/system.menus.css?nc5aro");
@import url("http://www.kolorsmobileservices.com/modules/system/system.messages.css?nc5aro");
@import url("http://www.kolorsmobileservices.com/modules/system/system.theme.css?nc5aro");</style>
<style type="text/css" media="all">@import url("http://www.kolorsmobileservices.com/modules/comment/comment.css?nc5aro");
@import url("http://www.kolorsmobileservices.com/modules/field/theme/field.css?nc5aro");
@import url("http://www.kolorsmobileservices.com/modules/node/node.css?nc5aro");
@import url("http://www.kolorsmobileservices.com/modules/search/search.css?nc5aro");
@import url("http://www.kolorsmobileservices.com/modules/user/user.css?nc5aro");
@import url("http://www.kolorsmobileservices.com/sites/all/modules/views/css/views.css?nc5aro");</style>
<style type="text/css" media="all">@import url("http://www.kolorsmobileservices.com/sites/all/modules/ctools/css/ctools.css?nc5aro");</style>
<style type="text/css" media="all">@import url("http://www.kolorsmobileservices.com/sites/all/themes/impact_theme/style.css?nc5aro");</style>
<script type="text/javascript" src="http://www.kolorsmobileservices.com/misc/jquery.js?v=1.4.4"></script>
<script type="text/javascript" src="http://www.kolorsmobileservices.com/misc/jquery.once.js?v=1.2"></script>
<script type="text/javascript" src="http://www.kolorsmobileservices.com/misc/drupal.js?nc5aro"></script>
<script type="text/javascript" src="http://www.kolorsmobileservices.com/sites/all/themes/impact_theme/js/main-menu.js?nc5aro"></script>
<script type="text/javascript" src="http://www.kolorsmobileservices.com/sites/all/themes/impact_theme/js/pngfix.min.js?nc5aro"></script>
<script type="text/javascript">
<!--//--><![CDATA[//><!--
jQuery.extend(Drupal.settings, {"basePath":"\/","pathPrefix":"","ajaxPageState":{"theme":"impact_theme","theme_token":"gtCPvwLZj245rq4wA90G5ZrqiMYXrRStjDntx6b5mkQ","js":{"misc\/jquery.js":1,"misc\/jquery.once.js":1,"misc\/drupal.js":1,"sites\/all\/themes\/impact_theme\/js\/main-menu.js":1,"sites\/all\/themes\/impact_theme\/js\/pngfix.min.js":1},"css":{"modules\/system\/system.base.css":1,"modules\/system\/system.menus.css":1,"modules\/system\/system.messages.css":1,"modules\/system\/system.theme.css":1,"modules\/comment\/comment.css":1,"modules\/field\/theme\/field.css":1,"modules\/node\/node.css":1,"modules\/search\/search.css":1,"modules\/user\/user.css":1,"sites\/all\/modules\/views\/css\/views.css":1,"sites\/all\/modules\/ctools\/css\/ctools.css":1,"sites\/all\/themes\/impact_theme\/style.css":1}}});
//--><!]]>
</script>
<!--[if lt IE 9]><script src="/sites/all/themes/impact_theme/js/html5.js"></script><![endif]-->

	<script type="text/javascript">
            // Form validation code for SIGN UP
            function validate()
            {
				if (document.unlock_process.selected_service.value == "")
                {
                    document.unlock_process.selected_service.focus();
                    alert("Select Service");
					return false;
                }
				if (document.unlock_process.imei_no.value == "")
                {
                    document.unlock_process.imei_no.focus();
					alert("Provide Valid IMEI No..");
                    return false;
                }
				if (document.unlock_process.customer_name.value == "")
                {
                    document.unlock_process.customer_name.focus();
					alert("Provide Your Full Name..");
                    return false;
                }
				if (document.unlock_process.customer_phone_no.value == "")
                {
                    document.unlock_process.customer_phone_no.focus();
					alert("Provide Valid Mobile Number");
                    return false;
                }
				if (document.unlock_process.customer_email_id.value == "")
                {
                    document.unlock_process.customer_email_id.focus();
					alert("Provide Valid Email Id");
                    return false;
                }
			}
			
			function numbersonly(e){
				var unicode=e.charCode? e.charCode : e.keyCode
				if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
				if (unicode<48||unicode>57) //if not a number
				return false //disable key press
				}
			}

	</script>
</head>
    <body class="html front not-logged-in one-sidebar sidebar-first page-node page-node- page-node-6 node-type-page">
        <div id="wrapper">
            <header id="header" class="clearfix">
                <div id="site-logo"><a href="/" title="Home">
                        <img src="http://www.kolorsmobileservices.liveplace.in/sites/default/files/colors-latest-logo.png" alt="Home" />
                    </a></div>                      <div class="social-profile">
                    <ul>
                        <li class="facebook">
                            <a target="_blank" title="Kolors Mobile Solutions in Facebook" href="http://www.facebook.com/kolorsmobileservices">Kolors Mobile Solutions Facebook </a>
                        </li>          <li class="twitter">
                            <a target="_blank" title="Kolors Mobile Solutions in Twitter" href="http://www.twitter.com/">Kolors Mobile Solutions Twitter </a>
                        </li>                    <li class="rss">
                            <a target="_blank" title="Kolors Mobile Solutions in RSS" href="/rss.xml">Kolors Mobile Solutions RSS </a>
                        </li>
                    </ul>
                </div>
                <nav id="navigation" role="navigation">
                    <div id="main-menu">
                        <ul class="menu"><li class="first leaf"><a href="/" class="active">Home</a></li>
                            <li class="leaf"><a href="/About">About</a></li>
                            <li class="leaf"><a href="/Kolors-Training-Institute-for-Moble-Technicians" title="Training Institute" target="_blank">Training Institute</a></li>     
                            <li class="last leaf"><a href="/Contact">Contact</a></li>
							<li class="leaf"><a href="http://www.kolorsmobileservices.com/Unlocks/mobile-unlocks.php" title="">Mobile Unlocks</a></li>
                        </ul>      </div>
                </nav>
            </header>
            <div id="main" class="clearfix">
                <div id="primary">
                    <section id="content" role="main">
                        <div id="content-wrap">
                            <h1 class="page-title">Well, You are few steps ahead..</h1>                                                  
                            <div class="region region-content">
                                <div id="block-system-main" class="block block-system">
                                    <div class="content">
                                        <div class="content">
										<form name="unlock_process" method="post" action="./unlock-process.php?q=1" onsubmit="return validate()">
										<table class="my_unlock">
											<tr>
												<td>Select Service:</td>
												<td>
													<select name="selected_service" >
														<option value="">--SELECT--</option>
													<?php
														$sql_ser="SELECT * FROM cust_kolors_services_list";
														$query_ser=mysql_query($sql_ser);
														while($result_ser=mysql_fetch_array($query_ser)){
															if($result_ser['service_id']==$sel_serc_id){
																echo '<option value="'.$result_ser['service_id'].'" selected>'.$result_ser['service_name'].' - '.$result_ser['customer_price'].' INR - '.$result_ser['duration'].'</option>';
															}else{
																echo '<option value="'.$result_ser['service_id'].'">'.$result_ser['service_name'].' - '.$result_ser['customer_price'].' INR - '.$result_ser['duration'].'</option>';
															}
														}
													?>
													</select>
												</td>
											</tr>
											<tr>
												<td>IMEI No:</td>
												<td><input type="text" name="imei_no" value="" maxlength="16"/></td>
											</tr>
											<tr>
												<td colspan=2><font color="red">Provide Your Contact Details</font></td>
											</tr>
											<tr>
												<td>Your Name:</td>
												<td><input type="text" name="customer_name" value=""/></td>
											</tr>
											<tr>
												<td>Contact No:</td>
												<td><input type="text" onkeypress="return numbersonly(event)" maxlength="10" name="customer_phone_no" value=""/>&nbsp;&nbsp;10 Digits only</td>
											</tr>
											<tr>
												<td>Email Id:</td>
												<td><input type="text" name="customer_email_id" value=""/>&nbsp;Unlock details willl be sent</td>
											</tr>
											<tr>
												<td>Deposit Slip:</td>
												<td><input type="file" name="bank_deposit_sli" value=""/></td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td><input type="submit" name="submit" value="Submit"/></td>
											</tr>
											<tr>
												<td colspan="2"><br>1. Before/After Submitting your details, You Need to Deposit/Transfer the Amount mentioned to your Service to our Bank Account. <br/>2. After you done Deposit/Transfer, Please send the scanned copy of Deposit slip to our email admin@KolorsMobileServices.com, in case of online transfer send your transfer message to 9032339944. <br> 3. Unlock Process will be initiated after verification of your deposit.</td>
											
											</tr>
										</table>
										</form>
                                        </div>
                                        <footer> </footer>
                                    </div>
                                </div> <!-- /.block -->
                            </div>
                            <!-- /.region -->
                        </div>
                    </section> <!-- /#main -->
                </div>

                <aside id="sidebar" role="complementary">
                    <div class="region region-sidebar-first">
                        <div id="block-block-2" class="block block-block">

                            <h2 >Our Location</h2>

                            <div class="content">
                                <p>Kolors Mobile Services,<br />
                                    Shop No: 9, Nagarjuna Homes,<br />
                                    Nizampet Road,<br />
                                    Kukatpally, Hyd-85.<br />
                                    Land Mark: Beside ICICI Bank.</p>
                                <p>Phone: 040-65149944<br />
                                    Mobile: +91 9032339944</p>
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d826.162305082835!2d78.38729699999998!3d17.504960000000015!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bcb91f9cba1c45d%3A0x1e57b95e562e349c!2sKolors+Cell+Care!5e1!3m2!1sen!2sin!4v1411015635652" width="233" height="200" frameborder="0" style="border:0"></iframe>  
							</div>

                        </div> <!-- /.block -->
                    </div>
                    <!-- /.region -->
                </aside> 
            </div>
            <footer id="footer-bottom">
                <div id="footer-area" class="clearfix">

                </div>

                <div id="bottom" class="clearfix">
                    <div class="copyright">Copyright &copy; 2014, <a href="/">KolorsMobileServices.com</a></div>
                </div>
            </footer>
        </div>
    </body>
</html>
<?php
mysql_close($connection);
}else{
header('Location: ./retail-login.php');
}
?>