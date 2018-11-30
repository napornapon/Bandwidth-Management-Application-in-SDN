<html>
<?php
	$s_qos = 'python qosmanager2.py -s';
	exec($s_qos,$output);
	echo '<b>'.$output[4].'</b><br>';
?>
<a href="e_qos.php">Enable QoS</a><br>
<a href="d_qos.php">Disable QoS</a><br>
<br>
<b>Packet Classify Section</b>
<br>
<a href="floodlight_rules.php">Classify</a><br>
<?php
	$mydb = fopen('sdn-db.txt','r');
	$txt = fread($mydb,filesize('sdn-db.txt'));
	$ip_arr = explode("/",$txt);
	fclose($mydb);
	echo '<b>Classified</b>'.'<br>';
	for($k =1; $k <count($ip_arr); $k++) {
		$ip_arr[$k] = preg_replace('/\s/', '', $ip_arr[$k]);
		$each_ip = explode('q',$ip_arr[$k]);
		$sip = $each_ip[0];
		$queue = $each_ip[1];
		echo $sip.'-->';
		if($queue == 1) {
			echo 'Download(200)'.'<br>';		
		}
		else if($queue == 2) {
			echo 'Video(20)'.'<br>';		
		}
		else if($queue == 3) {
			echo 'Website(2)'.'<br>';		
		}
		else if($queue == 4) {
			echo 'VoIP(20)'.'<br>';		
		}
		else {
			echo 'Unidentify'.'<br>';		
		}
	}
?>
<br>
<b>Bandwidth Control Section</b>
<br>
<a href="add_queue.php">Add Queue</a><br>
<a href="bw_ct.php">Bandwidth control</a><br>
<a href="re_qos.php">Clear QoS Queue</a><br>
</html>
