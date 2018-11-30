<?php
function strpos_all($haystack, $needle) {
    $offset = 0;
    $allpos = array();
    while (($pos = strpos($haystack, $needle, $offset)) !== FALSE) {
        $offset   = $pos + 1;
        $allpos[] = $pos;
    }
    return $allpos;
}

//Check download
function check_download($src_table,$des_table,$seq_arr,$time_arr,$srcip_arr,$desip_arr,$length_arr,$protocol_arr)
{
    //$destination;
    $count = 0;
    $max_count = 0;
    $download_arr = array();
    foreach ($src_table as $ip)//For each IPs in ip table
    {$count = 0;$max_count= 0;
        for($i=0;$i<count($seq_arr);$i++)//check for the ip
        {
            if($srcip_arr[$i] == $ip)
            { 
                if($count == 0) //lock destination
                {
                    $destination = $desip_arr[$i];
                    
                }
                if($desip_arr[$i] == $destination)//Same pair of src and des ip
                {
                    if($protocol_arr[$i] == "0x6")//If it is TCP
                    {
                        if($length_arr[$i] == "1500")
                        {
                            $max_count++;
                            if($max_count == 17)
                            {
                                array_push($download_arr, $ip);
				$hold_ip = $ip.'q1';
				$mydb = fopen('sdn-db.txt','r');
				$txt = fread($mydb,filesize('sdn-db.txt'));
				$ip_arr = explode("/",$txt);
				fclose($mydb);
				if(!(in_array($hold_ip,$ip_arr))) {
					$txt.= '/'.$hold_ip;
					$mydb = fopen('sdn-db.txt','w');
					fwrite($mydb,$txt);
					fclose($mydb);
				}
                            }
                        }
                    }
                }
                $count++;
            }
            
            
        }
    }
    return $download_arr;
}

//Check video streaming
function check_video($src_table,$des_table,$seq_arr,$time_arr,$srcip_arr,$desip_arr,$length_arr,$protocol_arr)
{
    //$destination;
    $count = 0;
    $max_count = 0;
    $video_arr = array();
    foreach ($src_table as $ip)//For each IPs in ip table
    {$count = 0;$max_count= 0;//echo"$ip";echo"<br>";
        for($i=0;$i<count($seq_arr);$i++)//check for the ip
        {
            if($srcip_arr[$i] == $ip)
            {
                //echo"$count";echo"<br>";
                if($count == 0) //lock destination
                {
                   
                    $destination = $desip_arr[$i];
                    //echo"@@";echo"$destination";echo"<br>";
                }
                    if($desip_arr[$i] == $destination)//Same pair of src and des ip
                    {
                        if($protocol_arr[$i] == "0x11")//If it is UDP
                        {
                            if($length_arr[$i] == "1356") //Maxlength for UDP
                            {
                                $max_count++;
                                if($max_count == 17)
                                {
                                    array_push($video_arr, $ip);
					$hold_ip = $ip.'q2';
					$mydb = fopen('sdn-db.txt','r');
					$txt = fread($mydb,filesize('sdn-db.txt'));
					$ip_arr = explode("/",$txt);
					fclose($mydb);
					if(!(in_array($hold_ip,$ip_arr))) {
						$txt.= '/'.$hold_ip;
						$mydb = fopen('sdn-db.txt','w');
						fwrite($mydb,$txt);
						fclose($mydb);
					}
                                }
                            }
                        }
                    }
                    $count++;
            }
            
            
        }
    }
    return $video_arr;
}

//Check WebSite
function check_web($src_table,$des_table,$seq_arr,$time_arr,$srcip_arr,$desip_arr,$length_arr,$protocol_arr,$src_port_arr)
{
    //$destination;
    $count = 0;
    $max_count = 0;
    $web_arr = array();
    foreach ($src_table as $ip)//For each IPs in ip table
    {$count = 0;$max_count= 0;
    for($i=0;$i<count($seq_arr);$i++)//check for the ip
    {
        if($srcip_arr[$i] == $ip)
        {
            if($count == 0) //lock destination
            {
                $destination = $desip_arr[$i];
                
            }
            if($desip_arr[$i] == $destination)//Same pair of src and des ip
            {
                if($protocol_arr[$i] == "0x6")//If it is TCP
                {
                    if($src_port_arr[$i] == "80")
                    {
                        
                        $max_count++;
                        //echo"$ip";echo"@@@";echo"$src_port_arr[$i]";echo"<br>";
                        if($max_count == 5)
                        {
                            array_push($web_arr, $ip);
				$hold_ip = $ip.'q3';
				$mydb = fopen('sdn-db.txt','r');
				$txt = fread($mydb,filesize('sdn-db.txt'));
				$ip_arr = explode("/",$txt);
				fclose($mydb);
				if(!(in_array($hold_ip,$ip_arr))) {
					$txt.= '/'.$hold_ip;
					$mydb = fopen('sdn-db.txt','w');
					fwrite($mydb,$txt);
					fclose($mydb);
				}
                        }
                    }
                }
            }
            $count++;
        }
        
        
    }
    }
    return $web_arr;
}

//Check VoIP
function check_voip($src_table,$des_table,$seq_arr,$time_arr,$srcip_arr,$desip_arr,$length_arr,$protocol_arr)
{
    //$destination;
    $state = 0;
    $count = 0;
    $max_count = 0;
    $voip_arr = array();
    foreach ($src_table as $ip)//For each IPs in ip table
    {$count = 0;$max_count= 0;$state = 0;//echo"$ip";echo"<br>";
    for($i=0;$i<count($seq_arr);$i++)//check for the ip
    {
        if($srcip_arr[$i] == $ip)
        {
            //echo"$count";echo"<br>";
            if($count == 0) //lock destination
            {
                
                $destination = $desip_arr[$i];
                //echo"@@";echo"$destination";echo"<br>";
            }
            if($desip_arr[$i] == $destination)//Same pair of src and des ip
            {
                if($protocol_arr[$i] == "0x11")//If it is UDP
                {
                    if($length_arr[$i] == "1356") //Maxlength for UDP
                    {
                        $state = 1;
                        $max_count++;
                        if($max_count >= 17)
                        {
                            $state = 0;
                        }
                    }
                }
            }
            $count++;
        } 
    }
    // echo"$state";echo"<br>";
     if($state == 1)
     {
         //echo"$state";
         array_push($voip_arr,$ip);
		$hold_ip = $ip.'q4';
		$mydb = fopen('sdn-db.txt','r');
		$txt = fread($mydb,filesize('sdn-db.txt'));
		$ip_arr = explode("/",$txt);
		fclose($mydb);
		if(!(in_array($hold_ip,$ip_arr))) {
			$txt.= '/'.$hold_ip;
			$mydb = fopen('sdn-db.txt','w');
			fwrite($mydb,$txt);
			fclose($mydb);
		}
     }
    }
    return $voip_arr;
}

printf("Started");
$url = "http://localhost:8080/wm/pktinhistory/history/json";
$ch = curl_init();
echo "curl_inited";
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
$str = curl_exec($ch);
curl_close($ch);
// set url
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
//echo "YOLO";
//echo $str;
$seq_arr = array();
$time_arr = array();
$srcip_arr = array();
$desip_arr = array();
$length_arr = array();
$protocol_arr = array();
$src_table = array();
$des_table = array();
$src_port_arr = array();
$etc_table = array();
$hold_table = array();

//Extract all Seq Number
$hold_arr = strpos_all($str,"seq");
foreach ($hold_arr as $value)
{
    array_push($seq_arr, substr($str,$value+5,3));
    //echo substr($str,$value+5,3);
}

//Extract all Time
$hold_arr = strpos_all($str,"time");
foreach ($hold_arr as $value)
{
    array_push($time_arr, substr($str,$value+7,9));
    //echo substr($str,$value+7,9);
}

//Extract all source IP address
$hold_arr = strpos_all($str,"scrIp");
foreach ($hold_arr as $value)
{
    if(substr($str,$value+8,1) == "1")
    {
        $pos = 2;
    }
    else
    {
        $pos = 1;
    }
    if(!in_array(substr($str,$value+8+$pos,substr($str,$value+8,$pos)), $src_table))//Get sourceIP to table
    {
      
        array_push($src_table, substr($str,$value+8+$pos,substr($str,$value+8,$pos)));
    }
    array_push($srcip_arr, substr($str,$value+8+$pos,substr($str,$value+8,$pos)));
    //echo substr($str,$value+8,substr($str,$value+8,$pos));
}

//Extract all destination IP address
$hold_arr = strpos_all($str,"dstIP");
foreach ($hold_arr as $value)
{
    if(substr($str,$value+8,1) == "1")
    {
        $pos = 2;
    }
    else
    {
        $pos = 1;
    }
    if(!in_array(substr($str,$value+8+$pos,substr($str,$value+8,$pos)), $des_table))//Get destinationIP to table
    {
        array_push($des_table, substr($str,$value+8+$pos,substr($str,$value+8,$pos)));
    }
    array_push($desip_arr, substr($str,$value+8+$pos,substr($str,$value+8,$pos)));
    //echo substr($str,$value+8+$pos,substr($str,$value+8,$pos));
}

//Extract all length
$hold_arr = strpos_all($str,"totallength");
foreach ($hold_arr as $value)
{
    array_push($length_arr, substr($str,$value+15,substr($str,$value+14,1)));
    //echo substr($str,$value+15,substr($str,$value+14,1));
}

//Extract all protocol
$hold_arr = strpos_all($str,"protocol");
foreach ($hold_arr as $value)
{
    array_push($protocol_arr, substr($str,$value+12,substr($str,$value+11,1)));
    //echo substr($str,$value+12,substr($str,$value+11,1));
}

//Extract all src port
$hold_arr = strpos_all($str,"srcPort");
foreach ($hold_arr as $value)
{
    array_push($src_port_arr, substr($str,$value+11,substr($str,$value+10,1)));
    //echo substr($str,$value+11,substr($str,$value+10,1)); echo "<br>";
   
}

$download_hold = check_download($src_table,$des_table,$seq_arr,$time_arr,$srcip_arr,$desip_arr,$length_arr,$protocol_arr);
$video_hold = check_video($src_table,$des_table,$seq_arr,$time_arr,$srcip_arr,$desip_arr,$length_arr,$protocol_arr);
$web_hold = check_web($src_table,$des_table,$seq_arr,$time_arr,$srcip_arr,$desip_arr,$length_arr,$protocol_arr,$src_port_arr);
$voip_hold = check_voip($src_table,$des_table,$seq_arr,$time_arr,$srcip_arr,$desip_arr,$length_arr,$protocol_arr);

foreach ($download_hold as $temp)
{
    array_push($hold_table, $temp);
}
foreach ($video_hold as $temp)
{
    array_push($hold_table, $temp);
}
foreach ($web_hold as $temp)
{
    array_push($hold_table, $temp);
}
foreach ($voip_hold as $temp)
{
    array_push($hold_table, $temp);
}
foreach ($src_table as $all)
{
    $y = 1;
    foreach($hold_table as $in)
    {
        if($all == $in)
        {
            $y = 0;
        }
    }
    if($y == 1)
    {
        array_push($etc_table,$all);
    }
}
//print_r($etc_table);

printf("Download");
echo "<br>";
print_r($download_hold);
echo "<br>";
printf("Video");
echo "<br>";
print_r($video_hold);
echo "<br>";
printf("WebSite");
echo "<br>";
print_r($web_hold);
echo "<br>";
printf("Voip");
echo "<br>";
print_r($voip_hold);
echo "<br>";
printf("Others");
echo "<br>";
print_r($etc_table);
echo '<html><br><a href="index.php">Index</a></html>';




