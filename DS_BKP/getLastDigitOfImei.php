<?php
	$q = intval($_GET['q']);

		$imei_no=$q;
		//echo $imei_no;
		$imeiarray = str_split($imei_no);
		
		//print_r($imeiarray);
		
		$sum1_temp=$imeiarray[13]*2;
		$sum2_temp=$imeiarray[11]*2;
		$sum3_temp=$imeiarray[9]*2;
		$sum4_temp=$imeiarray[7]*2;
		$sum5_temp=$imeiarray[5]*2;
		$sum6_temp=$imeiarray[3]*2;
		$sum7_temp=$imeiarray[1]*2;
		
		//getting sum 1
		if(strlen($sum1_temp) >1){
			$sum1_arr = str_split($sum1_temp);
			$sum1= array_sum($sum1_arr);
		}else{
			$sum1=$sum1_temp;
		}
		//getting sum 2
		if(strlen($sum2_temp) >1){
			$sum2_arr = str_split($sum2_temp);
			$sum2= array_sum($sum2_arr);
		}else{
			$sum2=$sum2_temp;
		}
		//getting sum 3
		if(strlen($sum3_temp) >1){
			$sum3_arr = str_split($sum3_temp);
			$sum3= array_sum($sum3_arr);
		}else{
			$sum3=$sum3_temp;
		}
		//getting sum 4
		if(strlen($sum4_temp) >1){
			$sum4_arr = str_split($sum4_temp);
			$sum4= array_sum($sum4_arr);
		}else{
			$sum4=$sum4_temp;
		}
		//getting sum 5
		if(strlen($sum5_temp) >1){
			$sum5_arr = str_split($sum5_temp);
			$sum5= array_sum($sum5_arr);
		}else{
			$sum5=$sum5_temp;
		} 
		//getting sum 6
		if(strlen($sum6_temp) >1){
			$sum6_arr = str_split($sum6_temp);
			$sum6= array_sum($sum6_arr);
		}else{
			$sum6=$sum6_temp;
		}
		//getting sum 7
		if(strlen($sum7_temp) >1){
			$sum7_arr = str_split($sum7_temp);
			$sum7= array_sum($sum7_arr);
		}else{
			$sum7=$sum7_temp;
		} 
		
		$regular_digits_sum=$imeiarray[0]+$imeiarray[2]+$imeiarray[4]+$imeiarray[6]+$imeiarray[8]+$imeiarray[10]+$imeiarray[12];
		$doubled_sum=$sum1+$sum2+$sum3+$sum4+$sum5+$sum6+$sum7;
		
		//echo 'doublesum----'.$doubled_sum;
		//echo '               Regular----'.$regular_digits_sum;
		
		$totalSumOfImei=$doubled_sum+$regular_digits_sum;
		
		$last_digit_temp=($totalSumOfImei%10);
		if($last_digit_temp==0){
			$last_digit=$last_digit_temp;
		}else{
			$last_digit=10-$last_digit_temp;
		}
	//echo '<input style="width:50px;" type="text" disabled="yes" name="last_digit_imei" value="'.$last_digit.'"/>';
	echo $last_digit;
?>