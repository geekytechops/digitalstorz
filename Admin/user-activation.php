<?php
session_start();
//print_r($_SESSION);
if(isset($_SESSION['session_username_activation']) && isset($_SESSION['session_password_activation'])){
include("./dbconnect.php");
$mess='';
//print_R($_SESSION);exit;

$sql_check_trail_availed="SELECT `trail_availed` FROM `cust_kolors_users_list` WHERE `username`=".$_SESSION['session_username_activation'];
$query_check_trail_availed=mysql_query($sql_check_trail_availed);
$result_check_trail_availed=mysql_fetch_array($query_check_trail_availed);
$trail_pack_availed=$result_check_trail_availed['trail_availed'];

//echo $trail_pack_availed;

if(isset($_REQUEST['submit'])){ //When form Submits
    $subscription_plan=$_REQUEST['subscription_plan'];
        $sql_upd="	UPDATE `cust_kolors_users_list` SET 
							`subscription_plan`='".$subscription_plan."',
							`status`=1,
							`trail_availed`='yes',
					 	    `subscription_date`=NOW()
					WHERE `username`=".$_SESSION['session_username_activation'];
		//echo $sql_upd;exit;
		$query_upd=mysql_query($sql_upd);
		if($query_upd){
			$mess="<font >Your Trail Pack is Activated. Please Logout and Login again to get Benifits of Trail pack..</font>";
		}else{
			$mess="Failed to Update Subscription..";
		}


}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DigitalStorz.com</title>
    <link rel="shortcut icon" href="./css/favicon1.jpeg" type="image/x-icon">
    <!-- CSS only -->
    <link rel="stylesheet" href="./css/playment-plans.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<style>

</style>
</head>
<body>
   <header>
      <div class="container">
         <h4><a href="http://digitalstorz.com/">DigitalStorz.com</a> </h4>
      </div>
   </header>
      <div class="container">
            <div class="d-flex align-items-center   log-out-div">
               <!--<p>your account is inactive, please select any of the below package and continue for premium services.</p>-->
               <div style='color:red;font-weight:bold;font-size=14px; text-align:center;'><?php echo $mess; ?></div>
               <a href="./logout.php"><input type="button" style="background-color: #ED6F06;  border: none;  color: white;  padding: 10px;  text-decoration: none; font-weight:bold;  margin: 4px 4px;   cursor: pointer;" name="logout" Value="LOGOUT" class="logout-button"></a>
               <!--<a href="./logout.php"><button class="btn logout-btn">LOGOUT</button></a>-->
            </div>
         <h1 class=" text-center choose-pricing">Choose Your Plan</h1>
        <div class="row row-cols-1 row-cols-md-5 mb-3 text-center">
            <?php
                if($trail_pack_availed !='yes'){
                ?>
            <div class="col">
               <div class="card mb-4 rounded-3 shadow-sm plans-1">
                  <div class="card-header">
                
                     <h4 class="my-0 fw-normal">Trail</h4>
                  </div>
                  <form name="trail" method="post" action="./user-activation.php">
                  <div class="card-body">
                     <h1 class="card-title pricing-card-title">Trail Access for 7 Days</h1>
                     <ul class="list-unstyled ">
                        <li class="actual-price" >600 </li>
                        <li class="offered-price">0</li>
                     </ul>
                     <input type="hidden" name="subscription_plan" value="trail">
                     <input  type="submit" name="submit" value="Get Free Trail" class="w-100 btn btn-lg ">
                  </div>
                  </form>
               </div>
            </div>
            <?php
            }
            ?>
            
            <!--<div class="col">
               <div class="card mb-4 rounded-3 shadow-sm plans-2">
                  <div class="card-header">
                     <h4 class="my-0 fw-normal">Monthly</h4>
                  </div>
                  <div class="card-body">
                     <h1 class="card-title pricing-card-title">Acces for 1 Month</h1>
                     <ul class="list-unstyled ">
                        <li class="actual-price" >2000</li>
                        <li class="offered-price">1799</li>
                     </ul>-->
                     <!--<button type="button" class="w-100 btn btn-lg">BUY</button>-->
                    <!-- <form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_KAJ8LNHWA886Jo" async> </script> </form>
                  </div>
               </div>
            </div>-->
            <!--<div class="col">
               <div class="card mb-4 rounded-3 shadow-sm  plans-3">
                  <div class="card-header  ">
                     <h4 class="my-0 fw-normal">Quarterly</h4>
                  </div>
                  <div class="card-body">
                     <h1 class="card-title pricing-card-title">Access for 3 Months</h1>
                     <ul class="list-unstyled ">
                        <li class="actual-price" >6000</li>
                        <li class="offered-price">4499</li>
                     </ul>-->
                     <!--<button type="button" class="w-100 btn btn-lg">BUY</button>-->
                     <!--<form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_KAJ8LNHWA886Jo" async> </script> </form>
                  </div>
               </div>
            </div>-->
            <!--<div class="col">
                <div class="card mb-4 rounded-3 shadow-sm  plans-4">
                   <div class="card-header  ">
                      <h4 class="my-0 fw-normal">Half-Yearly</h4>
                   </div>
                   <div class="card-body">
                      <h1 class="card-title pricing-card-title">Access for 6 Months</h1>
                      <ul class="list-unstyled ">
                        <li class="actual-price" >12000</li>
                        <li class="offered-price">7499</li>
                     </ul>-->
                      <!--<button type="button" class="w-100 btn btn-lg">BUY</button>-->
                      <!--<form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_KAJ8LNHWA886Jo" async> </script> </form>
                   </div>
                </div>
             </div>
             </div>
             <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm  plans-5">
                   <div class="card-header  ">
                      <h4 class="my-0 fw-normal">Yearly</h4>
                   </div>
                   <div class="card-body">
                      <h1 class="card-title pricing-card-title">2700 Jobs</h1>
                      <h1 class="card-title pricing-card-title">1 Year Validity</h1>
                      <ul class="list-unstyled ">
                       
                        <li class="offered-price">7500</li>
                     </ul>
                      <!--<button type="button" class="w-100 btn btn-lg">BUY</button>-->
                      <!--<form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_KAJ8LNHWA886Jo" async> </script> </form>
                   </div>
                </div>
             </div>-->
             
             
             <div class="col"></div>
             <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm  plans-5">
                   <div class="card-header  ">
                      <h4 class="my-0 fw-normal">Yearly Silver</h4>
                   </div>
                   <div class="card-body">
                      <h1 class="card-title pricing-card-title">2700 Jobs</h1>
                      <h1 class="card-title pricing-card-title">1 Year Validity</h1>
                      <ul class="list-unstyled ">
                   
                        <li class="offered-price">7500/-</li>
                     </ul>
                      <!--<button type="button" class="w-100 btn btn-lg">BUY</button>-->
                      <form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_KAJ8LNHWA886Jo" async> </script> </form>
                   </div>
                </div>
            </div>
             <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm  plans-5">
                   <div class="card-header  ">
                      <h4 class="my-0 fw-normal">Yearly Gold</h4>
                   </div>
                   <div class="card-body">
                      <h1 class="card-title pricing-card-title">3700 Jobs</h1>
                      <h1 class="card-title pricing-card-title">1 Year Validity</h1>
                      <ul class="list-unstyled ">
                   
                        <li class="offered-price">9000/-</li>
                     </ul>
                      <!--<button type="button" class="w-100 btn btn-lg">BUY</button>-->
                      <form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_KAJ8LNHWA886Jo" async> </script> </form>
                   </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm  plans-5">
                   <div class="card-header  ">
                      <h4 class="my-0 fw-normal">Yearly Diamond</h4>
                   </div>
                   <div class="card-body">
                      <h1 class="card-title pricing-card-title">5700 Jobs</h1>
                      <h1 class="card-title pricing-card-title">1 Year Validity</h1>
                      <ul class="list-unstyled ">
                   
                        <li class="offered-price">12500/-</li>
                     </ul>
                      <!--<button type="button" class="w-100 btn btn-lg">BUY</button>-->
                      <form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_KAJ8LNHWA886Jo" async> </script> </form>
                   </div>
                </div>
            </div>
         
         </div>
         <p class="activated-pra" >18% GST is applicable on all above packages at payment.</b></p><br><br>
         <div class="bottom-pra">
             
             <!--<p  style="font-size:26px; color:blue; text-align:center;"><b>MobiAlive Summit Offer (Valid for 28th & 29th August 2022).</b></b></p>-->
             <p  style="font-size:18px; color:red; text-align:center;">For Purchasing above packages <b>with Discounts</b>, Please contact <b>Help Desk of DigitalStorz.com on +91 9703939944.</b></p><br><br>
             <!--<p class="activated-pra" >For Purchasing above packages <b>without GST</b>, Please contact <b>Help Desk of DigitalStorz.com on +91 9703939944.</b></p>-->
         </div>
      </div>
     
    <!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>
</html>
<?php
mysql_close($connection);
}else{
header('Location: ./index.php');
}
?>