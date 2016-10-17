//login authentication code
//if given username and password are not matched in database user doesn't login else he may login


<?php

$con=mysqli_connect("teamkitesorg.fatcowmysql.com","subbu","kites","atmotp");

if(mysqli_connect_error($con))
{
	echo "failed to connect:" .mysqli_connect_error();
	
	}
else
{

}

?>

<?php
$flag=0;response=array();
response1=array();
//check
$uname=$_POST["uname"];
$pword=$_POST["pword"];

$result=mysqli_query($con,"select  * from login  where  uname='$uname' AND pword='$pword'");
while($row=mysqli_fetch_array($result))
{
if(($pword==$row['pword'])&& ($uname==$row['uname']))
$flag=1;
}
if($flag==1)
{
echo $uname;
echo $pword;
$response["success"] = 2;
 $response["message"] = "CORRECT DETAILS";
 echo json_encode($response);
}



else
{

$response1["success"] = 1;
 $response1["message"] = "INVALID";
 echo json_encode($response);
}

?>