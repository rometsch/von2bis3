<?php
/* Get the current time first. */
$hour = date('H', time());
$min = date('i', time());
$sec = date('s', time());
/*	Load the last line from log file if it exists.
	Create a log file otherwise. */
$logfile_path = "log.txt";
$have_log = file_exists($logfile_path);
if ($have_log) {
	$file = new SplFileObject($logfile_path);
	$file->seek(PHP_INT_MAX); // cheap trick to seek to EoF
	$total_lines = $file->key(); // last line number
	$file->seek($total_lines - 1);
	$last_line = $file->current();
	
	$input=explode(" ", $last_line);
	fclose($myinfile);
	$old_hour = $input[0];
	$old_min = $input[1];
	$old_sec = $input[2];
}
else {
	$old_hour = $hour;
	$old_min = $min;
	$old_sec = $sec;
}


/*	Check if it is allowed to reset the time.
	A reset is allowed after a full hour passed since the last reset. */
$next_allowed_reset_time = intval($old_sec) +intval($old_min)*60 + (intval($old_hour)+1)*60*60;
$current_time = intval($sec) + intval($min)*60 + intval($hour)*60*60;
$is_reset_allowed = $current_time > $next_allowed_reset_time;

/*	Reset time if its allowed and write to log. */
if ( $is_reset_allowed or !$have_log ) {
	$myfile = fopen($logfile_path, "a") or die("Unable to open file!");
	fwrite($myfile, $txt);
	$txt = "".$hour." ".$min." ".$sec."\n";
	fwrite($myfile, $txt);
	fclose($myfile);
	$old_hour = $hour;
	$old_min = $min;
	$old_sec = $sec;
}
echo "".$old_hour." ".$old_min." ".$old_sec;
?> 
