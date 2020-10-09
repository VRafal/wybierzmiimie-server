<?php
class db
{
	public function connect()
	{
		$mysql_connect_str = "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_DATABASE'];
		$dbConnection = new PDO($mysql_connect_str, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $dbConnection;
	}
}
