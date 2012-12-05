<?
$response =  $_GET['job'] ;
$tmp = "/tmp/job" ; 
$myfile = fopen($tmp , 'w')  ;
fwrite($myfile , $response ) ; 
fclose($myfile) ;
shell_exec("curl localhost:5432") ;
?>
