<?php

require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

date_default_timezone_set("Asia/Kolkata");
session_start();

// if (isset($_SESSION['session_username']) && isset($_SESSION['session_password'])) {
    include("./dbconnect.php");
    $cust_entry_id = $_REQUEST['job_id'];

    $sql_job_details1 = "SELECT * FROM adm_cust_mob_add WHERE entry_id=" . $cust_entry_id . " AND `store_id`=" . $_SESSION['session_store_id'];
    $query_disp1 = mysql_query($sql_job_details1);
    $result_disp1 = mysql_fetch_array($query_disp1);
    $num_rows_result = mysql_num_rows($query_disp1);

    // if ($num_rows_result > 0) {
        $sql_store_det = "SELECT * FROM `stores` WHERE `store_id`=" . $result_disp1['store_id'];
        $query_store_det = mysql_query($sql_store_det);
        $result_store_det = mysql_fetch_array($query_store_det);

        $receipt_date_temp = $result_disp1['added_date'];
        $timestamp = strtotime($receipt_date_temp);
        $receipt_date = date("d-m-Y", $timestamp);

        ob_start(); // Start output buffering to capture HTML
        ?>
        <!-- Place all your HTML content here -->

        <?php
        $html = ob_get_clean(); // Get the buffered HTML content

        // Include DOMPDF and initialize it

        $options = new Options();
        $options->set('defaultFont', 'Calibri');
        $dompdf = new Dompdf($options);

        // Load HTML into DOMPDF
        $dompdf->loadHtml($html);

        // (Optional) Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Save the PDF file to a specific directory
        $output = $dompdf->output();
        $file_path = 'uploads/' . 'Order_' . $_REQUEST['job_id'] . '.pdf'; // Adjust folder path as needed
        file_put_contents($file_path, $output);

        echo "PDF has been generated and saved successfully!";
    // } else {
        // header('Location: ./index.php');
    // }
    mysql_close($connection);
// }
?>
