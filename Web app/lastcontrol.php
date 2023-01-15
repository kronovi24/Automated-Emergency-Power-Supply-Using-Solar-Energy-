 <?php 
 

	
    $servername = "fdb32.awardspace.net";
    $dbname = "4134541_monitoring";
    $username = "4134541_monitoring";
    $password = "#iSl6Knw7XhUY3},";
    
   

    $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        
        $sql = "SELECT * FROM control order by ID desc limit 1";
        $result = $conn->query($sql);
        $list=[];
        if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
                $list[]=[
                    'ID' => $row["ID"],
                    'dc_button' =>$row["dc_button"],
                    'ac_button' =>$row["ac_button"],
                    'panel_button' =>$row["panel_button"],
                    'auto_button' =>$row["auto_button"],
                   
                    
                ];
          }
        } else {
          //Send blank info if no records 
            $list[]=[
                'ID' => $row["ID"],
                'dc_button' =>'',
                'ac_button' =>'',
                'panel_button' =>'',
                'auto_button' =>'',
        
            ]; 
        }
        $conn->close();

        echo json_encode($list);
    

?>