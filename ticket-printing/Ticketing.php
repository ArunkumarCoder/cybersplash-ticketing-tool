<?php
namespace Ticket;
use Db;

class Ticketing
{
	private $bus_number = "KL 02 B 2255";
	private $trip = "Kollam -> Paravur";
	// private $minimum_amount = 10;
	private $total_km = 0;
	private $db;

	public function __construct()
	{
		$this->db = new Db\Database();
	}

	public function get_bus_number()
	{
		return $this->bus_number;
	}

	public function get_trip()
	{
		return $this->trip;
	}

	// public function get_minimum_amount()
	// {
	// 	return $this->minimum_amount;
	// }

	public function get_total_km()
	{
		return $this->total_km;
	}

	public function get_details()
    {
    	$get_data = $this->db->getDB()->query("SELECT * FROM details");
    	return $get_data->fetchAll();
    }

    public function ticket_calculate()
    {
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
					$data = $this->get_details();
					$total_km = 0;
					$total_rate = 0;
					$destination_from_place_name = $data[$destination_from]['place_name'];
					$destination_to_place_name = $data[$destination_to]['place_name'];
					
					for ($i = $destination_from; $i < $destination_to; $i++) {
						$total_km += (int) $data[$i]['distance'];
						$total_rate += (int) $data[$i]['rate'];
					}

					$total_amount_calculated = (int) $people_count * (int) $total_rate;

					echo '<table class="table table-bordered table-condensed">
						<tbody>
							<tr>
								<th class="text-center" colspan="2">BUS TICKET</th>
							</tr>
							<tr>
								<th>Bus Number:</th>
								<td>' . $this->bus_number . '</td>
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
								<th>Total Fare: (' . $total_rate . ' * ' . $people_count . ' )</th>
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
    }
}