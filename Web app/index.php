<?php
$servername = "fdb32.awardspace.net";
$dbname = "4134541_monitoring";
$username = "4134541_monitoring";
$password = "#iSl6Knw7XhUY3},";


$panel_voltage = "" ; 
$panel_amps = "";
$battery_voltage = "";
$battery_amps = "";
$wattage = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    

    $panel_voltage = test_input($_POST["panel_voltage"]);
    $panel_amps = test_input($_POST["panel_amps"]);
    $battery_voltage = test_input($_POST["battery_voltage"]);
    $battery_amps = test_input($_POST["battery_amps"]);
    $wattage = test_input($_POST["wattage"]);
    $ac_detect = test_input($_POST["ac_detect"]);
    
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    
    $sql = "INSERT INTO data (panel_voltage, panel_amps, battery_voltage, battery_amps, wattage, ac_detect)
    VALUES ('" . $panel_voltage . "', '" . $panel_amps . "','" . $battery_voltage . "', '" . $battery_amps . "', '" . $wattage . "' , '" . $ac_detect . "')";
    
    
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