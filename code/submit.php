<?session_start() ;
$path = "/var/www/cloud/" . $_POST['dir'] . "/" . $_FILES['file']['name'];
$home = "http://localhost/cloud/main.php" ;
echo $path ; 
if ( file_exists ($path)) {
		echo "<h1>" .$_FILES['file']['name'] . " ALREADY EXISTS<br />" ;
		?><a href=<?echo $home ;?>> Go Back </a></h1><?
		$_SESSION['msg'] = "" ;
}
else {
	move_uploaded_file($_FILES['file']['tmp_name'] , $path  ) or die("hell!") ;
	$_SESSION['msg'] = "UPLOADED" ; 
	header( 'Location: ' . $home ) ;
	exit ; 
}
?>
	
