<!doctype html>
<html lang="en">

<?php  include('head.php'); ?>

<body data-sidebar="dark">

<?php 
date_default_timezone_set("Asia/Kolkata");
session_start();
if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
include("./dbconnect.php");
$mess='';
$upd_ser_id='';
$upd_ser_name='';

$btn_value=" Add Category ";
$btn_name="submit";

if(isset($_REQUEST['type'])){

    if($_REQUEST['type'] == 1) {
        $type=1;
    }else if($_REQUEST['type']==2){
        $type=2;
    }else{
        $type=3;
    }


}else{
    $type=1;
}

if(isset($_REQUEST['submit'])){ //When form Submits
		$category_name=$_REQUEST['category_name'];

		//Inserting Data
		$sql_ins="INSERT INTO `adm_product_category`(`category_name`, `added_date`,`status`,`cat_type`) VALUES 
		('".$category_name."',NOW(),1,$type)";
		$query_ins=mysql_query($sql_ins);
		if($query_ins){ 
			$mess="<font color='#fff'>Category Added Succesfully..</font>";
		}else{
			$mess="Failed to Add..";
		}
} 
if(isset($_REQUEST['update'])){ //When Edit form submits
		
		//print('<pre>');print_r($_REQUEST);exit;
		
		$pr_id_hidden_upd=$_REQUEST['hidden_pr_id'];
		$pr_name_edit=$_REQUEST['category_name'];
		
		
		$sql_upd="	UPDATE `adm_product_category` SET  
							`category_name`='".$pr_name_edit."'							
					WHERE `cat_type` = $type AND `p_cat_id`=".$pr_id_hidden_upd;
		//echo $sql_upd;exit;
		$query_upd=mysql_query($sql_upd);
		if($query_upd){
			$mess="<font color='#fff'>Service Updated Succesfully..</font>";
		}else{
			$mess="Failed to Update..";
		}
}
if(isset($_REQUEST['mode'])){
	$pr_id_ed=$_REQUEST['pr_id'];
	
	if($_REQUEST['mode']=='edit'){ // Action Edit Fetch Data
		$sql_upd_pr="SELECT * FROM `adm_product_category` WHERE `cat_type` = $type AND `p_cat_id`=".$pr_id_ed;
		$query_upd_pr=mysql_query($sql_upd_pr);
		$result_upd_pr=mysql_fetch_array($query_upd_pr);
		
		$upd_pr_id=$result_upd_pr['p_cat_id'];
		$upd_pr_name=$result_upd_pr['category_name'];

		$btn_value=" UPDATE ";
		$btn_name="update";
		
		
	}else if($_REQUEST['mode']=='del'){ // Action Delete
		$sql_disable_pr_id="UPDATE `adm_product_category` SET `status`='0' WHERE `cat_type` = $type AND p_cat_id=".$pr_id_ed;
		$query_disable_pr_id=mysql_query($sql_disable_pr_id);
		if($query_disable_pr_id){
			$mess="Product Category Disabled Succesfully..";
		}else{
			$mess="Failed to Disable..";
		}
	}
}
?>

        <!-- Begin page -->
        <div id="layout-wrapper">

                       

            <!-- ========== Left Sidebar Start ========== -->
            <?php include('header.php') ?>
            <?php include('sidebar.php') ?>
            <!-- Left Sidebar End -->

            

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">ADD PRODUCT CATEGORIES</h4>

                                </div>
                            </div>
							<div style="color:green" class="page_title_div"><?php echo $mess;?></div>
                        </div>
                        <!-- end page title -->
                        
            <div class="row">
                <div class="card">
                    <div class="card-body">
                           
                    <form name="category_add" class="col-md-4" method="post" action="./add-product-categories-ui.php" onsubmit="return validate()">
					<div class="txt_lable">Product Category Name:</div>
					<input type="hidden" name="hidden_pr_id" value="<?php echo $upd_pr_id;?>">
					<div class="d-flex">
                        <input type="text" class="form-control" name="category_name" value="<?php echo $upd_pr_name;?>" >
                        <input class="btn btn-primary ms-2" type="submit" name="<?php echo $btn_name;?>" value="<?php echo $btn_value?>" />
                    </div>
				</form>				
                    
                    </div>
                </div>
		    </div>
            <div class="row">
                <div class="card">
                    <div class="card-body">
                           
                    <table class="order_hisory_table table table-bordered">
													<tr class="table_heading">
														<td><b>Category ID</b></td>
														<td><b>Category Name</b></td>
														<td><b>Added Date</b></td>
														<td><b>Status</b></td>
														<td><b>Edit</b></td>
														<td><b>Delete</b></td>
													</tr>
											<?php
												$sql_prod="SELECT * FROM `adm_product_category` where status='1'";
												$query_prod=mysql_query($sql_prod);
												while($result_prod=mysql_fetch_array($query_prod)){
													echo '<tr>
															<td>'.$result_prod['p_cat_id'].'</td>
															<td>'.$result_prod['category_name'].'</td>
															<td>'.$result_prod['added_date'].'</td>
															<td>'.$result_prod['status'].'</td>
															<td><a class="btn btn-info btn-sm" href="./add-product-categories-ui.php?mode=edit&pr_id='.$result_prod['p_cat_id'].'">Edit</a></td>
															<td><a class="btn btn-danger btn-sm" href="./add-product-categories-ui.php?mode=del&pr_id='.$result_prod['p_cat_id'].'">Delete</a></td>
													</tr>';
												}
											?>
												</table>

                    </div>
                </div>
		    </div>
	

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
                
                <?php include('footer.php') ?>
                
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->
        


        <!-- JAVASCRIPT -->
         
        <?php include('footer-includes.php') ?>

<script>

function validate()
            {
				if (document.category_add.category_name.value == "")
                {
                    document.category_add.category_name.focus();
                    alert("Enter Category Name");
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
    </body>
</html>
<?php
mysql_close($connection);
}else{
header('Location: ./index.php');
}
?>