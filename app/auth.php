<?php

function auth($username, $password){
	if(!file_exists("app/auth_log/$date2.log")){touch("./auth_log/$date2.log");}
	$date = date('m-d-Y.h:i:s.a', time());
	$date2 = date('m-d-Y', time());
	$dir = getcwd();
	$ip = $_SERVER['REMOTE_ADDR'];
	if(file_exists("app/blocked_ip/".$ip)){

		file_put_contents("app/auth_log/$date2.log","$date [AUTH] - Authentication for $ip failed!($ip) \n", FILE_APPEND);
		return false;
	}

  if(!file_exists("app/auth_log/debug.log")){touch("./auth_log/debug.log");}
  $password = escapeshellarg($password);
  file_put_contents("app/auth_log/debug.log","$date [DEBUG] - input pass $password");
  $envpass = $_ENV['PIVPNPASS'];
  $envuser = $_ENV['PIVPNUSER'];
  file_put_contents("app/auth_log/debug.log","$date [DEBUG] - env user $envuser");
  file_put_contents("app/auth_log/debug.log","$date [DEBUG] - env pass $envpass");
  return ($username==$_ENV['PIVPNUSER'] && $password==$_ENV['PIVPNPASS']);

}



?>
