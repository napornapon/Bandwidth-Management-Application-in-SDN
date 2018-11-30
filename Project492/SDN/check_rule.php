<?php
	$mydb = fopen('sdn-db.txt','r');
	$txt = fread($mydb,filesize('sdn-db.txt'));
	$ip_arr = explode("/",$txt);
	fclose($mydb);
	echo 'Classified'
	for($k =1; $k <count($ip_arr); $k++) {
		$ip_arr[$k] = preg_replace('/\s/', '', $ip_arr[$k]);
		$each_ip = explode('q',$ip_arr[$k]);
		$sip = $each_ip[0];
		$queue = $each_ip[1];
		echo $sip.'-->';
		if($queue == 1) {
			echo 'Download'.'<br>';		
		}
		else if($queue == 2) {
			echo 'Video'.'<br>';		
		}
		else if($queue == 3) {
			echo 'Website'.'<br>';		
		}
	}
?>
<html>
<a href="index.php">Index</a>
</html>





