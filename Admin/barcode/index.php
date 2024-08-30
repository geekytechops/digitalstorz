<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>kolors</title>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->

<script type="text/javascript" src="bootstrap/js/jquery.min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<style>
.mtb-margin-top { margin-top: 20px; }
.top-margin { border-bottom:2px solid #ccc; margin:20px 0; display:block; font-size:1.3rem; line-height:1.7rem;}
.btn-success {
	cursor:pointer;
}
img.barcode {
    border: 1px solid #ccc;
    padding: 20px 10px;
    border-radius: 5px;
}
label {
    margin-bottom: 0rem;
    font-weight: bold;
    font-size: 13px;
}
.form-control {
    padding:0.2rem .75rem;
    font-size: 14px;
}
select.form-control:not([size]):not([multiple]) {
    height: auto;
}
#string, #size {
    height: 30px;
}
.btn {
    margin-bottom:30px;
}
</style>
</head>

<body>
   <!-- <div class="container-fluid">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4 text-center">-->
                <?php
                if(isset($_REQUEST['barcode_str'])) {
                    $string = $_REQUEST['barcode_str'];
                    $type='codabar';
                    $orientation='horizontal';
                    $size='20';
                    $print='true';
                    $qty_bar=$_REQUEST['qty'];

                    if($string != '') {
                        echo '<h5>Generated Barcode</h5>';
                        
                        for($i=0;$i<$qty_bar;$i++){
                        echo '<img alt="'.$string.'" src="barcode.php?text='.$string.'&codetype='.$type.'&orientation='.$orientation.'&size='.$size.'&print='.$print.'"/>';
                      
                      
                      
                        }
                    } else {
                        echo 'Please enter a string!';
                    }
                }
                ?>
                <br><br><br><br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.kolorsmobileservices.com/Unlocks/Admin/view-inventory.php">BACK TO INVENTORY</a>
          <!--  </div>
            <div class="col-md-4"></div>
        </div>
    </div>-->
	
</body>
</html>
