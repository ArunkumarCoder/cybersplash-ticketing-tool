<?php
namespace Db;

class Database
{
	private $dbHost = "localhost";
	private $dbName = "ticketing_app";
	private $dbUser = "root";
	private $dbPassword = "";
	private $dbConn;

	public function __construct()
	{
		try {
			$this->dbConn = new \PDO("mysql:host=$this->dbHost;dbname=$this->dbName", $this->dbUser, $this->dbPassword);
		} catch(Exception $e) {
			echo "Connection failed" . $e->getMessage();  
		}
	}

	public function getDB(){
        return $this->dbConn;
    }
}
