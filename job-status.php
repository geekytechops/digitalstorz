
<?php  include("./Admin/dbconnect.php"); ?>
<?php

$sql_disp="SELECT * FROM adm_cust_mob_add WHERE entry_id=".$_REQUEST['entry_id'];
$query_disp=mysql_query($sql_disp);
$rowcount = mysql_num_rows( $query_disp );
if($rowcount==0){
    $message = "No Status found for the Invoice ";
}else{

    

}


?>
<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>404 Error | Upzet - Admin & Dashboard Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="panel-assets/images/favicon.ico">

        <!-- Bootstrap Css -->
        <link href="panel-assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="panel-assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="panel-assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    <body class="">
        <div class="my-5 pt-5">
            <!-- error page content -->
            <div class="w-100">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6 col-xl-5">
                            <div class="text-center">
                                <div>
                                    <h1 class="display-2 error-text fw-bold">Your Preparing Status</h1>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                        
                                    </thead>
                                    <tbody>
                                        <tr><td>Name</td><td>test</td></tr>
                                        <tr><td>test</td><td>test</td></tr>
                                        <tr><td>test</td><td>test</td></tr>
                                        <tr><td>test</td><td>test</td></tr>
                                    </tbody>
                                </table>
                                <div>
                                    <input type="text" name="entry_id" id="entry_id" class="form-control">
                                    <div class="mt-4">
                                        <a href="index.html" class="btn btn-primary">Submit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- error auth page content -->

        </div>
        <!-- end error page -->

        <!-- JAVASCRIPT -->
        <script src="panel-assets/libs/jquery/jquery.min.js"></script>
        <script src="panel-assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="panel-assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="panel-assets/libs/simplebar/simplebar.min.js"></script>
        <script src="panel-assets/libs/node-waves/waves.min.js"></script>

    </body>
</html>
