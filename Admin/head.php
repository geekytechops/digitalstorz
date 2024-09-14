    <?php  
    
    date_default_timezone_set("Asia/Kolkata");
error_reporting(0);
session_start();
//print_r($_SESSION);
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
$session_store_name=$_SESSION['session_store_name'];
$session_store_id=$_SESSION['session_store_id'];
$session_store_contact=$_SESSION['session_store_contact'];
$session_user_subscription_plan=$_SESSION['session_user_subscription_plan'];
//echo $session_user_subscription_plan;
$transaction='legal';
include("./dbconnect.php");
$mess='';
$active="active";
$customer_name=''; $mobile_defect='';$mobile_defect2=''; $mobile_defect3='';$mobile_defect4=''; $mobile_name=''; $cust_contact=''; $mobile_defect=''; $exp_delivery=date("Y-m-d", strtotime("tomorrow"));
$est_amount=''; $adv_amount=''; $remarks=''; 

}

    ?>
    <head>
        
        <meta charset="utf-8" />
        <title><?php echo $session_store_name;?> </title>

        <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- <link href="../css/style.css" rel="stylesheet" type="text/css"/> -->
        
        <link href="../panel-assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css">
        <!-- Bootstrap Css -->
        <link href="../panel-assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="../panel-assets/libs/@fullcalendar/core/main.min.css" type="text/css">
        <link rel="stylesheet" href="../panel-assets/libs/@fullcalendar/daygrid/main.min.css" type="text/css">
        <link rel="stylesheet" href="../panel-assets/libs/@fullcalendar/bootstrap/main.min.css" type="text/css">
        <link rel="stylesheet" href="../panel-assets/libs/@fullcalendar/timegrid/main.min.css" type="text/css">


        <link href="../panel-assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="../panel-assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <link href="../panel-assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />   

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <!-- Icons Css -->
        <link href="../panel-assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="../panel-assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <!-- <link href="../panel-assets/css/app.css" id="app-style" rel="stylesheet" type="text/css" /> -->        
            
        <link href="../panel-assets/css/patternlock.css" id="app-style" rel="stylesheet" type="text/css" />
        <link href="../panel-assets/css/panel.css" rel="stylesheet" type="text/css"/>

        <?php
        function isMobileDevice() {
            // Check for common mobile device keywords in the user agent string
            $userAgent = $_SERVER['HTTP_USER_AGENT'];
            $mobileKeywords = array('Mobi', 'Android', 'iPhone', 'iPad', 'iPod', 'BlackBerry', 'IEMobile', 'Opera Mini');
        
            // Loop through mobile keywords to find a match
            foreach ($mobileKeywords as $keyword) {
                if (stripos($userAgent, $keyword) !== false) {
                    return true; // Mobile device detected
                }
            }
            return false; // Desktop device detected
        }

        if(isMobileDevice()){
            ?>
            <style>

.main-content{
width:100%;
}

            </style>
    
            <?php
        }


        ?>
<style>

#vertical-menu-btn{
        display:none;
    }

/* @media only screen and (max-width: 767px) { */

    /* #vertical-menu-btn{
        display:block;
    } */
    .vertical-menu{
        display:block;
    }

    .main-content{
        overflow: hidden;
        margin-left: 250px !important;
    }
    .footer{
        left:250px;
    }

/* } */

            .logo {
            font-family: 'Arial', sans-serif; /* Font style */
            font-size: 20px; /* Font size */
            font-weight: bold; /* Bold text */
            color: #FF5722; /* Text color */
            text-transform: uppercase; /* Uppercase text */
            letter-spacing: 2px; /* Spacing between letters */
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2); /* Text shadow */
            background: linear-gradient(45deg, #FFC107, #FF5722); /* Gradient background */
            -webkit-background-clip: text; /* Clipping background to text */
            color: transparent; /* Text color transparent for gradient */
            display: inline-block; /* Inline-block to contain text */
            padding: 0; /* Padding around text */
        }

        .pattern_lock{
		display: flex;
    justify-content: center;
    align-content: center;
    flex-direction: column;
    align-items: center;
	}
	        #lock {
            width: 280px;
            height: calc(100% - 15vh);
            padding-bottom: 12vh;
            min-height: 120px;
        }

        .stars {
            margin: auto;
            display: block;
        }
        
        /* .main-content {
        margin-left: 250px !important;
        overflow: hidden;
    } */
</style>
    </head>