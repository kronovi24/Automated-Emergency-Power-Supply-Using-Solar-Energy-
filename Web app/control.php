<?php
$servername = "fdb32.awardspace.net";
$dbname = "4134541_monitoring";
$username = "4134541_monitoring";
$password = "#iSl6Knw7XhUY3},";


$dc_button = "";
$ac_button = "";
$panel_button = "";
$auto_button = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    

    $dc_button = test_input($_POST["dc_button"]);
    $ac_button = test_input($_POST["ac_button"]);
    $panel_button = test_input($_POST["panel_button"]);
    $auto_button = test_input($_POST["auto_button"]);
    
   
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    
    $sql = "INSERT INTO control (dc_button, ac_button , panel_button, auto_button)
    VALUES ('" . $dc_button . "' , '" . $ac_button . "' , '" . $panel_button . "'  , '" . $auto_button . "')";
    
    
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } 
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    

}
else {
    echo "No data posted with HTTP POST.";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>