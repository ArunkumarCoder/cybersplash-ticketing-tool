<?php
/**
 * Autoloading 
 */
spl_autoload_register(function ($class) {
	$class_name_parts = explode('\\', $class);
	$class_name = $class_name_parts[1];
	$classs_file = $class_name . '.php';
	if (file_exists($classs_file)) {
		include $classs_file;
	}
});
// $dbConn="";
// require_once('Database.php');

// print_r(PDO::getAvailableDrivers());
// $t = new Ticket\Ticketing();
$p=new Db\Database();
// $h= $p->connection("localhost", "ticketing_app", "root", "");
// $t->username = 'user';
// $t->password = 'password';

print_r($p->connection());
// print_r($p->runQuery());
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Ticketing App</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body>
	<?php
		$g=$p->runQuery("SELECT * FROM details");
		print_r($g->fetch(PDO::FETCH_ASSOC));
	?>

	<nav class="navbar navbar-light bg-light">
		<div class="container-fluid">
			<span class="navbar-brand mb-0 h1">Ticketing App</span>
		</div>
	</nav>
	<br>

	<div class="container">
		<div class="col-md-6">
			<form action="" method="POST">
				<table class="table table-bordered table-striped">
					<tbody>
						<tr>
							<th>Bus Number:</th>
							<td><?php echo $bus_number; ?></td>
						</tr>
						<tr>
							<th>Minimum Amount:</th>
							<td><?php echo $minimum_amount; ?></td>
						</tr>
						<tr>
							<th>Trip:</th>
							<td><?php echo $trip; ?></td>
						</tr>
						<tr>
							<th>Destination From:</th>
							<td>
								<select class="form-select" id="destination_from" name="destination_from">
									<option value="">-- Select --</option>
									<?php foreach ($data as $key_df => $df) {
										echo '<option value="' . $key_df . '">' . $df["place_name"] . '</option>';
									} ?>
								</select>
							</td>
						</tr>
						<tr>
							<th>Destination To:</th>
							<td>
								<select class="form-select" id="destination_to" name="destination_to">
									<option value="">-- Select --</option>
									<?php foreach ($data as $key_dt => $dt) {
										echo '<option value="' . $key_dt . '">' . $dt["place_name"] . '</option>';
									} ?>
								</select>
							</td>
						</tr>
						<tr>
							<th>Number of People:</th>
							<td>
								<input type="number" class="form-control" id="people_count" name="people_count">
							</td>
						</tr>
						<tr>
							<td>
							</td>
							<td>
								<button type="submit" class="btn btn-success" name="print-btn">Print</button>
								<button type="reset" class="btn btn-info">Clear</button>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>

		<?php
		if (isset($_REQUEST['print-btn'])) {
			$errors = array();

			$destination_from = (isset($_POST['destination_from']) && $_POST['destination_from'] != "") ? htmlspecialchars($_POST['destination_from'], ENT_QUOTES, 'UTF-8') : "";
			$destination_to = (isset($_POST['destination_to']) && $_POST['destination_to'] != "") ? htmlspecialchars($_POST['destination_to'], ENT_QUOTES, 'UTF-8') : "";
			$people_count = (isset($_POST['people_count']) && $_POST['people_count'] != "") ? htmlspecialchars($_POST['people_count'], ENT_QUOTES, 'UTF-8') : "";

			/* Error Message */
			if ($destination_from == "") {
				$errors[] = "Destination from should not be empty";
			}

			if ($destination_to == "") {
				$errors[] = "Destination to should not be empty";
			}

			if ($people_count == "") {
				$errors[] = "People count should not be empty";
			}

			if (!empty($errors)) {
				$errors = implode("<br>", $errors);
				echo "<br>" . $errors;
				die();
			} else {

				if ($destination_from >= $destination_to) {
					echo "Invalid Selection";
					die();
				} else {
					$get_travel_distance = $destination_to - $destination_from;
					$get_travel_fare_per_person = $get_travel_distance * $minimum_amount;
					$total_amount_calculated = $people_count * $get_travel_fare_per_person;
					$destination_from_place_name = $data[$destination_from]['place_name'];
					$destination_to_place_name = $data[$destination_to]['place_name'];
					
					for ($i = $destination_from; $i < $destination_to; $i++) {
						$total_km += (int) $data[$i]['km'];
					}

					echo '<table class="table table-bordered table-condensed">
						<tbody>
							<tr>
								<th class="text-center" colspan="2">BUS TICKET</th>
							</tr>
							<tr>
								<th>Bus Number:</th>
								<td>' . $bus_number . '</td>
							</tr>
							<tr>
								<th>Destination:</th>
								<td>' . $destination_from_place_name . ' To ' . $destination_to_place_name  . '</td>
							</tr>
							<tr>
								<th>No of Person:</th>
								<td>' . $people_count . '</td>
							</tr>
							<tr>
								<th>Total Distance:</th>
								<td>' . $total_km . ' KM</td>
							</tr>
							<tr>
								<th>Total Fare: (' . $get_travel_fare_per_person . ' * ' . $people_count . ' )</th>
								<td>' . $total_amount_calculated . '/-</td>
							</tr>
							<tr>
								<th class="text-center" colspan="2">LIABLE FOR INSPECTION</th>
							</tr>
							<tr>
								<th class="text-center" colspan="2">NOT TRANSFERABLE</th>
							</tr>
						</tbody>
					</table>';
				}
			}
		}
		?>
	</div>
</body>

</html>