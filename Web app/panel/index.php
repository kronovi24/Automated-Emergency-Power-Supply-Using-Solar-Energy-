<!doctype html>
<html lang="en">

<head>

	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="assets/img/favicon.png" />
	<title>BRGY SERNA SOLAR GENERATOR</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta name="viewport" content="width=device-width" />
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" />
	<link href="assets/css/paper-bootstrap-wizard.css" rel="stylesheet" />
	<link href="assets/css/demo.css" rel="stylesheet" />
	<link href="./porma.css" rel="stylesheet" />
	<link href="https://netdna.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.css" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
	<link href="assets/css/themify-icons.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js">
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</head>

<?php
include "db_conn.php";

$sql = "SELECT *
FROM data ORDER BY id DESC LIMIT 100";
$result = mysqli_query($conn, $sql);


$sql4 = "SELECT count(id) FROM data ";
$result4 = $conn->query($sql4);


while ($row = mysqli_fetch_array($result4)) {
	$newCount = $row['count(id)'];

	if ($newCount > 3000) {
		mysqli_query($conn, "DELETE FROM data LIMIT 2900;");
	} else {

		//echo  SI BATE NAG SIGN OF THE POGI NSAB ,DI MAKAYA KA GWAPO, KALAKAS MU PROGRAM WAY LISOD2x DIHA ?;
	}
}

$sql2 = "SELECT *
FROM control ";
$result2 = mysqli_query($conn, $sql2);

$sql3 = "SELECT *
FROM data ORDER BY id DESC LIMIT 1";
$result3 = mysqli_query($conn, $sql3);

$sql4 = "SELECT *
FROM data ORDER BY id DESC LIMIT 1";
$result4 = mysqli_query($conn, $sql4);


?>

<body href="#account">
	<!--Main  panel -->
	<div class="image-container set-full-height " style="background-image: url('')">
		<!--Refresh button -->
		<a href="" class="made-with-pk">
			<div class="brand"><i class="ti-reload te"></i></div>
			<div class="made-with">MOBILE <strong>CONTROLLER</strong></div>
		</a>
		<!--/Refresh button -->
		<div class="container">
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2">
					<div class="card wizard-card" data-color="blue" id="wizardProfile">
						<!--System Header-->
						<div class="wizard-header text-center">
							<h3 class="wizard-title"><b>Barangay Serna Surigao City</b></h3>
							<p class="category"><b>Solar Energy Powered Emergency Power Supply with IOT based
									Monitoring and Controller Mobile App</b></p>
						</div>
						<!--/System Header-->
						<div class="wizard-navigation">
							<div class="progress-with-circle">
								<div class="progress-bar" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="3" style="width: 21%;"></div>
							</div>
							<!--Navigator-->
							<ul>
								<!--Webpage Reload Script-->
								<script>
									function ManualRefresh() {
										window.location.reload();
									}
								</script>
								<!--/Webpage Reload Script-->
								<li>
									<a href="#about" data-toggle="tab">
										<div class="icon-circle">
											<i class="ti-layout-grid4"></i>
										</div>
										CONTROLLER
									</a>
								</li>
								<li>
									<a href="#account" data-toggle="tab">
										<div class="icon-circle">
											<i class="ti-signal"></i>
										</div>
										MONITORING
									</a>
								</li>
							</ul>
							<!--/Navigator-->
						</div>
						<div class="tab-content">
							<div class="tab-pane" id="account" href>
								<div class="row">
									<!--Header-->
									<h5 class="info-text"> SYSTEM INFORMATION</h5>
									<!--/Header-->
									<div class="col-sm-12
									">
										<div class="form-group text-center">
											<!--Weather Forecast-->
											<h2><i class="fa fa-map-marker"></i> <span id="location"></span></h2>
											<h6 id="weather"></h6>
											<h4><span id="temp"></span><sup>o</sup>C</h4>
											<labe style="text-align: center;">BARANGAY SERNA WEATHER UPDATE</label>
												<img id="icon" src="">
												<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
												<script type="text/javascript">
													link = "https://api.openweathermap.org/data/2.5/weather?q=Surigao City, Surigao del Norte&appid=a67e8b781d0fc9d6036cc923d5b3c26d";
													var request = new XMLHttpRequest();
													request.open('GET', link, true);
													request.onload = function() {
														var obj = JSON.parse(this.response);
														console.log(obj);

														document.getElementById('weather').innerHTML = obj.weather[0].description;
														document.getElementById('location').innerHTML = obj.name;
														document.getElementById('temp').innerHTML = obj.main.temp - 273.15;
														document.getElementById('icon').src = "http://openweathermap.org/img/w/" + obj.weather[0].icon + ".png";

														if (request.status >= 200 && request.status < 400) {
															var temp = obj.main.temp;
														} else {
															console.log("Internet Doesn`t Occur");
														}
													}
													request.send();
												</script>
												<!--/Weather Forecast-->
										</div>
										<!--System Info-->
									</div>
								</div>
								<!--Card-->
								<?php
								if ($result2) {
									while ($row = mysqli_fetch_assoc($result2)) {
										$panel_button = $row['panel_button'];
										$ac_button = $row['ac_button'];
										$auto_button = $row['auto_button'];
										$dc_button = $row['dc_button'];
									}
								}
								?>
								<div class="row">
									<div class="col-md-6 col-xl-3">
										<div class="card bg-c-blue order-card">
											<div class="card-block">
												<h3 class="m-b-20 text-center">CONTROLLER INFORMATION</h3>
												<h6 class="text-center"><b>PANEL POWER : </b>
													<?php
													$cinfoPanel = $panel_button;
													echo "<span style='color:black;'>" . $cinfoPanel . "</span>";
													?>
												</h6>
												<h6 class="text-center"><b>AUTO SWITCH POWER : </b>
													<?php
													$cinfoPanel1 = $auto_button;
													echo "<span style='color:black;'>" . $cinfoPanel1 . "</span>";
													?>
													</br>
												</h6>
												<h6 class="text-center"><b>DC POWER : </b>
													<?php
													$cinfoPanel2 = $dc_button;
													echo "<span style='color:black;'>" . $cinfoPanel2 . "</span>";
													?>
													</br>
												</h6>
												<h6 class="text-center"><b>AC POWER : </b>
													<?php
													$cinfoPanel3 = $ac_button;
													echo "<span style='color:black;'>" . $cinfoPanel3 . "</span>";
													?>
												</h6>

											</div>
										</div>
									</div>

									<div class="col-md-6 col-xl-3">
										<div class="card bg-c-green order-card">
											<div class="card-block">
												<h3 class="m-b-20 text-center">BATTERY PERCENTAGE</h3>
												<h2 class="text-center"><i class="fa fa-battery-full f-left"></i>
													<?php
													if ($result3) {
														while ($row = mysqli_fetch_assoc($result3)) {
															$battery_voltage = $row['battery_voltage'];
														}
													}
													$max_x = 1.9;
													$max_volts = 12.6;
													$min_volts = 10.7;
													$current_volts = $battery_voltage;
													$x = ($current_volts) - ($min_volts);
													$y = (($x / $max_x) * 100) | 0;
													if ($y < 0) {
														echo "<span style='color:white;'>" . "0" . "</span>";
													} else {
														echo "<span style='color:white;'>" . $y . "</span>";
													}

													?>
													%</h2>
												<p>&nbsp</p>
												<p>&nbsp</p>
											</div>
										</div>
									</div>


									<div class="col-md-12 col-xl-3">
										<div class="card bg-c-yellow order-card">
											<div class="card-block">
												<h3 class="m-b-20 text-center">SURNECO CURRENT DETECTION </h3>
												<h2 class="text-center">
													<?php
													if ($result4) {
														while ($row = mysqli_fetch_assoc($result4)) {
															$ac_detect = $row['ac_detect'];
														}
													}
													if ($ac_detect == "true") {
														echo "<span style='color:white;'>CURRENT IS DETECTED</span>";
													} else {
														echo "<span style='color:RED;'>NO ELECTRIC CURRENT OCCUR ! </span>";
													}
													?>
												</h2>

											</div>
										</div>
									</div>


									<div class="col-md-12 text-center">
										<?php
										include "db_conn.php";
										$query = $conn->query("
												SELECT 
												battery_voltage as batVolt,
											   battery_amps as batAmps
											  FROM data LIMIT 10
  ");

										foreach ($query as $data) {
											$batVolt[] = $data['batVolt'];
											$batAmps[] = $data['batAmps'];
										}

										?>
										<canvas id="myChart"></canvas>
									</div>
									<script>
										// === include 'setup' then 'config' above ===
										const labels = <?php echo json_encode($batVolt) ?>;
										const data = {
											labels: labels,
											datasets: [{
												label: 'VOLTAGE PER AMPS ( GRAPHICAL ILLUSTRATION )',
												data: <?php echo json_encode($batAmps) ?>,
												backgroundColor: [
													'rgba(255, 99, 132, 0.2)',
													'rgba(255, 159, 64, 0.2)',
													'rgba(255, 205, 86, 0.2)',
													'rgba(75, 192, 192, 0.2)',
													'rgba(54, 162, 235, 0.2)',
													'rgba(153, 102, 255, 0.2)',
													'rgba(201, 203, 207, 0.2)'
												],
												borderColor: [
													'rgb(255, 99, 132)',
													'rgb(255, 159, 64)',
													'rgb(255, 205, 86)',
													'rgb(75, 192, 192)',
													'rgb(54, 162, 235)',
													'rgb(153, 102, 255)',
													'rgb(201, 203, 207)'
												],
												borderWidth: 5
											}]
										};

										const config = {
											type: 'line',
											data: data,
											options: {
												scales: {
													y: {
														beginAtZero: true
													}
												}
											},
										};

										var myChart = new Chart(
											document.getElementById('myChart'),
											config
										);
									</script>
								</div>

								<!--/Card-->
								<!--/System Info-->
								<!--Table-->
								<div class="form-group" style="text-align:center;">
									<br>
									<br>
									<label">
										<b>TABLE OF SYSTEM INFORMATION</b>
										</label>
								</div>

								<div class="table-responsive" style=" height: 400px; overflow: scroll;">
									<table class="table table-responsive table-borderless">

										<thead>
											<tr class="bg-light">
												<th scope="col" width="auto">ID</th>
												<th scope="col" width="auto">PANEL AMPS</th>
												<th scope="col" width="auto">BATTERY VOLTAGE</th>
												<th scope="col" width="auto">BATTERY AMPS</th>
												<th scope="col" width="auto">WATTAGE</th>
												<th scope="col" width="auto">AC DETECTED</th>
												<th scope="col" width="auto">DATE</th>

											</tr>
										</thead>
										<tbody>
											<?php
											if ($result) {
												while ($row = mysqli_fetch_assoc($result)) {
													$ID = $row['ID'];
													$panel_amps = $row['panel_amps'];
													$battery_voltage = $row['battery_voltage'];
													$battery_amps = $row['battery_amps'];
													$wattage = $row['wattage'];
													$ac_detect = $row['ac_detect'];
													$cur_date = $row['cur_date'];
													echo
													'<tr>
										  <td>' . $ID . '</td>
										  <td>' . $panel_amps . '</td>
										  <td>' . $battery_voltage . '</td>
										  <td>' . $battery_amps . '</td>
										  <td>' . $wattage . '</td>
										  <td>' . $ac_detect . '</td>
										  <td>' . $cur_date . '</td>
										  </tr>';
												}
											}
											?>
										</tbody>
									</table>
								</div>
								<!--/Table-->
							</div>
							<!--Conttoller-->
							<div class="tab-pane" id="about">
								<div class="row">
									<div class="col-sm-8 col-sm-offset-2">
										<br>
										<br>
										<?php
										if ($result2) {
											while ($row = mysqli_fetch_assoc($result2)) {
												$panel_button = $row['panel_button'];
												$ac_button = $row['ac_button'];
												$auto_button = $row['auto_button'];
												$dc_button = $row['dc_button'];
											}
										}
										?>
										<form role="form" action="" name="formR" method="post">
											<div class="card bg-c-blue order-card">
												<div class="card-block">
													<b>
														<h5 class="m-b-20 text-center"><i class="fa fa-cog fa-spin fa-3x fa-fw f-center"></i>PANEL SWITCH</h5>
													</b>
													<h2 class="text-center"><span>POWERED <?php

																							$value = $panel_button;
																							if ($value == "ON") {
																								echo "<span style='color:yellow;'>" . $value . "</span>";
																							} else
																								echo "<span style='color:red;'>" . $value . "</span>";
																							?>
														</span></h2>

													<button type="submit" name="paneloff" style="color:white;" class="btn-lg btn-danger f-right">OFF</button>
													<button type="submit" name="panelon" style="color:white;" class="btn-lg btn-success f-right">ON</button>
												</div>
											</div>
											<?php
											if (isset($_POST['paneloff'])) {
												include "db_conn.php";
												$value1 = $auto_button;
												$value2 = $dc_button;
												$value3 = $ac_button;
												mysqli_query($conn, "INSERT INTO `control` (`ID`, `dc_button`, `ac_button`, `auto_button`, `panel_button`) VALUES (NULL,'" . $value2 . "','" . $value3 . "', '" . $value1 . "', 'OFF')");
												echo '  <script>window.location = "index.php";</script>';
											}
											if (isset($_POST['panelon'])) {
												include "db_conn.php";
												$value1 = $auto_button;
												$value2 = $dc_button;
												$value3 = $ac_button;
												mysqli_query($conn, "INSERT INTO `control` (`ID`, `dc_button`, `ac_button`, `auto_button`, `panel_button`) VALUES (NULL,'" . $value2 . "','" . $value3 . "', '" . $value1 . "', 'ON')");
												echo '  <script>window.location = "index.php";</script>';
											}
											?>
										</form>
										<form role="form" action="" name="formR" method="post">
											<div class="card bg-c-blue order-card">
												<div class="card-block">
													<b>
														<h5 class="m-b-20 text-center"><i class="fa fa-cog fa-spin fa-3x fa-fw f-center"></i>AUTO SWITCH</h5>
													</b>
													<h2 class="text-center"><span>POWERED <?php

																							$value = $auto_button;
																							if ($value == "ON") {
																								echo "<span style='color:yellow;'>" . $value . "</span>";
																							} else
																								echo "<span style='color:red;'>" . $value . "</span>";
																							?>
														</span></h2>

													<button type="submit" name="tautoff" style="color:white;" class="btn-lg btn-danger f-right">OFF</button>
													<button type="submit" name="tauton" style="color:white;" class="btn-lg btn-success f-right">ON</button>
												</div>
											</div>
											<?php
											if (isset($_POST['tautoff'])) {
												include "db_conn.php";
												$tvalue1 = $panel_button;
												$tvalue2 = $dc_button;
												$tvalue3 = $ac_button;
												mysqli_query($conn, "INSERT INTO `control` (`ID`, `dc_button`, `ac_button`, `auto_button`, `panel_button`) VALUES (NULL,'" . $tvalue2 . "','" . $tvalue3 . "', 'OFF', '" . $tvalue1 . "')");
												echo '  <script>window.location = "index.php";</script>';
											}
											if (isset($_POST['tauton'])) {
												include "db_conn.php";
												$tvalue1 = $panel_button;
												$tvalue2 = $dc_button;
												$tvalue3 = $ac_button;
												mysqli_query($conn, "INSERT INTO `control` (`ID`, `dc_button`, `ac_button`, `auto_button`, `panel_button`) VALUES (NULL,'" . $tvalue2 . "','" . $tvalue3 . "', 'ON', '" . $tvalue1 . "')");
												echo '  <script>window.location = "index.php";</script>';
											}
											?>
										</form>
										<form role="form" action="" name="formR" method="post">
											<div class="card bg-c-blue order-card">
												<div class="card-block">
													<b>
														<h5 class="m-b-20 text-center"><i class="fa fa-cog fa-spin fa-3x fa-fw f-center"></i>AC SWITCH</h5>
													</b>
													<h2 class="text-center"><span>POWERED <?php

																							$value = $ac_button;
																							if ($value == "ON") {
																								echo "<span style='color:yellow;'>" . $value . "</span>";
																							} else
																								echo "<span style='color:red;'>" . $value . "</span>";
																							?>
														</span></h2>

													<button type="submit" name="tacoff" style="color:white;" class="btn-lg btn-danger f-right">OFF</button>
													<button type="submit" name="tacon" style="color:white;" class="btn-lg btn-success f-right">ON</button>
												</div>
											</div>
											<?php
											if (isset($_POST['tacoff'])) {
												include "db_conn.php";
												$ttvalue1 = $auto_button;
												$ttvalue2 = $dc_button;
												$ttvalue3 = $panel_button;
												mysqli_query($conn, "INSERT INTO `control` (`ID`, `dc_button`, `ac_button`, `auto_button`, `panel_button`) VALUES (NULL,'" . $ttvalue2 . "','OFF', '" . $ttvalue1 . "', '" . $ttvalue3 . "')");
												echo '  <script>window.location = "index.php";</script>';
											}
											if (isset($_POST['tacon'])) {
												include "db_conn.php";
												$ttvalue1 = $auto_button;
												$ttvalue2 = $dc_button;
												$ttvalue3 = $panel_button;
												mysqli_query($conn, "INSERT INTO `control` (`ID`, `dc_button`, `ac_button`, `auto_button`, `panel_button`) VALUES (NULL,'" . $ttvalue2 . "','ON', '" . $ttvalue1 . "', '" . $ttvalue3 . "')");
												echo '  <script>window.location = "index.php";</script>';
											}
											?>
										</form>
										<form role="form" action="" name="formR" method="post">
											<div class="card bg-c-blue order-card">
												<div class="card-block">
													<b>
														<h5 class="m-b-20 text-center"><i class="fa fa-cog fa-spin fa-3x fa-fw f-center"></i>DC SWITCH</h5>
													</b>
													<h2 class="text-center"><span>POWERED <?php

																							$value = $dc_button;
																							if ($value == "ON") {
																								echo "<span style='color:yellow;'>" . $value . "</span>";
																							} else
																								echo "<span style='color:red;'>" . $value . "</span>";
																							?>
														</span></h2>

													<button type="submit" name="tdcoff" style="color:white;" class="btn-lg btn-danger f-right">OFF</button>
													<button type="submit" name="tdcon" style="color:white;" class="btn-lg btn-success f-right">ON</button>
												</div>
											</div>
											<?php
											if (isset($_POST['tdcoff'])) {
												include "db_conn.php";
												$tttvalue1 = $auto_button;
												$tttvalue2 = $ac_button;
												$tttvalue3 = $panel_button;
												mysqli_query($conn, "INSERT INTO `control` (`ID`, `dc_button`, `ac_button`, `auto_button`, `panel_button`) VALUES (NULL,'OFF','" . $tttvalue2 . "', '" . $tttvalue1 . "', '" . $tttvalue3 . "')");
												echo '  <script>window.location = "index.php";</script>';
											}
											if (isset($_POST['tdcon'])) {
												include "db_conn.php";
												$tttvalue1 = $auto_button;
												$tttvalue2 = $ac_button;
												$tttvalue3 = $panel_button;
												mysqli_query($conn, "INSERT INTO `control` (`ID`, `dc_button`, `ac_button`, `auto_button`, `panel_button`) VALUES (NULL,'ON','" . $tttvalue2 . "', '" . $tttvalue1 . "', '" . $tttvalue3 . "')");
												echo '  <script>window.location = "index.php";</script>';
											}
											?>
										</form>
									</div>
								</div>
							</div>
							<!--/Conttoller-->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--/Main  panel -->
	</div>
</body>


<!--Buttom Script for program delay purposes-->
<script src="assets/js/jquery-2.2.4.min.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/js/jquery.bootstrap.wizard.js" type="text/javascript"></script>
<script src="assets/js/demo.js" type="text/javascript"></script>
<script src="assets/js/paper-bootstrap-wizard.js" type="text/javascript"></script>
<script src="assets/js/jquery.validate.min.js" type="text/javascript"></script>
<!--/Buttom Script for program delay purposes-->

</html>