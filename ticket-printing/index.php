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

$ticket = new Ticket\Ticketing();
$details = $ticket->get_details();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$ticket->ticket_calculate();
	die();
}
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
							<td><?php echo $ticket->get_bus_number(); ?></td>
						</tr>
						<tr>
							<th>Trip:</th>
							<td><?php echo $ticket->get_trip(); ?></td>
						</tr>
						<tr>
							<th>Destination From:</th>
							<td>
								<select class="form-select" id="destination_from" name="destination_from">
									<option value="">-- Select --</option>
									<?php foreach ($details as $key => $val) {
										echo '<option value="' . $key . '">' . $val["place_name"] . '</option>';
									} ?>
								</select>
							</td>
						</tr>
						<tr>
							<th>Destination To:</th>
							<td>
								<select class="form-select" id="destination_to" name="destination_to">
									<option value="">-- Select --</option>
									<?php foreach ($details as $key => $val) {
										echo '<option value="' . $key . '">' . $val["place_name"] . '</option>';
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

	</div>
</body>

</html>