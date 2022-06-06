<?php
//Check for valid session:
session_start();
include('functions.php');
if(!isset($_SESSION['username'])){
	die("You must be logged in to view this page!");
}
if(!isset($_POST['profile'])){ die("No profile name selected!"); }
$days = 1080; // Days is set with a default prompt value.
if (isset($_POST['days']))
{
    $days = $_POST['days'];
}
$pro = $_POST['profile'];
add_vpn_profile($pro, $days);
//Run selected script, but only if it exists in the scr_up folder.
function add_vpn_profile($profile, $d) {

    // Open a handle to expect in write mode
    $p = popen('/usr/bin/expect','w');

    // Log conversation for verification
    $log = $_SERVER['HOME'].'/app/tmp/passwd_' . md5($profile . time());
    if(!file_exists($log)){touch($log);}
    $cmd .= "log_file -a \"$log\"; ";

    // Spawn a shell as $user
    $cmd .= "spawn /bin/bash; ";
    // Change the unix password
    $cmd .= "send \"pivpn -a\\r\"; ";
    $cmd .= "expect \"Enter a Name for the Client:   \"; ";
    $cmd .= "send \"$profile\\r\"; ";
    $cmd .= "expect \"How many days should the certificate last?  $d\"; ";
    $cmd .= "send \"\\b\\b\\b\\b$d\\r\"; ";
    $cmd .= "expect \"for easy transfer.\"; ";
    // Commit the command to expect & close
    fwrite($p, $cmd); pclose ($p);

    // Read & delete the log
    $fp = fopen($log,'r');
    $output = fread($fp, 2048);
    fclose($fp); unlink($log);
	print "Notification : $output ";
    $output = explode("\n",$output);


    return $output;
}

?>
