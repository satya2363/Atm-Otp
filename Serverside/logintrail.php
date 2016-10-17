<?php                                                          

$uname=$_POST["uname"];
$pword=$_POST["pword"];
$response = array();
if($uname='subbu')
{
$response["success"] = 1;
 $response["message"] = "CORRECT DETAILS";
 echo json_encode($response);
}

else

{
$response["success"] = 2;
 $response["message"] = "INCORRECT";
 echo json_encode($response);

}


?>