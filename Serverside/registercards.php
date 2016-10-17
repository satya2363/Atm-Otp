//code for registering cards which are only available in bank databse table
<?php
$con=mysqli_connect("teamkitesorg.fatcowmysql.com","subbu","kites","atmotp");
if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>

<?php
$flag=0; $thread=0;$kite=0;
$uname=$_POST["uname"];
$cardno=$_POST["cardno"];
$cname=$_POST["cname"];
$pin=$_POST["pin"];

$result=mysqli_query($con,"select * from bank where cardno='$cardno'  ");
while($row=mysqli_fetch_array($result))
{


if($cardno==$row['cardno'])
{
$flag++;
echo $flag ;

}

else
echo $flag;



if($pin==$row['pin'])
{
$thread++;
echo $thread;

}

else

echo $thread;


}

$result1=mysqli_query($con,"select * from cards where uname='$uname' ");
while($row1=mysqli_fetch_array($result1))
{
if($cname==$row1['cname'])
$kite++;
}


if($kite>0)
{
$response["success"] =4 ;
 $response["message"] = "CARDNAME ALREADY EXISTS FOR THIS USER  ";
 echo json_encode($response);
}




if($flag==0)
{
$response["success"] =2 ;
 $response["message"] = "INVALID CARD NUMBER ";
 echo json_encode($response);

}

else if($thread==0)
{

$response["success"] = 3;
 $response["message"] = "INVALID  PIN";
 echo json_encode($response);
}

if($flag>0 && $thread>0 && $kite==0)
{

mysqli_query($con,"INSERT INTO cards(uname,cardno,cname,pin) VALUES('$uname','$cardno','$cname','$pin')");
$response["success"] = 1;
 $response["message"] = "CARD REGISTERED SUCCESFULLY";
 echo json_encode($response);


}




?>