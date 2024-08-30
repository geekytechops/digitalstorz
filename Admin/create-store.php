<?php
session_start();
//print_r($_SESSION);
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'] )){
    
    //print_r($_SESSION);
    if($_SESSION['session_store_id']=='' && $_SESSION['session_user_role'] == ('admin')){
include("./dbconnect.php");

if(isset($_REQUEST['submit'])){
    //echo "here";exit;
    //print_r($_REQUEST);
    $store_name=$_REQUEST['store_name'];
    $store_contact=$_REQUEST['store_contact'];
    $store_address1=$_REQUEST['store_address1'];
    $store_address2=$_REQUEST['store_address2'];
    $admin_user=$_SESSION['session_user_id'];

    $sql_store_ins="INSERT INTO `stores`(`store_name`,`store_contact`,`store_address1`,`store_address2`,`admin_user`,`use_preloaded_defects`,`added_date`) VALUES 
    ('".$store_name."','".$store_contact."','".$store_address1."','".$store_address2."','".$admin_user."','yes',NOW())";
    //echo $sql_store_ins;exit;
    $query_store_ins=mysql_query($sql_store_ins);
    
		if($query_store_ins){ 
			$mess="<h1 style='color:red'>Message: </h1><h1 style='color:green'>Store Created Succesfully.. Logout and Login to Avail Premium Services.<h1>";
            	$sql_store_det="SELECT * FROM stores WHERE `admin_user`=".$_SESSION['session_user_id'];
            	$query_sql_store_det=mysql_query($sql_store_det);
            	$result_sql_store_det=mysql_fetch_array($query_sql_store_det);
            	
            	$_SESSION['session_store_id']=$result_sql_store_det['store_id'];
				$_SESSION['session_store_name']=$result_sql_store_det['store_name'];
				
				//Update Store ID for Admin User
				$sql_upd_str="UPDATE `cust_kolors_users_list` SET `store_id`='".$result_sql_store_det['store_id']."',`store_name`='".$result_sql_store_det['store_name']."' WHERE user_id=".$_SESSION['session_user_id'];
				$query_upd_str=mysql_query($sql_upd_str);
				if($query_upd_str){
				 header('Location: ./admin-home.php');   
				}else{
				 $mess="<h1 style='color:red'>Message: </h1><h1 style='color:red'>Failed to Update Store Id in Admin User Table..<h1>";
				}
				
		}else{
			$mess="<h1 style='color:red'>Message: </h1><h1 style='color:red'>Failed to Create Store..<h1>";
		}
		
}

?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<link href="../css/style.css" rel="stylesheet" type="text/css"/>
	<!-- For Menu-->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<!-- For Menu-->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>

<script type="text/javascript">
            // Form validation code for SIGN UP
            function validate()
            {

				if (document.create_user.store_name.value == "")
                {
                    document.create_user.store_name.focus();
                    alert("Store Name Should Not Be Empty..");
					return false;
                }
                if (document.create_user.store_contact.value == "")
                {
                    document.create_user.store_contact.focus();
                    alert("Store Contact Should Not Be Empty..");
					return false;
                }
                 if (document.create_user.store_address1.value == "")
                {
                    document.create_user.store_address1.focus();
                    alert("Store Address Line 1 Should Not Be Empty..");
					return false;
                }
                 if (document.create_user.store_address2.value == "")
                {
                    document.create_user.store_address2.focus();
                    alert("Store Address Line 2 Should Not Be Empty..");
					return false;
                }
      
                
            }

<!-- Script for preventing reload submit entry-->

    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
<script type="text/javascript">
    function onlyNumberKey(evt) {
          
        // Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }

</script>


</head>
<body>
	<div class="header">
		<span class="title_grad">&nbsp;&nbsp;&nbsp;&nbsp;Store Name Comes Here</span> <span style="font-size:14px; color:yellow;">Powered By DigitalStorz.com</span>
		<!--<a href="#"><img class="logo_img" src="./images/logo.png"></a>-->
	</div>
	
	<div class="main_container">
		
		<div class="right_container">
		    <div class="page_title_div"><h1>CREATE STORE</h1></div>
		    <div style="float:right;padding-right:100px;"><a href="./logout.php"><b>LOGOUT</b></a></div>
		    <div class="page_title_div"><?php echo $mess.' '.$mess1?></div>
			<div class="content_holder">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Store Details&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </div>
				
				<div class="content_holder_body">

				    <form name="create_user" onpaste="return false;" ondrop="return false;" autocomplete="off" method="post" action="./create-store.php" onsubmit="return validate()">
				        <h1><?php echo $note; ?></h1><br>
					<table style="margin-left:30px">
					    <tr><td class="txt_lable" style="text-align:right; font-family: 'Trebuchet MS', sans-serif;">Store Name&nbsp;&nbsp;</td> <td><input type="text" name="store_name" required minlength=5 value="" onkeyup=" var start = this.selectionStart;  var end = this.selectionEnd;   this.value = this.value.toUpperCase();   this.setSelectionRange(start, end);"></td><td style="color:red; font-size:17px;padding-left:15px;">&#x2731;</td></tr>
					    <tr><td class="txt_lable" style="text-align:right; font-family: 'Trebuchet MS', sans-serif;">Store Contact Number&nbsp;&nbsp;</td> <td><input type="number" required minlength=10 name="store_contact" value="" maxlength=10 required pattern="[0-9]{10}" onkeypress="if(this.value.length==10) return false;"  onkeydown="javascript: return (event.keyCode == 69 || event.keyCode == 190 || event.keyCode == 189 || event.keyCode == 187) ? false : true"  ></td><td style="color:red; font-size:15px;padding-left:15px;">&#x2731;</td></tr>
					    <tr><td class="txt_lable" style="text-align:right; font-family: 'Trebuchet MS', sans-serif;">Store Address Line 1&nbsp;&nbsp;</td> <td><input type="text" required name="store_address1" minlength=10 value="" onkeyup=" var start = this.selectionStart;  var end = this.selectionEnd;   this.value = this.value.toUpperCase();   this.setSelectionRange(start, end);"></td><td style="color:red; font-size:15px;padding-left:15px;">&#x2731;</td></tr>
					    <tr><td class="txt_lable" style="text-align:right; font-family: 'Trebuchet MS', sans-serif;">Store Address Line 2&nbsp;&nbsp;</td> <td><input type="text" required name="store_address2" minlength=10 value="" onkeyup=" var start = this.selectionStart;  var end = this.selectionEnd;   this.value = this.value.toUpperCase();   this.setSelectionRange(start, end);"></td><td style="color:red; font-size:15px;padding-left:15px;">&#x2731;</td></tr>
					    <tr><td>&nbsp;</td></td></tr>
					    <tr><td>&nbsp;</td></td><td><input type="submit" name="submit" value="CREATE STORE"></td></tr>
					</table>
					</form>

					<br><br>

				</div>

			</div>
			
		</div>
	</div>
</body>
</html>
<?php
    }else{
        echo "<div style='margin-left:auto; font-size:20px;margin-top:200px;text-align:center; margin-right:auto; color:red; font-weight:bold;'>You Are not authorized to see this page..</div>";
        echo "<div style='margin-left:auto; font-size:20px;text-align:center; margin-right:auto; color:red; font-weight:bold;'><a href='../Admin/admin-home.php'>Goto Home Page</a></div>";
    }
mysql_close($connection);

}else{
header('Location: ./index.php');
}
?>