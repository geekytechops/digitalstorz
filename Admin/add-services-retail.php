<?php
session_start();
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
include("./dbconnect.php");
$mess='';
if(isset($_REQUEST['submit'])){
		$service_name=$_REQUEST['service_name'];
		$service_price=$_REQUEST['service_price'];
		$duration=$_REQUEST['duration'];
		
		$sql_ins="INSERT INTO `cust_kolors_services_list_retail`(`service_name`, `price`, `duration`, `add_date`, `status`) VALUES 
		('".$service_name."','".$service_price."','".$duration."',NOW(),1)";
		$query_ins=mysql_query($sql_ins);
		if($query_ins){
			$mess="Added Succesfully..";
		}else{
			$mess="Failed to Add..";
		}
} 
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
				if (document.service_add.service_name.value == "")
                {
                    document.service_add.service_name.focus();
                    alert("Enter Service Name");
					return false;
                }
				if (document.service_add.service_price.value == "")
                {
                    document.service_add.service_price.focus();
					alert("Enter Price");
                    return false;
                }
				if (document.service_add.duration.value == "")
                {
                    document.service_add.duration.focus();
					alert("Enter Duration");
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
                <div id="site-logo"><a href="#" title="Home">
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
                        <ul class="menu"><li class="leaf"><a href="./admin-home.php" class="active">Home</a></li>
                            <li class="first leaf"><a href="./add-services.php">Add Services</a></li>
                            <li class="first leaf"><a href="./add-services-retail.php">Add Services Retail</a></li>
							 <li class="leaf"><a href="./logout.php">Logout</a></li>
                        </ul>      
						
					</div>
                </nav>
            </header>


            <div id="main" class="clearfix">
                <div id="primary">
                    <section id="content" role="main">
                        <div id="content-wrap">
                            <h1 class="page-title">ADD UNLOCK SERVICES RETAIL</h1>                                                  
                            <div class="region region-content">
                                <div id="block-system-main" class="block block-system">
                                    <div class="content">
                                        <div class="content">
											<br/>
											<div style="padding:5px;">
												<form name="service_add" method="post" action="./add-services-retail.php" onsubmit="return validate()">
												<div style="float:left;">Service Name:&nbsp;&nbsp;</div>
												<div style="float:left;"> <input style="height:10px;" type="text" name="service_name" value="" ></div>
												
												<div style="float:left;">&nbsp;&nbsp;Price:&nbsp;&nbsp;</div>
												<div style="float:left;"> <input style="height:10px; width:80px;" MAXLENGTH="5"  onkeypress="return numbersonly(event)" type="text" name="service_price" value="" ></div>
												
												<div style="float:left;">&nbsp;&nbsp;Duration:&nbsp;&nbsp;</div>
												<div style="float:left;"> <input style="height:10px; width:40px;" type="text" name="duration" value="" ></div>
												
												<div style="float:left;">&nbsp;&nbsp;<input style="height:25px;" type="submit" name="submit" value="ADD" /></div>
												</form>
											</div>
											<br/><?php echo $mess; ?><br/>
											<DIV style="margin-top:15px;">
												<table style="margin-top:15px;">
													<tr><td>Service Name</td><td>Price (INR)</td><td>Duration (Hrs)</td></tr>
											<?php
												$sql_ser="SELECT * FROM cust_kolors_services_list_retail`";
												$query_ser=mysql_query($sql_ser);
												while($result_ser=mysql_fetch_array($query_ser)){
													echo '<tr>
																<td>'.$result_ser['service_name'].'</td>
																<td>'.$result_ser['price'].'</td>
																<td>'.$result_ser['duration'].'</td>
														 </tr>';
												}
											?>
												</table>
											</DIV>
	
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
header('Location: ./index.php');
}
?>