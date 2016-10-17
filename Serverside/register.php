//registering values into database
//username and password
<?php
//create a database connection
$con=mysqli_connect("teamkitesorg.fatcowmysql.com","subbu","kites","atmotp");
if(mysqli_connect_error($con))
{
	echo "Failed to connect to mysql".mysqli_connect_error();
}
?>
<?php


$uname=$_POST["uname"];
$pword=$_POST["pword"];

 if (isset($uname)&&!empty($uname)) 
{
 if (isset($pword)&&!empty($pword)) 
{
mysqli_query($con,"INSERT INTO login(uname,pword) VALUES('$uname','$pword')");
	
	$response["success"] = 1;
 $response["message"] = "REGISTERED SUCCESFULLY";
 echo json_encode($response);
}
else
{
	$response["success"] = 2;
 $response["message"] = "EMPTY FIELDS";
 echo json_encode($response);
}

}



else
{
	$response["success"] = 2;
 $response["message"] = "EMPTY FIELDS";
 echo json_encode($response);
}


?>

