<html>
<?php
	$re_qos = 'sudo ovs-vsctl -- --all destroy qos';
	exec($en_qos,$output);
	$re_que = 'sudo ovs-vsctl -- --all destroy queue';
	exec($re_que,$output2);
?>
<a href="index.php">Index</a>
</html>



