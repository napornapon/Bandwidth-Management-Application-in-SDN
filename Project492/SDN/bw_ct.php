<?php
	$url = 'http://127.0.0.1:8080/wm/device/';
	$string = file_get_contents($url);
	$x = json_decode($string,true);
	$y =0;
	for($i = 0; $i < count($x); $i++) {
		if($x[$i]['attachmentPoint'][0]['switchDPID'] == '00:00:00:00:00:00:00:01'){
			$dip[$y] = $x[$i]['ipv4'][0];
			$y++;
		}
	}

	$mydb = fopen('sdn-db.txt','r');
	$txt = fread($mydb,filesize('sdn-db.txt'));
	$ip_arr = explode("/",$txt);
	fclose($mydb);
	for($k =1; $k <count($ip_arr); $k++) {
		$ip_arr[$k] = preg_replace('/\s/', '', $ip_arr[$k]);
		$each_ip = explode('q',$ip_arr[$k]);
		$sip = $each_ip[0];
		if($each_ip[1] == 1) {
			$queue = 3;
		}
		else if($each_ip[1] == 2) {
			$queue = 2;
		}
		else if($each_ip[1] == 3) {
			$queue = 1;
		}
		else if($each_ip[1] == 4) {
			$queue = 2;
		}
		else {
			$queue = 0;
		}
	
		$array_name1 = explode('.',$sip);
		$name1 = $array_name1[0];
		for($i = 1; $i < count($array_name1); $i++) {
			$name1 = $name1."_".$array_name1[$i];
		}

		for($j =0; $j < count($dip); $j++) {
			$array_name2 = explode('.',$dip[$j]);
			$name2 = $array_name2[0];
			for($i = 1; $i < count($array_name2); $i++) {
				$name2 = $name2."_".$array_name2[$i];
			}
			$drule = 'sudo python qospath2.py -d -N '.$name1.'-'.$name2;
			exec($rule,$output3);
			$rule = 'sudo python qospath2.py -a -S '.$sip.' -D '.$dip[$j].' -N '.$name1.'-'.$name2." -J '".'{"eth-type":"0x0800","queue":"'.$queue.'"}'."'";
		
		echo $rule;
		exec($rule,$output4);
		}
	}
?>
<html>
<a href="index.php">Index</a>
</html>





