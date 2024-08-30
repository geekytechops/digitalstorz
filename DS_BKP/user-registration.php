<?php
	include("./Admin/dbconnect.php");
	extract($_REQUEST);
	$mess='';
		if(isset($_REQUEST['q'])){
			$m=$_REQUEST['q'];	
			if($m==1){
				$mess="Registration Successful..";
			}else if($m==2){
				$mess="Please Contact Admin..";
			}else if($m==3){
			    $mess="USER ALREADY EXISTS..";
			}
		}
		
if(isset($_REQUEST['submit'])){
   // print_r($_REQUEST);

    $username_retail=$_REQUEST['username_retail'];
    $password_retail=$_REQUEST['password_retail'];
    $hashed_password = password_hash($password_retail,PASSWORD_DEFAULT); //encrypting password
    $retail_name=$_REQUEST['retail_name'];
    $retail_store_contact=$_REQUEST['retail_store_contact'];
    $retail_email=strtolower($_REQUEST['retail_email']);
    //echo $retail_email;exit;
    $retail_store_name=$_REQUEST['retail_store_name'];
    $retail_store_address1=$_REQUEST['retail_store_address1'];
    $retail_store_address2=$_REQUEST['retail_store_address2'];
    $referal_code=$_REQUEST['referal_code'];
    $use_default_defects="yes";
    
    $sql_usercheck="SELECT * FROM cust_kolors_users_list WHERE username=".$username_retail;
    $query_usercheck=mysql_query($sql_usercheck);
    $num_rows_usercheck=mysql_num_rows($query_usercheck);
    
    if($num_rows_usercheck==0){
    $sql_store_ins="INSERT INTO `stores`(`store_name`,`store_contact`,`store_address1`,`store_address2`,`referal_code`,`use_preloaded_defects`,`added_date`) VALUES 
    ('".$retail_store_name."','".$retail_store_contact."','".$retail_store_address1."','".$retail_store_address2."','".$referal_code."','".$use_default_defects."',NOW())";
    //echo $sql_store_ins;exit;
    $query_store_ins=mysql_query($sql_store_ins);
    $store_id=mysql_insert_id();
    $user_role='admin';
    
    $sql_user_ins="INSERT INTO `cust_kolors_users_list`(`store_id`, `store_name`, `user_role`, `username`, `password`, `staff_name`, `staff_mobile`, `staff_email`, `status`, `add_date`) 
    VALUES 
    ('".$store_id."','".$retail_store_name."','".$user_role."','".$username_retail."','".$hashed_password."','".$retail_name."','".$username_retail."','".$retail_email."','0' ,NOW() )";
   //echo $sql_user_ins;exit;
   $query_user_ins=mysql_query($sql_user_ins);
   $added_user_id=mysql_insert_id();
   
   if($query_user_ins){
        $sql_store_query="UPDATE `stores` SET `admin_user`='".$added_user_id."' WHERE `store_id`=".$store_id ;
        $query_store_ins=mysql_query($sql_store_query);
       	header('Location: ./Admin/index.php?reg=success');
   }else{
        header('Location: ./user-registration.php?q=2');
   }
    }else{
        header('Location: ./user-registration.php?q=3');
    }
   
}
?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<link href="../css/style.css" rel="stylesheet" type="text/css"/>
	<!-- For Menu-->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<script src="./Unlocks/js/script.js"></script>
	<!-- For Menu-->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>
	
	<script type="text/javascript">
	

            // Form validation code for SIGN UP
            function validate()
            {

				if (document.retail_login.username_retail.value == "")
                {
                    document.retail_login.username_retail.focus();
					alert("Please Enter Mobile Number.");
                    return false;
                }
				if (document.retail_login.password_retail.value == "")
                {
                    document.retail_login.password_retail.focus();
					alert("Please Enter Password.");
                    return false;
                }

                
                if (document.retail_login.password_retail.value != ''){
                    if(document.retail_login.password_retail.value.length < 8){
                        document.retail_login.password_retail.focus();
                        alert("Password Should Be minimum 8 Charecters..");
                        return false;
                    }
                }
                
                if (document.retail_login.reenter_password_retail.value == "")
                {
                    document.retail_login.password_retail.focus();
					alert("Please Re Enter Password.");
                    return false;
                }
                
                if (document.retail_login.password_retail.value != document.retail_login.reenter_password_retail.value){
                        document.retail_login.reenter_password_retail.focus();
                        alert("Passwords Do Not Match..");
                        return false;
                }
                
                if (document.retail_login.reenter_password_retail.value != ''){
                    if(document.retail_login.reenter_password_retail.value.length < 8){
                        document.retail_login.reenter_password_retail.focus();
                        alert("Password Should Be minimum 8 Charecters..");
                        return false;
                    }
                }
                
                if (document.retail_login.retail_name.value == "")
                {
                    document.retail_login.retail_name.focus();
					alert("Please Enter Name.");
                    return false;
                }
                
                if (document.retail_login.retail_email.value == "")
                {
                    document.retail_login.retail_email.focus();
					alert("Enter email id..");
                    return false;
                }else{
					var email = document.getElementById('retail_email');
					var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

					if (!filter.test(email.value)) {
						alert('Invalid Email');
						email.focus();
						return false;
					}
				}
				
              
                if (document.retail_login.retail_store_name.value == "")
                {
                    document.retail_login.retail_store_name.focus();
					alert("Please Enter Store Name.");
                    return false;
                }
                if (document.retail_login.retail_store_contact.value == "")
                {
                    document.retail_login.retail_store_contact.focus();
					alert("Please Enter Store Contact.");
                    return false;
                }
                
                
                
			}
			
	        function numbersonly(e){
			    //alert("hi");
				var unicode=e.charCode? e.charCode : e.keyCode
				if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
				if (unicode<48||unicode>57) //if not a number
				if (document.retail_login.username_retail.value < 10)
				return false //disable key press
				}
			}
			function numbersonly1(e){
			    //alert("hi");
				var unicode=e.charCode? e.charCode : e.keyCode
				if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
				if (unicode<48||unicode>57) //if not a number
				if (document.retail_login.retail_store_contact.value < 10)
				return false //disable key press
				}
			}
			function numbersonly2(e){
			    //alert("hi");
				var unicode=e.charCode? e.charCode : e.keyCode
				if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
				if (unicode<48||unicode>57) //if not a number
				if (document.retail_login.referal_code.value < 10)
				return false //disable key press
				}
			}
			
			
		
		function CheckUserName(){

			var UserName = document.getElementById('username_retail');
            //alert(UserName);
			//alert(UserName.value);
			if(UserName.value != "" && UserName.value.length >9)
			{
				//alert('username not null');
				if (window.XMLHttpRequest)
				{// code for IE7+, Firefox, Chrome, Opera, Safari
				  //alert('in if');
				  xmlhttp=new XMLHttpRequest();
				}
				else
				{// code for IE6, IE5
				  //alert('in else');
				  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange=function()
				{
					//alert(xmlhttp.readyState.value);
				  if (xmlhttp.readyState==4 && xmlhttp.status==200)
					{
						var value = xmlhttp.responseText;
						//alert(value.length);
						if(value.length > 1)
						{
							document.getElementById('ErrorSpan').innerHTML="<font style='color:red'>&#10006; User Already Registered.</font>";
							UserName.focus();
						}
						else
						{
							document.getElementById('ErrorSpan').innerHTML="<font style='color:green'>&#10003; Available.</font>";
						}
					}
				  }
				xmlhttp.open("GET","retail_username_check_ajax_new.php?q="+UserName.value,true);
				xmlhttp.send();
			}else{
				document.getElementById('ErrorSpan').innerHTML="Min 10 Characters";
				UserName.focus();
			}
		}
		
function ShowPassword1() {
  var x = document.getElementById("password_retail");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

function ShowPassword2() {
  var y = document.getElementById("reenter_password_retail");
  if (y.type === "password") {
    y.type = "text";
  } else {
    y.type = "password";
  }
}

//Check Email
			function CheckEmail(){
			var ret_email = document.getElementById('retail_email');

			//alert(ret_email.value);
			if(ret_email.value != "")
			{
				//alert('username not null');
				if (window.XMLHttpRequest)
				{// code for IE7+, Firefox, Chrome, Opera, Safari
				  //alert('in if');
				  xmlhttp=new XMLHttpRequest();
				}
				else
				{// code for IE6, IE5
				  //alert('in else');
				  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange=function()
				{
					//alert(xmlhttp.readyState.value);
				  if (xmlhttp.readyState==4 && xmlhttp.status==200)
					{
						var value = xmlhttp.responseText;
						//alert(value.length);
						if(value.length > 1)
						{
							document.getElementById('ErrorSpan2').innerHTML="<font style='color:red'>&#10006; Email Id Already Exists.</font>";
							ret_email.focus();
						}
						else
						{
							document.getElementById('ErrorSpan2').innerHTML="<font style='color:green'>&#10003; Email Not Registered.. Proceed.</font>";
						}
					}
				  }
				xmlhttp.open("GET","retail_useremail_check_ajax.php?email="+ret_email.value,true);
				xmlhttp.send();
			}
		}

	</script> 
	
	<script>
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
		<a href="#">&nbsp;&nbsp;&nbsp;&nbsp;DigitalStorz.com</a>
		<!--<a href="#"><img class="logo_img" src="./images/logo.png"></a>-->
	</div>
	
	<div class="main_container">
		<div class="left_container">
			<div class="menu_heading">&#8803;&nbsp;&nbsp;MENU</div>
			<div id='cssmenu'>
				<ul>
				    <li class='active'><a href='https://www.digitalstorz.com'><span><img src="../images/home.png">&nbsp;&nbsp;Home</span></a></li>
                    <li><a href='https://www.digitalstorz.com/Admin/index.php'><span><img src="../images/account.png">&nbsp;&nbsp;Login</span></a></li>
				    <li><a href='https://www.digitalstorz.com/user-registration.php'><span><img src="../images/account.png">&nbsp;&nbsp;Register</span></a></li>
				</ul>
			</div>
		</div>
		<div class="right_container_index">
			<div class="page_title_div"><h1>USER REGISTRATION</h1></div>
			<div class="content_holder_small">

				<div class="content_holder_heading">&#8803;&nbsp;&nbsp;Register Here&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $mess; ?></div>
				
				<div class="content_holder_body">
				<form name="retail_login" onpaste="return false;" ondrop="return false;" autocomplete="off" method="post" action="./user-registration.php" onsubmit="return validate()">
					<div class="txt_lable">MOBILE NO : (This will be your Username)</div>
					<div><input type="text"  id="username_retail" name="username_retail" placeholder="Only Numbers Allowed" value=""  maxlength=10 onkeypress="return onlyNumberKey(event)" onblur="CheckUserName();"/>&nbsp;&#x2731;&nbsp;<span id="ErrorSpan" style=" color:blue; font-weight:bold; font-size:12px;"></span></div>
				
					<div class="txt_lable">Password :</div>
					<div><input class="text_box" type="password" placeholder="Min 8 Characters" name="password_retail" id="password_retail" value=""/>&nbsp;&#x2731;&nbsp;<input type="checkbox" onclick="ShowPassword1()">Show Password</div>
					
					<div class="txt_lable">Re-Enter Password :</div>
					<div><input class="text_box" type="password" placeholder="Min 8 Characters" name="reenter_password_retail" id="reenter_password_retail" value=""/>&nbsp;&#x2731;&nbsp;<input type="checkbox" onclick="ShowPassword2()">Show Password</div>
					
					<div class="txt_lable">Name : </div>
					<div><input class="text_box" type="text" name="retail_name" value=""  >&nbsp;&#x2731;&nbsp;  <span style="color:#000">(Owner Name)</span></div>
					
					<div class="txt_lable">Email :</div>
					<div><input class="text_box" type="text"  placeholder="Should be Valid Email Address" name="retail_email" id="retail_email" value="" onblur="CheckEmail();" onkeyup=" var start = this.selectionStart;  var end = this.selectionEnd;   this.value = this.value.toLowerCase();   this.setSelectionRange(start, end);">&nbsp;&#x2731;&nbsp;&nbsp;<span id="ErrorSpan2" style=" color:blue; font-weight:bold; font-size:12px;"></span></div>
					
					<div class="txt_lable">Store Name :</div>
					<div><input class="text_box" type="text" name="retail_store_name" value=""  onkeyup=" var start = this.selectionStart;  var end = this.selectionEnd;   this.value = this.value.toUpperCase();   this.setSelectionRange(start, end);">&nbsp;&#x2731;&nbsp; </div>
					
					<div class="txt_lable">Store Contact No :</div>
					<div><input class="text_box" type="text" placeholder="Only Numbers Allowed" name="retail_store_contact" value="" onkeypress="return onlyNumberKey(event)" maxlength="10">&nbsp;&#x2731;&nbsp;<span style="color:#000">(This will be Shown to Customer)</span></div>
					
					<div class="txt_lable">Store Address Line 1:</div>
					<div><input class="text_box" type="text" name="retail_store_address1" value=""  onkeyup=" var start = this.selectionStart;  var end = this.selectionEnd;   this.value = this.value.toUpperCase();   this.setSelectionRange(start, end);">&nbsp;&#x2731;&nbsp; <span style="color:#000">(Please Enter Correct Address)</span></div>
					
					<div class="txt_lable">Store Address Line 2:</div>
					<div><input class="text_box" type="text" name="retail_store_address2" value=""  onkeyup=" var start = this.selectionStart;  var end = this.selectionEnd;   this.value = this.value.toUpperCase();   this.setSelectionRange(start, end);">&nbsp;&#x2731;&nbsp; <span style="color:#000">(Please Enter Correct Address)</span></div>
					
					<div class="txt_lable">Referal Code (Mobile Number):</div>
					<div><input class="text_box" type="text" name="referal_code" maxlength="10" onkeypress="return onlyNumberKey(event)" value=""  ></div>
					<div class="txt_lable">Accept Terms & Conditions    <input type="radio" name="yes_no" value="yes">Yes</input> <input type="radio" name="yes_no" value="no">No</input> </div>
					<div class="submit_button_div"><input type="submit" name="submit" value="&nbsp;&nbsp;REGISTER&nbsp;&nbsp;"> </div> 

				</form>
				</div>
				
			</div>
		</div>
	</div><div class="clear"></div>
	<br>
	<div class="footer">
		Copyright © 2022, <a href="#">www.DigitalStorz.com</a>
	</div>
	
</body>
</html>