<!doctype html>
<html lang="en">

<?php  include('head.php'); ?>




    <body data-sidebar="dark">

<?php 

if(isset($_SESSION['session_username']) && isset($_SESSION['session_password'])){
    //print_r($_SESSION);
    $store_id=$_SESSION['session_store_id'];
    $session_store_name=$_SESSION['session_store_name'];
    $session_store_id=$_SESSION['session_store_id'];
    $transaction='legal';
    //echo $store_id;
    include("./dbconnect.php");
    $mess='';
    if(isset($_REQUEST['result_key'])){
    $result_key=$_REQUEST['result_key'];
    }else{
    $result_key='';
    }
    
    if(isset($_REQUEST['dmsg'])){
        $message_display=$_REQUEST['dmsg'];
            if( $message_display=='jas'){
                $mess="<h1><span style='color:green'>Job Added Successfully..</span></h1>";
            }elseif ($message_display=='mds'){
                 $mess="<h1><span style='color:green'>Mobile Delivered Successfully..</span></h1>";   
            }elseif ($message_display=='jus'){
                 $mess="<h1><span style='color:green'>Job Details Updated Successfully..</span></h1>";   
            }else {
                 $mess="";
            }
    }else{
        $mess='';
    }
    
    if(isset($_REQUEST['mode'])){
        $pr_id_ed=$_REQUEST['pr_id'];
        
        if($_REQUEST['mode']=='edit'){ // Action Edit Fetch Data
        exit;
            $sql_upd_pr="SELECT * FROM `adm_product_category` WHERE `p_cat_id`=".$pr_id_ed;
            $query_upd_pr=mysql_query($sql_upd_pr);
            $result_upd_pr=mysql_fetch_array($query_upd_pr);
            
            $upd_pr_id=$result_upd_pr['p_cat_id'];
            $upd_pr_name=$result_upd_pr['category_name'];
    
            $btn_value=" UPDATE ";
            $btn_name="update";
            
            
        }else if($_REQUEST['mode']=='del'){ // Action Delete
            $sql_check_entryid="SELECT * FROM adm_cust_mob_add WHERE entry_id=".$pr_id_ed." AND store_id=".$session_store_id;
            $query_check_entryid=mysql_query($sql_check_entryid);
            $rowcount = mysql_num_rows( $query_check_entryid );
        if($rowcount==0){
            $mess="No Such Order Found to delete.";
        }else{
          $sql_disable_pr_id="UPDATE `adm_cust_mob_add` SET `delete_status`='1' WHERE entry_id=".$pr_id_ed;
            $query_disable_pr_id=mysql_query($sql_disable_pr_id);
            
            if($query_disable_pr_id){
                $mess="<h1><span style='color:green'>Record Deleted..</span></h1>";
            }else{
                $mess="<h1><span style='color:red'>Failed to Delete..</span></h1>";
            }  
        }
            
            
        }
    }
    
    if(isset($_REQUEST['submit'])){
    $mobile_no_search=$_REQUEST['mobile_search'];
    $cust_name_search=$_REQUEST['name_search'];
    
    //echo $mobile_no_search;
    
    if($mobile_no_search !=''){
        $sql_cust="SELECT * FROM `adm_cust_mob_add` WHERE delete_status != '1' AND store_id='".$session_store_id."' AND (`cust_contact` LIKE '".$mobile_no_search."' OR `cust_alt_contact` LIKE '".$mobile_no_search."') ";
       //echo  $sql_cust ;exit;
    }elseif($cust_name_search!=''){
        $sql_cust="SELECT * FROM `adm_cust_mob_add` WHERE `customer_name`LIKE '%".$cust_name_search."%' AND delete_status != '1' AND store_id='".$session_store_id."'";
    }
    //echo $sql_cust;
    
    $result_key="mobile_search";
    
    }
    ?>

?>

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

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
                                    <h4 class="mb-sm-0">View Customer Jobs</h4>                                    
                                </div>
                            </div>
                            <div class="page_title_div"><?php echo $mess;?></div>
                        </div>
                        <!-- end page title -->
                        
            <div class="row">
                    <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <p class="card-title-desc">View / Update Customer Jobs.</p>
        
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs nav-justified nav-tabs-custom" role="tablist">
                                            <li class="nav-item waves-effect waves-light" id="pendingTable" onclick="getTableData('datatable-pending','pending')">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#pending" role="tab" id="pendingTableAnchor">
                                                    <i class="dripicons-user me-1 align-middle"></i> <span class="d-none d-md-inline-block">Pending</span>
                                                </a>
                                            </li>
                                            <li class="nav-item waves-effect waves-light" onclick="getTableData('datatable-completed','completed')">
                                                <a class="nav-link" data-bs-toggle="tab" href="#completed" role="tab">
                                                    <i class="dripicons-mail me-1 align-middle"></i> <span class="d-none d-md-inline-block">Completed</span>
                                                </a>
                                            </li>
                                            <li class="nav-item waves-effect waves-light" onclick="getTableData('datatable-delivered','delivered')">
                                                <a class="nav-link" data-bs-toggle="tab" href="#delivered" role="tab">
                                                    <i class="dripicons-gear me-1 align-middle"></i> <span class="d-none d-md-inline-block">Delivered</span>
                                                </a>
                                            </li>
                                            <li class="nav-item waves-effect waves-light" onclick="getTableData('datatable-rejected','rejected')">
                                                <a class="nav-link" data-bs-toggle="tab" href="#rejected" role="tab">
                                                    <i class="dripicons-gear me-1 align-middle"></i> <span class="d-none d-md-inline-block">Rejected</span>
                                                </a>
                                            </li>
                                            <li class="nav-item waves-effect waves-light" onclick="getTableData('datatable-delivery_rejected','delivery_rejected')">
                                                <a class="nav-link" data-bs-toggle="tab" href="#delvery_rejected" role="tab">
                                                    <i class="dripicons-gear me-1 align-middle"></i> <span class="d-none d-md-inline-block">Delivered (Rejected)</span>
                                                </a>
                                            </li>
                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link" data-bs-toggle="tab" href="#all" role="tab" onclick="getTableData('datatable-all','all')">
                                                    <i class="dripicons-home me-1 align-middle"></i> <span class="d-none d-md-inline-block">All</span> 
                                                </a>
                                            </li>
                                        </ul>
        
                                        <!-- Tab panes -->
                                        <div class="tab-content p-3">
                                            <div class="tab-pane" id="all" role="tabpanel">
                                                <table id="datatable-all" class="table table-bordered " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                <tr>
                                                    <th>Entry ID</th>
                                                    <th>Received Date</th>
                                                    <th>Customer Name</th>
                                                    <th>Brand / Model</th>
                                                    <th>Status</th>
                                                    <th>Defects</th>
                                                    <th>Phone Number</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                                </thead>
            
            
                                                <tbody>
                                                <tr>
                                                    <td>Tiger Nixon</td>
                                                    <td>System Architect</td>
                                                </tr>                                        
                                                </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane active" id="pending" role="tabpanel">
                                                <table id="datatable-pending" class="table table-bordered " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                    <tr>
                                                        <th>Entry ID</th>
                                                        <th>Received Date</th>
                                                        <th>Customer Name</th>
                                                        <th>Brand / Model</th>
                                                        <th>Status</th>
                                                        <th>Defects</th>
                                                        <th>Phone Number</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                    </thead>
                
                
                                                    <tbody>
                                                    <tr>
                                                        <td>Tiger Nixon</td>
                                                        <td>System Architect</td>
                                                    </tr>                                        
                                                    </tbody>
                                                    </table>
                                            </div>
                                            <div class="tab-pane" id="completed" role="tabpanel">
                                            <table id="datatable-completed" class="table table-bordered " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                    <tr>
                                                        <th>Entry ID</th>
                                                        <th>Received Date</th>
                                                        <th>Customer Name</th>  
                                                        <th>Brand / Model</th>
                                                        <th>Status</th>
                                                        <th>Defects</th>
                                                        <th>Phone Number</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                    </thead>
                
                
                                                    <tbody>
                                                    <tr>
                                                        <td>Tiger Nixon</td>
                                                        <td>System Architect</td>
                                                    </tr>                                        
                                                    </tbody>
                                                    </table>
                                            </div>
                                            <div class="tab-pane" id="delivered" role="tabpanel">
                                            <table id="datatable-delivered" class="table table-bordered " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                    <tr>
                                                        <th>Entry ID</th>
                                                        <th>Date</th>
                                                        <th>Customer Name</th>
                                                        <th>Brand / Model</th>
                                                        <th>Status</th>
                                                        <th>Defects</th>
                                                        <th>Phone Number</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                    </thead>
                
                
                                                    <tbody>
                                                    <tr>
                                                        <td>Tiger Nixon</td>
                                                        <td>System Architect</td>
                                                    </tr>                                        
                                                    </tbody>
                                                    </table>
                                            </div>
                                            <div class="tab-pane" id="rejected" role="tabpanel">
                                            <table id="datatable-rejected" class="table table-bordered " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                    <tr>
                                                        <th>Entry ID</th>
                                                        <th>Received Date</th>
                                                        <th>Customer Name</th>
                                                        <th>Brand / Model</th>
                                                        <th>Status</th>
                                                        <th>Defects</th>
                                                        <th>Phone Number</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                    </thead>
                
                
                                                    <tbody>
                                                    <tr>
                                                        <td>Tiger Nixon</td>
                                                        <td>System Architect</td>
                                                    </tr>                                        
                                                    </tbody>
                                                    </table>
                                            </div>
                                            <div class="tab-pane" id="delivery-rejected" role="tabpanel">
                                            <table id="datatable-delivery_rejected" class="table table-bordered " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                    <tr>
                                                        <th>Entry ID</th>
                                                        <th>Received Date</th>
                                                        <th>Customer Name</th>
                                                        <th>Brand / Model</th>
                                                        <th>Status</th>
                                                        <th>Defects</th>
                                                        <th>Phone Number</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                    </thead>
                
                
                                                    <tbody>
                                                    <tr>
                                                        <td>Tiger Nixon</td>
                                                        <td>System Architect</td>
                                                    </tr>                                        
                                                    </tbody>
                                                    </table>
                                            </div>
                                        </div>
                                    <input type="hidden" name="tableHandle" id="tableHandle" value="0">
                                    </div>
                                </div>
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
// $(document).ready(function() {
    // Function to initialize or reinitialize the DataTable
    function getTableData(tableName, tableType) {
        // Destroy any existing DataTable instance to avoid conflicts
        if ($.fn.DataTable.isDataTable("#" + tableName)) {
            $("#" + tableName).DataTable().destroy();
        }

        // Initialize or reinitialize the DataTable
        $("#" + tableName).DataTable({
            ajax: {
                url: 'view-entry-fetch-data.php', // Replace with the correct path to your PHP script
                type: 'GET',
                dataSrc: 'data',
                data: function(d) {
                    d.tableType = tableType; // Send the additional parameter
                }
            },
            "ordering": true,
            order: [],
            columns: [
                { data: 'entry_id' }, // Corresponds to the keys in your JSON
                { data: 'received_date' },
                { data: 'customer_name' },
                { data: 'brand_model' },
                { data: 'status' },
                { data: 'defects' },
                { data: 'contact' },
                { data: 'action' },
            ],
            language: {
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'></i>",
                    next: "<i class='mdi mdi-chevron-right'></i>"
                }
            },
            drawCallback: function() {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                // console.log($('#pendingTable a').hasClass('active'));
                // console.log($('#tableHandle').val());
                // if(!$('#pendingTable a').hasClass('active') && $('#tableHandle').val()==0){                    
                //     $('#tableHandle').val(1);
                //     $('#pendingTable').trigger('click');
                //     console.log('test');
                // }
                
            }
        });
        
    }

    // Example of using the function to initialize the table
    getTableData('datatable-pending', 'pending');
    
// });





</script>
    </body>
</html>
<?php
mysql_close($connection);
}else{
header('Location: ./index.php');
}
?>