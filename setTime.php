<?php
$myinfile = fopen("time.txt", "r") or die("Unable to open file!");
$input=explode(" ", fread($myinfile,filesize("time.txt")));
fclose($myinfile);
$old_hour = $input[0];
$old_min = $input[1];
$old_sec = $input[2];
$hour = date('H', time());
$min = date('i', time());
$sec = date('s', time());
if (intval($old_sec) +intval($old_min)*60 + (intval($old_hour)+1)*60*60 < intval($sec) + intval($min)*60 + intval($hour)*60*60  ) {
	$myfile = fopen("time.txt", "w") or die("Unable to open file!");
	fwrite($myfile, $txt);
	$txt = "".$hour." ".$min." ".$sec;
	fwrite($myfile, $txt);
	fclose($myfile);
}
?> 
