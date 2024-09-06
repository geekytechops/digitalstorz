<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Label with Barcode</title>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <style>
        .label-container {
            font-family: 'Arial', sans-serif;
            border: 1px dotted #000;
            width: 250px;
            padding: 10px;
        }
        .barcode {
            margin-bottom: 10px;
        }
        .label-text {
            border-bottom: 1px dotted #000;
            padding: 2px 0;
            font-size: 14px;
        }
        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Label Structure -->
    <div class="label-container">
        <svg id="barcode" class="barcode"></svg>
        <div class="label-text bold">SCM6508</div>
        <div class="label-text">2021-01-29 11:55:35.0</div>
        <div class="label-text bold">MRS. JOHN DOE</div>
        <div class="label-text">9346794004</div>
        <div class="label-text">MOBILE SS A10</div>
    </div>

    <script>        
        JsBarcode("#barcode", "SCM6508", {
            format: "CODE128",  
            lineColor: "#000",  
            width: 2,           
            height: 40,         
            displayValue: false 
        });
    </script>
</body>
</html>
