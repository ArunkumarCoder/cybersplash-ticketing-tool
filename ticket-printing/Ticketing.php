<?php
namespace Ticket;

class Ticketing
{
	private $email;
	private $bus_number = "KL 02 B 2255";
	private $trip = "Kollam -> Paravur";
	private $minimum_amount = 42;
	private $total_km = 0;

	public function __construct()
	{
		// $this->email = $email;
		echo 'Hai';
	}

	public function getEmail()
	{
		return $this->email;
	}
}