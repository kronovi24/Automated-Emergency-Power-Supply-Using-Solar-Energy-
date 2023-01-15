 <?php 
 

	
    $servername = "fdb32.awardspace.net";
    $dbname = "4134541_monitoring";
    $username = "4134541_monitoring";
    $password = "#iSl6Knw7XhUY3},";
    
   

    $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        
        $sql = "SELECT * FROM data order by ID desc limit 1";
        $result = $conn->query($sql);
        $list=[];
        if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
                $list[]=[
                    'ID' => $row["ID"],
                    'Panel_Voltage' =>$row["panel_voltage"],
                    'Panel_amps' =>$row["panel_amps"],
                    'Battery_Voltage' =>$row["battery_voltage"],
                    'Battery_amps' =>$row["battery_amps"],
                    'Wattage' =>$row["wattage"],
                    'Ac Detect' =>$row["ac_detect"],
                    
                ];
          }
        } else {
          //Send blank info if no records 
            $list[]=[
                'ID' => '',
                'Panel_Voltage' =>'',
                'Panel_amps' =>'',
                'Battery_Voltage' =>'',
                'Battery_amps' =>'',
                'Wattage' =>'',
                'Ac Detect' =>'',
            ]; 
        }
        $conn->close();

        echo json_encode($list);
    

?>