<?php

namespace App\Core;

class Model
{

	private static $conexao;

	public static function getConn()
	{

		$host = $_ENV["DB_HOST"];
		$user = $_ENV["DB_USER"];
		$password = $_ENV["DB_PASS"];
		$dbname = $_ENV["DB_NAME"];
		$port = $_ENV["DB_PORT"];

		if (!isset(self::$conexao)) {
			self::$conexao = new \PDO(
				"mysql:host=$host;port=$port;dbname=$dbname;",
				$user,
				$password
			);
		}
		return self::$conexao;
	}
}
