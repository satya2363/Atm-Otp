 /*following code is for money withdrawal at atm */
<?php
// connection of database
$con=mysqli_connect("teamkitesorg.fatcowmysql.com","subbu","kites","atmotp");
if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?> 
<?php
//fetching data from mobile
$k = $_POST["otp"];
$time = time();
$b=mysqli_query($con,"select time from otp where otp='$k' ");

// if the time since generation of OTP exceeds one minute cash dosen't come out 

$x =mysqli_fetch_array($b);
$y= $time-$x['time'];

if($time-$x[0]>60)  //else cash can be collected
{

mysqli_query($con,"update bank set otp_valid ='0' where otp='$k' ");
$am=mysqli_query($con,"select  amount from otp where otp='$k' ");
$amt =mysqli_fetch_array($am);
echo $amt[0];echo"\n";

$bal=mysqli_query($con,"select  balance from bank where otp='$k' ");
$x =mysqli_fetch_array($bal);
$y=$x[0]+$amt[0];
echo $y;
mysqli_query($con,"update bank set balance='$y' where otp='$k' ");
echo"\n delayed\n";
echo $time;
mysqli_query($con,"delete from otp where otp='$k'");
}
else
{
echo "pleae collect cash";
mysqli_query($con,"delete from otp where otp='$k'");
mysqli_query($con,"update bank set otp_valid ='0' where otp='$k' ");
}

?>