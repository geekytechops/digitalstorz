<html>
    <head>
    <title>How to disable previous dates in date picker using JQuery - devnote.in</title>
    <link href="https://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" rel="Stylesheet"
    type="text/css" />
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
</head>
<body>
    <h1>How to disable previous dates in date picker using JQuery</h1>
    Date : <input id="date_picker" type="text">
    <script language="javascript">
        $(document).ready(function () {
            $("#date_picker").datepicker({
                minDate: 0
            });
        });
    </script>
</body>
</html>