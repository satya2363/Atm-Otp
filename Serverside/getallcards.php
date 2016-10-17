
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
 
/*
 * Following code will list all the cards
 */
 
// array for JSON response
$response = array();
 
// include db connect class
//require_once __DIR__ . '/db_connect.php';
 
// connecting to db
//$db = new DB_CONNECT();
 $uname=$_POST;
// get all products from products table
$result = mysqli_query("SELECT *FROM cards") or die(mysql_error());
 
// check for empty result
if (mysqli_num_rows($result) > 0) {
    // looping through all results
    // products node
    $response["products"] = array();
 
    while ($row = mysqli_fetch_array($result)) {
        // temp user array
        $product = array();
        $product["cname"] = $row["cname"];
        $product["cardno"] = $row["cardno"];
       
 
        // push single product into final response array
        array_push($response["products"], $product);
    }
    // success
    $response["success"] = 1;
 
    // echoing JSON response
    echo json_encode($response);
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "No cards found";
 
    // echo no users JSON
    echo json_encode($response);
}
?>