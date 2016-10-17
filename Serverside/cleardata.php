//data base cleaning program
//OTP will be erased when time limit exceeds on execution of this program

<?php
$con=mysqli_connect("teamkitesorg.fatcowmysql.com","subbu","kites","atmotp");
if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?> 
<?php


$result=mysqli_query($con,"select * from otp");
$time= time();

while($row=mysqli_fetch_array($result))
{
 $otp=$row['otp'];
$amount=$row['amount'];
if(60<$time-$row['time'])
{
 $otp=$row['otp'];
mysqli_query($con,"update bank set otp_valid='0' where otp='$otp'");
mysqli_query($con,"update bank set balance=balance+'$amount'  where otp='$otp'");
mysqli_query($con,"delete from otp where otp='$otp'");
}
echo $row['time']; echo" \n";
echo $row['amount']; echo" \n";
echo $otp; echo" \n";


}





?>