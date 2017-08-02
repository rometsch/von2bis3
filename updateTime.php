<?php
/*	Load the last line from log file if it exists.
	Create a log file otherwise. */

$myinfile = fopen("time.txt", "r") or die("Unable to open file!");
$input=explode(" ", fread($myinfile,filesize("time.txt")));
fclose($myinfile);
$old_hour = $input[0];
$old_min = $input[1];
$old_sec = $input[2];
$hour = date('H', time());
$min = date('i', time());
$sec = date('s', time());

/*	Check if it is allowed to reset the time.
	A reset is allowed after a full hour passed since the last reset. */
$next_allowed_reset_time = intval($old_sec) +intval($old_min)*60 + (intval($old_hour)+1)*60*60;
$current_time = intval($sec) + intval($min)*60 + intval($hour)*60*60;
$is_reset_allowed = $current_time > $next_allowed_reset_time;
if ( $is_reset_allowed ) {
	$myfile = fopen("time.txt", "w") or die("Unable to open file!");
	fwrite($myfile, $txt);
	$txt = "".$hour." ".$min." ".$sec;
	fwrite($myfile, $txt);
	fclose($myfile);
	$old_hour = $hour;
	$old_min = $min;
	$old_sec = $sec;
}
echo "".$old_hour." ".$old_min." ".$old_sec;
?> 
