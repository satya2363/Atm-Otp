<?php
//Database Connection
$con=mysqli_connect("teamkitesorg.fatcowmysql.com","subbu","kites","atmotp");
if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>

 
 <?php

$response = array();
$res=array();
 $flag=0;
$time=time();
//Character Initialization for OTP generation

$validCharacters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
$validCharNumber = strlen($validCharacters);
 
$index = mt_rand(0, $validCharNumber-1);
$randomCharacter = $validCharacters[$index];

$index1=  mt_rand(0, $validCharNumber-1);
$randomCharacter1 = $validCharacters[$index1];

$index2=  mt_rand(0, $validCharNumber-1);
$randomCharacter2 = $validCharacters[$index2];

//Fetching data from mobile

$cardno=$_POST["cardno"];
$pin=$_POST["pin"];
$amt=$_POST["amt"];

//retriving data from bank table
$bal=mysqli_query($con,"select  balance from bank where cardno='$cardno' ");

//deducting data from balance
$x =mysqli_fetch_array($bal);
$y=$x[0]-$amt;


$result=mysqli_query($con,"select * from bank where cardno='$cardno' AND pin='$pin'");


while($row=mysqli_fetch_array($result))
{
if(($cardno=$row['cardno'])&& ( $pin==$row['pin']))
$flag=1;
}
if($flag!=1)
{

$response["success"] = 4;
 $response["message"] = "INVALID CARD NUMBER OR PIN";
 $response["otp"]='00000000';
 echo json_encode($response);
}



else
{



//check wether OTP is already actve or not
$i=mysqli_query($con,"select  otp_valid from bank where cardno='$cardno' ");
$j =mysqli_fetch_array($i);


if($amt<=$x[0])
{

//if not active generate OTP
if(($j[0]==0||$j[0]==NULL))
{
//OTP generation

$a=rand(0,9);
$b=$randomCharacter;
$c=rand(0,9);
$d=$randomCharacter1;
$e=rand(0,9);
$f=rand(0,9);
$g=$randomCharacter2;
$h=rand(0,9);
$k = $a.$b.$c.$d.$e.$f.$g.$h;
checkotpagain:

//check if generated OTP is already present

$result=mysqli_query($con,"select * from otp ");

$o=0;

while($row=mysqli_fetch_array($result))
{

if($row['otp']==$k)
$o=1;
break;
}
//while($o==1)
if($o==1)
{
//if yes generate another one
$a=rand(0,9);
$b=$randomCharacter;
$c=rand(0,9);
$d=$randomCharacter1;
$e=rand(0,9);
$f=rand(0,9);
$g=$randomCharacter2;
$h=rand(0,9);
$k = $a.$b.$c.$d.$e.$f.$g.$h;
goto checkotpagain;


}

else
{
//send message to mobile

$response["success"] = 1;
 $response["message"] = " OTP GENERATED";
 $response["otp"]=$k;
 echo json_encode($response);

//update values like OTP,validity,balance in bank table
mysqli_query($con,"update bank set otp='$k' where cardno='$cardno' ");
mysqli_query($con,"update bank set otp_valid ='1' where cardno='$cardno' ");

mysqli_query($con,"update bank set balance='$y' where cardno='$cardno' ");

//insert into otp table the following values
mysqli_query($con,"insert into otp(otp,amount,otp_used,time) values('$k','$amt','','$time')");

}

}







else
{

$response["success"] = 3;
 $response["message"] = "OTP ACTIVE FOR THIS ACCOUNT";
 $response["otp"]='00000000';
 echo json_encode($response);
}
}
else
{

$res["success"] = 2;
 $res["message"] = "Balance is insufficient";
 $res["otp"]="00000000";
 echo json_encode($res);
}



}

 ?>