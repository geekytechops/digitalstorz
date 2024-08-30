<?php

  $mobile = "9703777755";
  $message = "Test message From SMS INDIA";
  $api_username = "demotr";
  $api_password = "123tr";
  $sender = "INDSMS";
  $type = "TEXT";
  $message = urlencode($message);

  $apiUrl ="https://app.indiasms.com/sendsms/bulksms.php";
  $url =$apiUrl."?username=".$api_username."&password=".$api_password."&type=".$type."&sender=".$sender."&mobile=".$mobile."&message=".$message;

  if( function_exists("curl_init")){
    $ch = curl_init();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_TIMEOUT, 30 );
    curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 0 );
    curl_setopt ( $ch, CURLOPT_HEADER, 0 );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
    $response = curl_exec ( $ch );
    curl_close($ch);
  }else{
    $return_val = file($url);
    $response = $return_val[0];
  }

  list($send,$msgcode) = explode("|",$response);
  if (trim($send) == "SUBMIT_SUCCESS") {
    echo "Sent SMS successfully.";
  }else{
    echo "Unable to Send SMS successfully.";
    echo $response;
  }

?>