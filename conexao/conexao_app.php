<?php

$db_hostname = "localhost";
$db_username = "root";
$db_password = "root";
$db_database = "APP";

//:Create connection
$conn = mysqli_connect($db_hostname,$db_username,$db_password,$db_database);

//:Checking connection
if(mysqli_connect_errno()){
	echo "Failed to connect to MySQL: ".mysqli_connect_error(); 
}

$sql = "select * from locations";

//:Checking if there are results
if($result = mysqli_query($con,$sql)){
	//:If so, create a result array and a temporary one to hold the data
	$resultArray = array();
	$tempArray = array();

	while($row = $result->fetch_object()){
		//:Add each row into our result array
		$tempArray = $row;
		array_push($resultArray, $tempArray);
	}

	//:Finally, encode the array to JSON and output the results
	echo json_encode($resultArray);

}
//:Cose the connection
mysqli_close($conn);

?>